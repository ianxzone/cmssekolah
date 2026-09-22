<?php

namespace App\Services;

use App\Models\Post;
use App\Models\Page;
use App\Models\Category;
use App\Models\Tag;
use App\Models\Media;
use Carbon\Carbon;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Http;

class WordPressImportService
{
    protected array $log = [
        'summary' => [
            'categories_imported' => 0,
            'categories_skipped' => 0,
            'categories_failed' => 0,
            'tags_imported' => 0,
            'tags_skipped' => 0,
            'tags_failed' => 0,
            'posts_imported' => 0,
            'posts_skipped' => 0,
            'posts_failed' => 0,
            'pages_imported' => 0,
            'pages_skipped' => 0,
            'pages_failed' => 0,
            'images_downloaded' => 0,
            'images_failed' => 0,
        ],
        'details' => [],
        'messages' => [],
    ];
    
    protected array $categoryMap = [];
    protected array $tagMap = [];
    protected string $wpSiteUrl = '';

    /**
     * Parse a WXR XML file and return structured data.
     */
    public function parseXml(string $filePath): array
    {
        if (!file_exists($filePath)) {
            throw new \Exception("File not found: {$filePath}");
        }

        // Suppress libxml errors to handle them manually
        libxml_use_internal_errors(true);
        $xml = simplexml_load_file($filePath);

        if ($xml === false) {
            $errors = libxml_get_errors();
            libxml_clear_errors();
            throw new \Exception("Failed to parse XML: " . ($errors[0]->message ?? 'Unknown error'));
        }

        $namespaces = $xml->getNamespaces(true);
        
        $wpNs = $namespaces['wp'] ?? 'http://wordpress.org/export/1.2/';
        if (!isset($namespaces['wp'])) {
            // Try fallback namespaces
            $wpNsArray = [
                'http://wordpress.org/export/1.2/',
                'http://wordpress.org/export/1.1/',
                'http://wordpress.org/export/1.0/'
            ];
            foreach ($wpNsArray as $ns) {
                if (in_array($ns, $namespaces)) {
                    $wpNs = $ns;
                    break;
                }
            }
        }

        $dcNs = $namespaces['dc'] ?? 'http://purl.org/dc/elements/1.1/';
        $contentNs = $namespaces['content'] ?? 'http://purl.org/rss/1.0/modules/content/';
        $excerptNs = $namespaces['excerpt'] ?? 'http://wordpress.org/export/1.2/excerpt/';

        $data = [
            'site_info' => [],
            'categories' => [],
            'tags' => [],
            'posts' => [],
            'pages' => [],
            'attachments' => [],
            'stats' => [
                'categories' => 0,
                'tags' => 0,
                'posts' => 0,
                'pages' => 0
            ]
        ];

        // Site Info
        $channel = $xml->channel;
        $data['site_info'] = [
            'title' => (string)$channel->title,
            'link' => (string)$channel->link,
            'description' => (string)$channel->description,
        ];

        // Categories
        if (isset($channel->children($wpNs)->category)) {
            foreach ($channel->children($wpNs)->category as $cat) {
                $data['categories'][] = [
                    'cat_name' => (string)$cat->cat_name,
                    'category_nicename' => (string)$cat->category_nicename,
                    'category_parent' => (string)$cat->category_parent,
                    'category_description' => (string)$cat->category_description,
                ];
                $data['stats']['categories']++;
            }
        }

        // Tags
        if (isset($channel->children($wpNs)->tag)) {
            foreach ($channel->children($wpNs)->tag as $tag) {
                $data['tags'][] = [
                    'tag_name' => (string)$tag->tag_name,
                    'tag_slug' => (string)$tag->tag_slug,
                ];
                $data['stats']['tags']++;
            }
        }

        // Items (Posts, Pages, Attachments)
        foreach ($channel->item as $item) {
            $wp = $item->children($wpNs);
            $content = $item->children($contentNs);
            $excerpt = $item->children($excerptNs);
            $dc = $item->children($dcNs);

            $postType = (string)$wp->post_type;
            
            $itemData = [
                'title' => (string)$item->title,
                'link' => (string)$item->link,
                'post_type' => $postType,
                'content' => (string)$content->encoded,
                'excerpt' => (string)$excerpt->encoded,
                'post_date' => (string)$wp->post_date,
                'status' => (string)$wp->status,
                'post_name' => (string)$wp->post_name,
                'categories' => [],
                'tags' => [],
                'post_id' => (string)$wp->post_id,
                'post_parent' => (string)$wp->post_parent,
            ];

            // Extract categories and tags from item
            foreach ($item->category as $c) {
                $domain = (string)$c['domain'];
                $nicename = (string)$c['nicename'];
                
                if ($domain === 'category') {
                    $itemData['categories'][] = $nicename;
                } elseif ($domain === 'post_tag') {
                    $itemData['tags'][] = $nicename;
                }
            }

            // Extract postmeta (like thumbnail ID)
            $meta = [];
            foreach ($wp->postmeta as $pm) {
                $key = (string)$pm->meta_key;
                $val = (string)$pm->meta_value;
                $meta[$key] = $val;
            }
            $itemData['meta'] = $meta;
            if (isset($meta['_thumbnail_id'])) {
                $itemData['thumbnail_id'] = $meta['_thumbnail_id'];
            }

            if ($postType === 'attachment') {
                $itemData['attachment_url'] = (string)$wp->attachment_url;
                $data['attachments'][$itemData['post_id']] = $itemData;
            } elseif ($postType === 'post') {
                $data['posts'][] = $itemData;
                $data['stats']['posts']++;
            } elseif ($postType === 'page') {
                $data['pages'][] = $itemData;
                $data['stats']['pages']++;
            }
        }

        // Resolve thumbnail URLs for posts and pages
        foreach (['posts', 'pages'] as $type) {
            foreach ($data[$type] as &$item) {
                if (isset($item['thumbnail_id']) && isset($data['attachments'][$item['thumbnail_id']])) {
                    $item['thumbnail_url'] = $data['attachments'][$item['thumbnail_id']]['attachment_url'];
                } else {
                    $item['thumbnail_url'] = null;
                }
            }
        }

        return $data;
    }

