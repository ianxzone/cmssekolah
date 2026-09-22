<?php

namespace App\Http\Controllers;

use App\Models\Page;
use Illuminate\Http\Request;

class PageController extends Controller
{
    /**
     * Handle the incoming request.
     */
    public function show($slug)
    {
        $page = Page::where('slug', $slug)->firstOrFail();

        // If page is not published and viewer is not logged in, return 404
        if (!$page->is_published && !auth()->check()) {
            abort(404);
        }

        $isPreview = !$page->is_published && auth()->check();

        return view('pages.show', compact('page', 'isPreview'));
    }
}
