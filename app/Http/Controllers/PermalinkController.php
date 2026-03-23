<?php

namespace App\Http\Controllers;

use App\Services\PermalinkService;
use App\Models\Page;
use App\Http\Controllers\FrontendController;
use Illuminate\Http\Request;

class PermalinkController extends Controller
{
    protected $frontendController;

    public function __construct(FrontendController $frontendController)
    {
        $this->frontendController = $frontendController;
    }

    /**
     * Resolve a dynamic permalink path.
     */
    public function resolve(Request $request, $path = null)
    {
        // 1. Try to find a static Page first (highest priority)
        $slug = $path ?: '/';
        $page = Page::where('slug', rtrim($slug, '/'))->where('type', 'default')->first();
        if ($page) {
            return $this->frontendController->showPage($page->slug);
        }

        // 2. Resolve via PermalinkService for Posts and Events
        $resolved = PermalinkService::resolvePath($path);

        if ($resolved) {
            if ($resolved['type'] === 'post') {
                return $this->frontendController->showPost($resolved['model']->slug);
            } elseif ($resolved['type'] === 'event') {
                return $this->frontendController->showEvent($resolved['model']);
            }
        }

        // 3. Fallback to categories or 404
        // (Implementation for categories/tags can be added here)

        abort(404);
    }
}