    /**
     * Main import method.
     */
    public function import(array $data, array $options = []): array
    {
        $options = array_merge([
            'import_categories' => true,
            'import_tags' => true,
            'import_posts' => true,
            'import_pages' => true,
            'download_images' => true,
            'duplicate_handling' => 'skip', // 'skip' or 'rename'
        ], $options);

        $this->wpSiteUrl = $data['site_info']['link'] ?? '';

        if ($options['import_categories']) {
            $this->importCategories($data['categories']);
        }

        if ($options['import_tags']) {
            $this->importTags($data['tags']);
        }

        if ($options['import_posts']) {
            $this->importPosts($data['posts'], $options);
        }

        if ($options['import_pages']) {
            $this->importPages($data['pages'], $options);
        }

        return $this->log;
    }

    protected function importCategories(array $categories): void
    {
        // Sort to ensure parent categories are processed first
        usort($categories, function ($a, $b) {
            if (empty($a['category_parent'])) return -1;
            if (empty($b['category_parent'])) return 1;
            return 0;
        });

        foreach ($categories as $cat) {
            try {
                $slug = $cat['category_nicename'] ?: Str::slug($cat['cat_name']);
                
                $existing = Category::where('slug', $slug)->first();
                
                if ($existing) {
                    $this->categoryMap[$slug] = $existing->id;
                    $this->log['summary']['categories_skipped']++;
                    $this->log['details'][] = ['type' => 'category', 'title' => $cat['cat_name'], 'status' => 'skipped', 'message' => 'Slug sudah ada'];
                    continue;
                }

                $parentId = null;
                if (!empty($cat['category_parent']) && isset($this->categoryMap[$cat['category_parent']])) {
                    $parentId = $this->categoryMap[$cat['category_parent']];
                }

                $category = Category::create([
                    'name' => $cat['cat_name'],
                    'slug' => $slug,
                    'description' => $cat['category_description'],
                    'parent_id' => $parentId,
                ]);

                $this->categoryMap[$slug] = $category->id;
                $this->log['summary']['categories_imported']++;
                $this->log['details'][] = ['type' => 'category', 'title' => $cat['cat_name'], 'status' => 'imported', 'message' => ''];
            } catch (\Exception $e) {
                $this->log['summary']['categories_failed']++;
                $this->log['details'][] = ['type' => 'category', 'title' => $cat['cat_name'], 'status' => 'failed', 'message' => $e->getMessage()];
                Log::warning("WordPress Import: Category import failed", ['cat' => $cat['cat_name'], 'error' => $e->getMessage()]);
            }
        }
    }

