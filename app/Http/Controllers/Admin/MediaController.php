<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Media;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class MediaController extends Controller
{
    public function index(Request $request)
    {
        $media = Media::latest()->paginate(24);
        return view('admin.media.index', compact('media'));
    }

    /**
     * List of allowed MIME types for file uploads
     */
    protected $allowedMimeTypes = [
        // Images
        'image/jpeg',
        'image/png',
        'image/gif',
        'image/webp',
        'image/svg+xml',
        // Documents
        'application/pdf',
        'application/msword',
        'application/vnd.openxmlformats-officedocument.wordprocessingml.document',
        'application/vnd.ms-excel',
        'application/vnd.openxmlformats-officedocument.spreadsheetml.sheet',
        // Text
        'text/plain',
        'text/csv',
    ];

    public function store(Request $request)
    {
        $request->validate([
            'file' => 'required|file|max:10240', // 10MB max
        ]);

        $file = $request->file('file');
        
        // Verify MIME type is allowed
        $mimeType = $file->getMimeType();
        if (!in_array($mimeType, $this->allowedMimeTypes)) {
            return redirect()->back()
                ->withErrors(['file' => 'File type not allowed. Allowed types: Images, PDFs, Documents.'])
                ->withInput();
        }
        
        // Additional security: Check file extension matches MIME type
        $extension = strtolower($file->getClientOriginalExtension());
        $validExtensions = $this->getValidExtensionsForMimeType($mimeType);
        
        if (!in_array($extension, $validExtensions)) {
            return redirect()->back()
                ->withErrors(['file' => 'File extension does not match content type.'])
                ->withInput();
        }
        
        // Check for executable content
        $sampleContent = file_get_contents($file->getRealPath(), false, null, 0, 512);
        if ($this->containsExecutableContent($sampleContent)) {
            return redirect()->back()
                ->withErrors(['file' => 'File contains suspicious executable content.'])
                ->withInput();
        }
        
        $originalName = $file->getClientOriginalName();
        $fileName = pathinfo($originalName, PATHINFO_FILENAME);
        
        // Sanitize filename
        $safeFileName = Str::slug($fileName) . '-' . time() . '.' . $extension;
        $path = $file->storeAs('media', $safeFileName, 'public');

        $media = Media::create([
            'name' => $originalName,
            'file_name' => $safeFileName,
            'mime_type' => $mimeType,
            'path' => $path,
            'disk' => 'public',
            'size' => $file->getSize(),
        ]);

        if ($request->header('Accept') === 'application/json' || $request->ajax()) {
            return response()->json([
                'url' => Storage::disk('public')->url($path),
                'id' => $media->id,
                'name' => $media->name
            ]);
        }

        return redirect()->route('admin.media.index')->with('success', 'File uploaded successfully.');
    }
    
    /**
     * Get valid file extensions for a given MIME type
     */
    protected function getValidExtensionsForMimeType(string $mimeType): array
    {
        $mapping = [
            'image/jpeg' => ['jpg', 'jpeg'],
            'image/png' => ['png'],
            'image/gif' => ['gif'],
            'image/webp' => ['webp'],
            'image/svg+xml' => ['svg'],
            'application/pdf' => ['pdf'],
            'application/msword' => ['doc'],
            'application/vnd.openxmlformats-officedocument.wordprocessingml.document' => ['docx'],
            'application/vnd.ms-excel' => ['xls'],
            'application/vnd.openxmlformats-officedocument.spreadsheetml.sheet' => ['xlsx'],
            'text/plain' => ['txt'],
            'text/csv' => ['csv'],
        ];
        
        return $mapping[$mimeType] ?? [];
    }
    
    /**
     * Check if content contains executable signatures
     */
    protected function containsExecutableContent(string $content): bool
    {
        $executableSignatures = [
            '<?php',
            '<script language="php">',
            '#!/usr/bin/perl',
            '#!/usr/bin/python',
            '#!/bin/bash',
            'MZ', // DOS/Windows executable
        ];
        
        foreach ($executableSignatures as $signature) {
            if (strpos($content, $signature) !== false) {
                return true;
            }
        }
        
        return false;
    }

    public function apiList(Request $request)
    {
        $search = $request->query('search');
        $query = Media::latest();

        if ($search) {
            $query->where('name', 'like', "%{$search}%");
        }

        $media = $query->paginate(20);

        return response()->json([
            'data' => $media->items(),
            'current_page' => $media->currentPage(),
            'last_page' => $media->lastPage(),
        ]);
    }

    public function show(Media $media)
    {
        return response()->json([
            'id' => $media->id,
            'name' => $media->name,
            'alt_text' => $media->alt_text,
            'caption' => $media->caption,
            'url' => Storage::disk($media->disk)->url($media->path),
            'mime_type' => $media->mime_type,
            'size' => number_format($media->size / 1024, 2) . ' KB',
            'created_at' => $media->created_at->format('Y-m-d H:i:s'),
        ]);
    }

    public function update(Request $request, Media $media)
    {
        $request->validate([
            'alt_text' => 'nullable|string|max:255',
            'caption' => 'nullable|string',
        ]);

        $media->update([
            'alt_text' => $request->alt_text,
            'caption' => $request->caption,
        ]);

        return response()->json(['success' => true, 'message' => 'Media updated successfully.']);
    }

    public function destroy(Media $media)
    {
        if (Storage::disk($media->disk)->exists($media->path)) {
            Storage::disk($media->disk)->delete($media->path);
        }

        $media->delete();

        return redirect()->route('admin.media.index')->with('success', 'File deleted successfully.');
    }
}
