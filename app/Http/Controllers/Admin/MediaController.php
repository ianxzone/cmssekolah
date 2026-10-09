<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Media;
use App\Services\ImageService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class MediaController extends Controller
{
    public function index(Request $request)
    {
        $media = Media::latest()->paginate(24);
        try {
            return response(view('admin.media.index', compact('media'))->render());
        } catch (\Throwable $e) {
            return response('Error rendering media index: ' . $e->getMessage() . ' in ' . $e->getFile() . ':' . $e->getLine(), 500);
        }
    }

    public function store(Request $request)
    {
        $request->validate([
            'file' => 'required|file|mimes:jpeg,png,jpg,webp,gif,pdf|max:5120', // Safe MIME types, max 5MB
            'alt_text' => 'nullable|string|max:255',
            'title' => 'nullable|string|max:255',
            'caption' => 'nullable|string',
            'description' => 'nullable|string',
        ]);

        try {
            $file = $request->file('file');
            $originalName = $file->getClientOriginalName();
            $fileName = pathinfo($originalName, PATHINFO_FILENAME);

            $optimized = ImageService::optimizeAndStore($file, 'media');

            $media = Media::create([
                'name' => $originalName,
                'file_name' => $optimized['file_name'],
                'mime_type' => $optimized['mime_type'],
                'path' => $optimized['path'],
                'disk' => 'public',
                'size' => (int) $optimized['size'],
                'alt_text' => $request->input('alt_text', Str::headline($fileName)),
                'title' => $request->input('title', Str::headline($fileName)),
                'caption' => $request->input('caption'),
                'description' => $request->input('description'),
            ]);

            try {
                \App\Services\SecurityService::logAudit('created', 'media', "Mengupload media: {$originalName}", (string)$media->id);
            } catch (\Throwable $e) {
                // Ignore audit log failures
            }

            if ($request->header('Accept') === 'application/json' || $request->ajax()) {
                return response()->json([
                    'success' => true,
                    'media' => $media,
                    'url' => $media->url,
                    'id' => $media->id,
                    'name' => $media->name,
                    'alt_text' => $media->alt_text,
                    'title' => $media->title,
                    'caption' => $media->caption,
                    'description' => $media->description,
                ]);
            }

            return redirect()->route('admin.media.index')->with('success', 'File uploaded successfully.');

        } catch (\Throwable $e) {
            \Illuminate\Support\Facades\Log::error('Media Upload Error: ' . $e->getMessage(), ['trace' => $e->getTraceAsString()]);
            
            if ($request->header('Accept') === 'application/json' || $request->ajax()) {
                return response()->json([
                    'success' => false,
                    'message' => 'Gagal mengunggah berkas: ' . $e->getMessage()
                ], 500);
            }

            return back()->with('error', 'Gagal mengunggah berkas: ' . $e->getMessage());
        }
    }

    public function apiList(Request $request)
    {
        $search = $request->query('search');
        $query = Media::latest();

        if ($search) {
            $query->where(function ($q) use ($search) {
                $q->where('name', 'like', "%{$search}%")
                  ->orWhere('title', 'like', "%{$search}%")
                  ->orWhere('alt_text', 'like', "%{$search}%")
                  ->orWhere('caption', 'like', "%{$search}%");
            });
        }

        $media = $query->paginate(24);

        return response()->json([
            'data' => $media->items(),
            'current_page' => $media->currentPage(),
            'last_page' => $media->lastPage(),
            'total' => $media->total(),
        ]);
    }

    public function apiUpdate(Request $request, Media $media)
    {
        $validated = $request->validate([
            'alt_text' => 'nullable|string|max:255',
            'title' => 'nullable|string|max:255',
            'caption' => 'nullable|string',
            'description' => 'nullable|string',
        ]);

        $media->update($validated);

        return response()->json([
            'success' => true,
            'message' => 'Metadata media berhasil disimpan.',
            'media' => $media,
        ]);
    }

    public function destroy(Request $request, Media $media)
    {
        if (Storage::disk($media->disk)->exists($media->path)) {
            Storage::disk($media->disk)->delete($media->path);
        }

        $media->delete();

        if ($request->header('Accept') === 'application/json' || $request->ajax()) {
            return response()->json([
                'success' => true,
                'message' => 'File berhasil dihapus.',
            ]);
        }

        return redirect()->route('admin.media.index')->with('success', 'File deleted successfully.');
    }
}