    protected function importTags(array $tags): void
    {
        foreach ($tags as $tag) {
            try {
                $slug = $tag['tag_slug'] ?: Str::slug($tag['tag_name']);
                
                $existing = Tag::where('slug', $slug)->first();
                
                if ($existing) {
                    $this->tagMap[$slug] = $existing->id;
                    $this->log['summary']['tags_skipped']++;
                    $this->log['details'][] = ['type' => 'tag', 'title' => $tag['tag_name'], 'status' => 'skipped', 'message' => 'Slug sudah ada'];
                    continue;
                }

                $newTag = Tag::create([
                    'name' => $tag['tag_name'],
                    'slug' => $slug,
                ]);

                $this->tagMap[$slug] = $newTag->id;
                $this->log['summary']['tags_imported']++;
                $this->log['details'][] = ['type' => 'tag', 'title' => $tag['tag_name'], 'status' => 'imported', 'message' => ''];
            } catch (\Exception $e) {
                $this->log['summary']['tags_failed']++;
                $this->log['details'][] = ['type' => 'tag', 'title' => $tag['tag_name'], 'status' => 'failed', 'message' => $e->getMessage()];
                Log::warning("WordPress Import: Tag import failed", ['tag' => $tag['tag_name'], 'error' => $e->getMessage()]);
            }
        }
    }

    protected function importPosts(array $posts, array $options): void
    {
        foreach ($posts as $postData) {
            try {
                $slug = $postData['post_name'] ?: Str::slug($postData['title']);
                
                $existing = Post::where('slug', $slug)->first();
                if ($existing) {
                    if ($options['duplicate_handling'] === 'skip') {
                        $this->log['summary']['posts_skipped']++;
                        $this->log['details'][] = ['type' => 'post', 'title' => $postData['title'], 'status' => 'skipped', 'message' => 'Slug sudah ada'];
                        continue;
                    } else { // rename
                        $originalSlug = $slug;
                        $counter = 2;
                        while (Post::where('slug', $slug)->exists()) {
                            $slug = $originalSlug . '-' . $counter;
                            $counter++;
                        }
                    }
                }

                // Determine published_at
                $publishedAt = null;
                $status = $postData['status'];
                $postDate = $postData['post_date'] !== '0000-00-00 00:00:00' ? Carbon::parse($postData['post_date']) : now();

                if (in_array($status, ['publish', 'private'])) {
                    $publishedAt = $postDate;
                } elseif (in_array($status, ['draft', 'pending'])) {
                    $publishedAt = null;
                } elseif ($status === 'future') {
                    $publishedAt = $postDate;
                }

                // Category lookup
                $categoryId = null;
                if (!empty($postData['categories'])) {
                    $firstCatSlug = $postData['categories'][0];
                    if (isset($this->categoryMap[$firstCatSlug])) {
                        $categoryId = $this->categoryMap[$firstCatSlug];
                    }
                }

                // Download Image
                $imageUrl = null;
                if ($options['download_images'] && !empty($postData['thumbnail_url'])) {
                    $imageUrl = $this->downloadImage($postData['thumbnail_url'], 'posts');
                    if ($imageUrl) {
                        $this->log['summary']['images_downloaded']++;
                    } else {
                        $this->log['summary']['images_failed']++;
                    }
                }
                
                if (!$imageUrl && !empty($postData['thumbnail_url'])) {
                    $imageUrl = $postData['thumbnail_url'];
                }

                $content = $this->cleanContent($postData['content']);
                $excerpt = $postData['excerpt'] ?: Str::limit(strip_tags($content), 160);

                $post = Post::create([
                    'title' => $postData['title'],
                    'slug' => $slug,
                    'content' => $content,
                    'description' => $excerpt,
                    'image' => $imageUrl,
                    'published_at' => $publishedAt,
                    'category_id' => $categoryId,
                    'seo_title' => $postData['title'],
                    'seo_description' => Str::limit($excerpt, 160, ''),
                ]);

                // Sync Tags
                if (!empty($postData['tags'])) {
                    $tagIds = [];
                    foreach ($postData['tags'] as $tagSlug) {
                        if (isset($this->tagMap[$tagSlug])) {
                            $tagIds[] = $this->tagMap[$tagSlug];
                        }
                    }
                    if (!empty($tagIds)) {
                        $post->tags()->sync($tagIds);
                    }
                }

                $this->log['summary']['posts_imported']++;
                $this->log['details'][] = ['type' => 'post', 'title' => $postData['title'], 'status' => 'imported', 'message' => ''];
            } catch (\Exception $e) {
                $this->log['summary']['posts_failed']++;
                $this->log['details'][] = ['type' => 'post', 'title' => $postData['title'] ?? 'Unknown', 'status' => 'failed', 'message' => $e->getMessage()];
                Log::warning("WordPress Import: Post import failed", ['title' => $postData['title'] ?? 'Unknown', 'error' => $e->getMessage()]);
            }
        }
    }

