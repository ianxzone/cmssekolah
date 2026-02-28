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

    public function store(Request $request)
    {
        $request->validate([
            'file' => 'required|file|max:10240', // 10MB max
        ]);

        $file = $request->file('file');
        $originalName = $file->getClientOriginalName();
        $fileName = pathinfo($originalName, PATHINFO_FILENAME);
        $extension = $file->getClientOriginalExtension();

        $safeFileName = Str::slug($fileName) . '-' . time() . '.' . $extension;
        $path = $file->storeAs('media', $safeFileName, 'public');

        $media = Media::create([
            'name' => $originalName,
            'file_name' => $safeFileName,
            'mime_type' => $file->getMimeType(),
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
