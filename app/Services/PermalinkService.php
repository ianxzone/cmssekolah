<?php

namespace App\Services;

use App\Models\Setting;
use Illuminate\Support\Str;

class PermalinkService
{
    /**
     * Generate URL for a Post.
     */
    public static function getPostUrl($post)
    {
        $structure = Setting::get('permalink_structure', '/berita/%postname%');
        return self::resolveUrl($structure, $post, 'post');
    }

    /**
     * Generate URL for an Event.
     */
    public static function getEventUrl($event)
    {
        $structure = Setting::get('permalink_event_structure', '/agenda/%postname%');
        return self::resolveUrl($structure, $event, 'event');
    }

    /**
     * Resolve placeholders in a permalink structure.
     */
    protected static function resolveUrl($structure, $model, $type)
    {
        $publishedAt = $model->published_at ?? $model->created_at;
        if ($type === 'event') {
            $publishedAt = $model->start_time ?? $model->created_at;
        }

        $placeholders = [
            '%year%' => $publishedAt->format('Y'),
            '%monthnum%' => $publishedAt->format('m'),
            '%day%' => $publishedAt->format('d'),
            '%postname%' => $model->slug,
            '%post_id%' => $model->id,
            '%category%' => $model->category->slug ?? 'uncategorized',
            '%author%' => $model->user->name ?? 'admin', // Placeholder if author exists
        ];

        $url = str_replace(array_keys($placeholders), array_values($placeholders), $structure);
        
        // Ensure leading slash and remove trailing slash for consistency
        return '/' . ltrim(rtrim($url, '/'), '/');
    }

    /**
     * Parse a path to find the matching model and type.
     */
    public static function resolvePath($path)
    {
        $path = '/' . ltrim($path, '/');
        
        // 1. Try Posts
        $postStructure = Setting::get('permalink_structure', '/berita/%postname%');
        if ($post = self::matchModel($path, $postStructure, \App\Models\Post::class)) {
            return ['type' => 'post', 'model' => $post];
        }

        // 2. Try Events
        $eventStructure = Setting::get('permalink_event_structure', '/agenda/%postname%');
        if ($event = self::matchModel($path, $eventStructure, \App\Models\Event::class)) {
            return ['type' => 'event', 'model' => $event];
        }

        return null;
    }

    /**
     * Match a path against a structure and find the model.
     */
    protected static function matchModel($path, $structure, $modelClass)
    {
        // Convert structure to regex
        $regex = str_replace([
            '%year%', '%monthnum%', '%day%', '%postname%', '%post_id%', '%category%', '%author%'
        ], [
            '(\d{4})', '(\d{2})', '(\d{2})', '([a-z0-9-]+)', '(\d+)', '([a-z0-9-]+)', '([a-z0-9-]+)'
        ], preg_quote($structure, '#'));

        // Replace placeholders with named captures if we wanted more detail, 
        // but simple captures are enough to extract the slug.
        
        // Find where %postname% or %post_id% is in the structure to know which group to use
        $placeholders = ['%year%', '%monthnum%', '%day%', '%postname%', '%post_id%', '%category%', '%author%'];
        $pattern = '#^' . $regex . '$#i';

        if (preg_match($pattern, $path, $matches)) {
            // Find index of %postname% or %post_id%
            $segments = explode('/', ltrim($structure, '/'));
            $pathSegments = explode('/', ltrim($path, '/'));
            
            foreach ($segments as $i => $segment) {
                if ($segment === '%postname%') {
                    return $modelClass::where('slug', $pathSegments[$i])->first();
                }
                if ($segment === '%post_id%') {
                    return $modelClass::find($pathSegments[$i]);
                }
            }
        }

        return null;
    }
}