    protected function importPages(array $pages, array $options): void
    {
        foreach ($pages as $pageData) {
            try {
                $slug = $pageData['post_name'] ?: Str::slug($pageData['title']);
                
                $existing = Page::where('slug', $slug)->first();
                if ($existing) {
                    if ($options['duplicate_handling'] === 'skip') {
                        $this->log['summary']['pages_skipped']++;
                        $this->log['details'][] = ['type' => 'page', 'title' => $pageData['title'], 'status' => 'skipped', 'message' => 'Slug sudah ada'];
                        continue;
                    } else { // rename
                        $originalSlug = $slug;
                        $counter = 2;
                        while (Page::where('slug', $slug)->exists()) {
                            $slug = $originalSlug . '-' . $counter;
                            $counter++;
                        }
                    }
                }

                // Determine status and published_at
                $publishedAt = null;
                $status = 'draft';
                $wpStatus = $pageData['status'];
                $postDate = $pageData['post_date'] !== '0000-00-00 00:00:00' ? Carbon::parse($pageData['post_date']) : now();

                if ($wpStatus === 'publish') {
                    $status = 'published';
                    $publishedAt = $postDate;
                } elseif ($wpStatus === 'pending') {
                    $status = 'pending';
                } elseif ($wpStatus === 'future') {
                    $status = 'scheduled';
                    $publishedAt = $postDate;
                }

                // Download Image
                $imageUrl = null;
                if ($options['download_images'] && !empty($pageData['thumbnail_url'])) {
                    $imageUrl = $this->downloadImage($pageData['thumbnail_url'], 'pages');
                    if ($imageUrl) {
                        $this->log['summary']['images_downloaded']++;
                    } else {
                        $this->log['summary']['images_failed']++;
                    }
                }

                if (!$imageUrl && !empty($pageData['thumbnail_url'])) {
                    $imageUrl = $pageData['thumbnail_url'];
                }

                $content = $this->cleanContent($pageData['content']);

                Page::create([
                    'title' => $pageData['title'],
                    'slug' => $slug,
                    'content' => $content,
                    'image' => $imageUrl,
                    'status' => $status,
                    'published_at' => $publishedAt,
                ]);

                $this->log['summary']['pages_imported']++;
                $this->log['details'][] = ['type' => 'page', 'title' => $pageData['title'], 'status' => 'imported', 'message' => ''];
            } catch (\Exception $e) {
                $this->log['summary']['pages_failed']++;
                $this->log['details'][] = ['type' => 'page', 'title' => $pageData['title'] ?? 'Unknown', 'status' => 'failed', 'message' => $e->getMessage()];
                Log::warning("WordPress Import: Page import failed", ['title' => $pageData['title'] ?? 'Unknown', 'error' => $e->getMessage()]);
            }
        }
    }

