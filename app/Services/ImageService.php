<?php

namespace App\Services;

use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class ImageService
{
    /**
     * Supported mime types for GD WebP optimization.
     */
    protected const OPTIMIZABLE_MIMES = [
        'image/jpeg',
        'image/jpg',
        'image/webp',
    ];

    /**
     * Optimize an uploaded file if it's an image, or store as-is if it's not.
     *
     * @param UploadedFile $file
     * @param string $directory Directory inside 'public' disk (e.g., 'media', 'posts', 'settings')
     * @param string|null $customBaseName Optional custom base name without extension
     * @param int $maxWidth Maximum width in pixels (default 1920)
     * @param int $maxHeight Maximum height in pixels (default 1920)
     * @param int $quality WebP quality 1-100 (default 82)
     * @return array Result metadata [path, file_name, mime_type, size, is_optimized]
     */
    public static function optimizeAndStore(
        UploadedFile $file,
        string $directory = 'media',
        ?string $customBaseName = null,
        int $maxWidth = 1920,
        int $maxHeight = 1920,
        int $quality = 82
    ): array {
        try {
            $mime = $file->getMimeType();
            $originalName = $file->getClientOriginalName();
            $baseName = $customBaseName ?: Str::slug(pathinfo($originalName, PATHINFO_FILENAME));

            // If not a supported image or GD is missing, store directly as-is
            if (!in_array($mime, self::OPTIMIZABLE_MIMES) || !extension_loaded('gd') || !function_exists('imagewebp')) {
                return self::fallbackStore($file, $directory, $baseName, $mime);
            }

            $sourcePath = $file->getRealPath();
            $srcImage = null;

            // 1. Create GD image resource based on mime type
            switch ($mime) {
                case 'image/jpeg':
                case 'image/jpg':
                    $srcImage = @imagecreatefromjpeg($sourcePath);
                    break;
                case 'image/png':
                    $srcImage = @imagecreatefrompng($sourcePath);
                    break;
                case 'image/webp':
                    $srcImage = @imagecreatefromwebp($sourcePath);
                    break;
            }

            if (!$srcImage) {
                // Fallback to imagecreatefromstring if mime-based loader fails
                $content = @file_get_contents($sourcePath);
                if ($content !== false) {
                    $srcImage = @imagecreatefromstring($content);
                }
            }

            if (!$srcImage) {
                // Cannot load image, fallback to standard store
                return self::fallbackStore($file, $directory, $baseName, $mime);
            }

            // 2. Fix EXIF orientation
            if (function_exists('exif_read_data') && ($mime === 'image/jpeg' || $mime === 'image/jpg')) {
                try {
                    $exif = @exif_read_data($sourcePath);
                    if (!empty($exif['Orientation'])) {
                        switch ($exif['Orientation']) {
                            case 3:
                                $rotated = @imagerotate($srcImage, 180, 0);
                                if ($rotated !== false) { imagedestroy($srcImage); $srcImage = $rotated; }
                                break;
                            case 6:
                                $rotated = @imagerotate($srcImage, -90, 0);
                                if ($rotated !== false) { imagedestroy($srcImage); $srcImage = $rotated; }
                                break;
                            case 8:
                                $rotated = @imagerotate($srcImage, 90, 0);
                                if ($rotated !== false) { imagedestroy($srcImage); $srcImage = $rotated; }
                                break;
                        }
                    }
                } catch (\Throwable $e) { }
            }

            $origWidth = imagesx($srcImage);
            $origHeight = imagesy($srcImage);

            // 3. Calculate target dimensions (maintain aspect ratio)
            $targetWidth = $origWidth;
            $targetHeight = $origHeight;

            if ($origWidth > $maxWidth || $origHeight > $maxHeight) {
                $ratio = min($maxWidth / $origWidth, $maxHeight / $origHeight);
                $targetWidth = (int) max(1, round($origWidth * $ratio));
                $targetHeight = (int) max(1, round($origHeight * $ratio));
            }

            // 4. Create canvas and copy resampled image
            $newImage = @imagecreatetruecolor($targetWidth, $targetHeight);
            if (!$newImage) {
                // Memory limit hit probably, fallback
                imagedestroy($srcImage);
                return self::fallbackStore($file, $directory, $baseName, $mime);
            }

            // Preserve alpha transparency for PNG/WebP
            imagealphablending($newImage, false);
            imagesavealpha($newImage, true);
            $transparent = imagecolorallocatealpha($newImage, 255, 255, 255, 127);
            imagefilledrectangle($newImage, 0, 0, $targetWidth, $targetHeight, $transparent);

            @imagecopyresampled(
                $newImage,
                $srcImage,
                0, 0, 0, 0,
                $targetWidth,
                $targetHeight,
                $origWidth,
                $origHeight
            );

            // 5. Save as optimized WebP file
            $finalFileName = $baseName . '-' . time() . '.webp';
            $relativeDir = trim($directory, '/\\');
            $relativePath = $relativeDir ? $relativeDir . '/' . $finalFileName : $finalFileName;

            // Ensure destination directory exists on public disk
            Storage::disk('public')->makeDirectory($relativeDir);
            $destinationFullPath = Storage::disk('public')->path($relativePath);

            $saved = @imagewebp($newImage, $destinationFullPath, $quality);

            // Free GD resources from memory
            imagedestroy($srcImage);
            imagedestroy($newImage);

            if ($saved && file_exists($destinationFullPath)) {
                return [
                    'path' => $relativePath,
                    'file_name' => $finalFileName,
                    'mime_type' => 'image/webp',
                    'size' => filesize($destinationFullPath),
                    'width' => $targetWidth,
                    'height' => $targetHeight,
                    'is_optimized' => true,
                ];
            }

            // If imagewebp failed, fallback
            return self::fallbackStore($file, $directory, $baseName, $mime);

        } catch (\Throwable $th) {
            // Safe fallback on unexpected failure
            try {
                return self::fallbackStore($file, $directory, $customBaseName ?? 'upload', $file->getMimeType() ?? 'application/octet-stream');
            } catch (\Throwable $fallbackEx) {
                // If even fallback fails, throw a clean exception that doesn't expose internals if possible
                throw new \Exception("Failed to upload image: " . $fallbackEx->getMessage());
            }
        }
    }

    /**
     * Helper to perform standard file store without optimization
     */
    protected static function fallbackStore(UploadedFile $file, string $directory, string $baseName, string $mime): array
    {
        $extension = $file->extension() ?: $file->getClientOriginalExtension() ?: 'png';
        $fileName = $baseName . '-' . time() . '.' . $extension;
        $path = $file->storeAs($directory, $fileName, 'public');

        return [
            'path' => $path,
            'file_name' => $fileName,
            'mime_type' => $mime,
            'size' => $file->getSize(),
            'is_optimized' => false,
        ];
    }
}
