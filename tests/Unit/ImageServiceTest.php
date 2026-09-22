<?php

namespace Tests\Unit;

use App\Services\ImageService;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use Tests\TestCase;

class ImageServiceTest extends TestCase
{
    public function test_it_optimizes_large_image_and_converts_to_webp(): void
    {
        Storage::fake('public');

        // 1. Create a dummy large image (2400x1600)
        $img = imagecreatetruecolor(2400, 1600);
        $bg = imagecolorallocate($img, 30, 120, 200);
        imagefilledrectangle($img, 0, 0, 2400, 1600, $bg);

        $tmpFile = tempnam(sys_get_temp_dir(), 'test_opt_') . '.jpg';
        imagejpeg($img, $tmpFile, 95);
        imagedestroy($img);

        $origSize = filesize($tmpFile);
        $uploadedFile = new UploadedFile($tmpFile, 'test-large.jpg', 'image/jpeg', null, true);

        // 2. Process
        $result = ImageService::optimizeAndStore($uploadedFile, 'test_media', 'custom-banner', 1920, 1920, 80);

        // 3. Assertions
        $this->assertTrue($result['is_optimized']);
        $this->assertSame('image/webp', $result['mime_type']);
        $this->assertStringEndsWith('.webp', $result['file_name']);
        $this->assertLessThanOrEqual(1920, $result['width']);
        $this->assertLessThanOrEqual(1920, $result['height']);
        $this->assertLessThanOrEqual($origSize, $result['size']);
        $this->assertTrue(Storage::disk('public')->exists($result['path']));

        @unlink($tmpFile);
    }

    public function test_it_stores_non_image_files_without_modification(): void
    {
        Storage::fake('public');

        $tmpDoc = tempnam(sys_get_temp_dir(), 'test_doc_') . '.pdf';
        file_put_contents($tmpDoc, '%PDF-1.4 dummy pdf content');

        $uploadedDoc = new UploadedFile($tmpDoc, 'document.pdf', 'application/pdf', null, true);

        $result = ImageService::optimizeAndStore($uploadedDoc, 'test_docs', 'my-doc');

        $this->assertFalse($result['is_optimized']);
        $this->assertSame('application/pdf', $result['mime_type']);
        $this->assertStringEndsWith('.pdf', $result['file_name']);
        $this->assertTrue(Storage::disk('public')->exists($result['path']));

        @unlink($tmpDoc);
    }
}