    protected function downloadImage(string $url, string $directory = 'media'): ?string
    {
        try {
            $response = Http::timeout(30)->get($url);
            
            if (!$response->successful()) {
                Log::warning("WordPress Import: Failed to download image from {$url}");
                return null;
            }

            $content = $response->body();
            $originalName = pathinfo(parse_url($url, PHP_URL_PATH), PATHINFO_BASENAME);
            $filenameWithoutExt = Str::slug(pathinfo($originalName, PATHINFO_FILENAME));
            $filename = $filenameWithoutExt . '-' . time() . '.webp';
            
            $path = $directory . '/' . $filename;
            
            $finfo = new \finfo(FILEINFO_MIME_TYPE);
            $mime = $finfo->buffer($content);

            if (!str_starts_with($mime, 'image/')) {
                Log::warning("WordPress Import: URL did not return an image: {$url}");
                return null;
            }

            $converted = false;
            if (function_exists('imagecreatefromstring') && function_exists('imagewebp')) {
                $image = @imagecreatefromstring($content);
                if ($image !== false) {
                    ob_start();
                    imagewebp($image, null, 85);
                    $webpContent = ob_get_clean();
                    imagedestroy($image);
                    
                    if ($webpContent) {
                        Storage::disk('public')->put($path, $webpContent);
                        $converted = true;
                        $size = strlen($webpContent);
                        $mime = 'image/webp';
                    }
                }
            }

            if (!$converted) {
                $ext = pathinfo($originalName, PATHINFO_EXTENSION) ?: 'jpg';
                $filename = $filenameWithoutExt . '-' . time() . '.' . $ext;
                $path = $directory . '/' . $filename;
                Storage::disk('public')->put($path, $content);
                $size = strlen($content);
            }

            Media::create([
                'name' => $filenameWithoutExt,
                'file_name' => $filename,
                'mime_type' => $mime,
                'path' => $path,
                'disk' => 'public',
                'size' => $size,
                'alt_text' => str_replace('-', ' ', $filenameWithoutExt),
            ]);

            return $path;
        } catch (\Exception $e) {
            Log::warning("WordPress Import: Exception downloading image {$url} - " . $e->getMessage());
            return null;
        }
    }

    protected function cleanContent(string $content): string
    {
        if (empty($content)) {
            return $content;
        }

        // [caption] to <figure>
        $content = preg_replace_callback(
            '/\[caption[^\]]*\](.*?)<img(.*?)>(.*?)\[\/caption\]/is',
            function ($matches) {
                $img = "<img{$matches[2]}>";
                $caption = trim($matches[3]);
                return "<figure>{$img}<figcaption>{$caption}</figcaption></figure>";
            },
            $content
        );

        // Remove [gallery]
        $content = preg_replace('/\[gallery[^\]]*\]/is', '', $content);

        // Convert [embed]
        $content = preg_replace('/\[embed[^\]]*\](.*?)\[\/embed\]/is', '$1', $content);

        // Remove <!--more--> and <!--nextpage-->
        $content = str_replace(['<!--more-->', '<!--nextpage-->'], '', $content);

        // Remove empty paragraphs
        $content = preg_replace('/<p>(?:&nbsp;|\s)*<\/p>/i', '', $content);

        // Remove WP classes
        $classesToRemove = [
            'wp-block-image', 'wp-block-gallery', 'wp-block-group', 'wp-block-columns', 'wp-block-column',
            'wp-image-[0-9]+', 'alignleft', 'alignright', 'aligncenter', 'alignnone', 'size-full', 'size-large',
            'size-medium', 'size-thumbnail', 'has-text-align-center', 'has-text-align-right', 'has-text-align-left'
        ];
        
        foreach ($classesToRemove as $cls) {
            $content = preg_replace('/\b' . $cls . '\b/is', '', $content);
        }

        $content = preg_replace('/class="\s*"/is', '', $content);

        return $content;
    }

    public function getLog(): array
    {
        return $this->log;
    }
}
