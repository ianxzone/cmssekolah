<?php

namespace App\Services;

use App\Models\Post;
use App\Models\Page;
use App\Models\Category;
use App\Models\Tag;
use App\Models\Media;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Log;

class WPImportService
{
    protected $log = [];

    /**
     * Parse and import from a WXR (WordPress XML) string.
     */
    public function importFromXml($xmlString)
    {
        // WordPress XML often has many namespaces, we need to register them or use simplexml_load_string with options
        $xml = simplexml_load_string($xmlString, 'SimpleXMLElement', LIBXML_NOCDATA);
        $namespaces = $xml->getDocNamespaces(true);
        
        $channel = $xml->channel;
        
        foreach ($channel->item as $item) {
            $wp = $item->children($namespaces['wp']);
            $contentNs = $item->children($namespaces['content']);
            $dc = $item->children($namespaces['dc']);
            
            $postType = (string)$wp->post_type;
            
            if ($postType === 'post' || $postType === 'page') {
                $this->importPostOrPage($item, $wp, $contentNs, $dc, $namespaces);
            } elseif ($postType === 'attachment') {
                // Attachments are handled inside post/page parsing to ensure correct context, 
                // but we can also store them in media manager here if needed.
                // $this->importMedia($item, $wp);
            }
        }

        return $this->log;
    }

    protected function importPostOrPage($item, $wp, $contentNs, $dc, $namespaces)
    {
        $status = (string)$wp->status === 'publish' ? now() : null;
        $title = (string)$item->title;
        
        // More robust content extraction
        $content = '';
        if (isset($namespaces['content'])) {
            $content = (string)$item->children($namespaces['content'])->encoded;
        }
        
        $slug = (string)$wp->post_name ?: Str::slug($title);
        $type = (string)$wp->post_type;
        $createdAt = (string)$wp->post_date;

        // 1. Process Images in content
        $content = $this->processContentMedia($content);

        // 2. Prepare Data
        $data = [
            'title' => $title,
            'slug' => $slug,
            'content' => $content,
            'published_at' => $status,
            'created_at' => $createdAt,
        ];

        if ($type === 'post') {
            $post = Post::updateOrCreate(['slug' => $slug], $data);
            
            // Handle Categories and Tags
            foreach ($item->category as $cat) {
                $domain = (string)$cat['domain'];
                $termName = (string)$cat;
                $termSlug = (string)$cat['nicename'];

                if ($domain === 'category') {
                    $category = Category::firstOrCreate(['slug' => $termSlug], ['name' => $termName]);
                    $post->category_id = $category->id;
                    $post->save();
                } elseif ($domain === 'post_tag') {
                    $tag = Tag::firstOrCreate(['slug' => $termSlug], ['name' => $termName]);
                    $post->tags()->syncWithoutDetaching([$tag->id]);
                }
            }
            $this->log[] = "Imported Post: {$title}";
        } else {
            Page::updateOrCreate(['slug' => $slug], array_merge($data, ['type' => 'default']));
            $this->log[] = "Imported Page: {$title}";
        }
    }

    protected function processContentMedia($content)
    {
        // Find all images in content
        // Simple regex to match src attributes in img tags
        preg_match_all('/<img[^>]+src=["\']([^"\']+)["\']/i', $content, $matches);

        if (!empty($matches[1])) {
            foreach ($matches[1] as $imageUrl) {
                \Log::info("WP Import: Found image URL: " . $imageUrl);
                $localUrl = $this->downloadAndStoreMedia($imageUrl);
                if ($localUrl) {
                    $content = str_replace($imageUrl, $localUrl, $content);
                } else {
                    Log::info("WP Import: Failed to download image " . $imageUrl);
                }
            }
        }

        return $content;
    }

    protected function downloadAndStoreMedia($url)
    {
        try {
            // Basic check to see if it's already local
            if (Str::startsWith($url, asset('storage'))) {
                return $url;
            }

            $response = Http::get($url);
            /** @var \Illuminate\Http\Client\Response $response */
            if ($response->successful()) {
                $filename = basename(parse_url($url, PHP_URL_PATH));
                $filename = str_replace([' ', '%20'], '-', $filename);
                $path = 'media/' . time() . '-' . $filename;
                
                Storage::disk('public')->put($path, $response->body());
                
                // Add to Media model - Match the actual model attributes
                Media::create([
                    'name' => pathinfo($filename, PATHINFO_FILENAME),
                    'file_name' => $filename,
                    'path' => $path,
                    'mime_type' => $response->header('Content-Type') ?: 'image/jpeg',
                    'disk' => 'public',
                    'size' => strlen($response->body()),
                ]);

                return asset('storage/' . $path);
            }
        } catch (\Exception $e) {
            Log::error("Failed to download image: " . $url . " - " . $e->getMessage());
        }

        return null;
    }
}
