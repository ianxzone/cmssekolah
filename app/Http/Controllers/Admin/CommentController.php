<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\PostComment;
use Illuminate\Http\Request;

class CommentController extends Controller
{
    /**
     * Display a listing of comments with moderation filters.
     */
    public function index(Request $request)
    {
        $query = PostComment::with('post');

        // Status filtering
        $status = $request->query('status', '');
        if ($status !== '' && in_array($status, ['pending', 'approved', 'spam', 'rejected'])) {
            $query->where('status', $status);
        }

        // Search keyword
        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function ($q) use ($search) {
                $q->where('name', 'like', "%{$search}%")
                  ->orWhere('email', 'like', "%{$search}%")
                  ->orWhere('phone', 'like', "%{$search}%")
                  ->orWhere('content', 'like', "%{$search}%");
            });
        }

        $comments = $query->latest()->paginate(15);

        // Counts for filter pills
        $counts = [
            'all'      => PostComment::count(),
            'pending'  => PostComment::where('status', 'pending')->count(),
            'approved' => PostComment::where('status', 'approved')->count(),
            'spam'     => PostComment::where('status', 'spam')->count(),
        ];

        return view('admin.comments.index', compact('comments', 'counts'));
    }

    /**
     * Update comment status (approve, pending, spam, reject).
     */
    public function updateStatus(Request $request, PostComment $comment)
    {
        $validated = $request->validate([
            'status' => 'required|in:approved,pending,spam,rejected',
        ]);

        $comment->update(['status' => $validated['status']]);

        $messages = [
            'approved' => 'Komentar berhasil disetujui & dipublikasikan.',
            'pending'  => 'Status komentar dikembalikan ke Pending Review.',
            'spam'     => 'Komentar ditandai sebagai Spam.',
            'rejected' => 'Komentar ditolak.',
        ];

        return back()->with('success', $messages[$validated['status']] ?? 'Status komentar berhasil diperbarui.');
    }

    /**
     * Delete a comment permanently.
     */
    public function destroy(PostComment $comment)
    {
        $comment->delete();
        return back()->with('success', 'Komentar berhasil dihapus.');
    }
}
