<?php

namespace Tests\Feature;

use App\Models\Post;
use App\Models\Page;
use App\Models\Category;
use App\Models\Tag;
use App\Services\WPImportService;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Storage;
use Tests\TestCase;

class WPImportTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function it_imports_posts_and_pages_from_wxr_xml()
    {
        Storage::fake('public');
        Http::fake([
            'https://example.com/wp-content/uploads/2023/01/image.jpg' => Http::response('fake-image-content', 200, ['Content-Type' => 'image/jpeg']),
        ]);

        $xml = <<<XML
<?xml version="1.0" encoding="UTF-8" ?>
<rss version="2.0"
	xmlns:excerpt="http://wordpress.org/export/1.2/excerpt/"
	xmlns:content="http://purl.org/rss/1.0/modules/content/"
	xmlns:wfw="http://wellformedweb.org/CommentAPI/"
	xmlns:dc="http://purl.org/dc/elements/1.1/"
	xmlns:wp="http://wordpress.org/export/1.2/"
>
<channel>
	<item>
		<title>A Blog Post</title>
		<link>https://example.com/a-blog-post/</link>
		<pubDate>Mon, 23 Jan 2023 10:00:00 +0000</pubDate>
		<dc:creator><![CDATA[admin]]></dc:creator>
		<description></description>
		<content:encoded><![CDATA[<p>Hello World!</p><img src="https://example.com/wp-content/uploads/2023/01/image.jpg" />]]></content:encoded>
		<wp:post_id>1</wp:post_id>
		<wp:post_date><![CDATA[2023-01-23 10:00:00]]></wp:post_date>
		<wp:post_name><![CDATA[a-blog-post]]></wp:post_name>
		<wp:status><![CDATA[publish]]></wp:status>
		<wp:post_type><![CDATA[post]]></wp:post_type>
		<category domain="category" nicename="news"><![CDATA[News]]></category>
		<category domain="post_tag" nicename="testing"><![CDATA[Testing]]></category>
	</item>
    <item>
		<title>About Us</title>
		<wp:post_name><![CDATA[about-us]]></wp:post_name>
		<wp:status><![CDATA[publish]]></wp:status>
		<wp:post_type><![CDATA[page]]></wp:post_type>
        <content:encoded><![CDATA[This is a page.]]></content:encoded>
	</item>
</channel>
</rss>
XML;

        $service = new WPImportService();
        $logs = $service->importFromXml($xml);

        $this->assertCount(2, $logs);
        
        // Assert Post
        $post = Post::where('slug', 'a-blog-post')->first();
        $this->assertNotNull($post);
        $this->assertEquals('A Blog Post', $post->title);
        $this->assertStringContainsString('storage/media/', $post->content, "Current content: " . $post->content);
        $this->assertEquals('News', $post->category->name);
        $this->assertTrue($post->tags->contains('name', 'Testing'));

        // Assert Page
        $page = Page::where('slug', 'about-us')->first();
        $this->assertNotNull($page);
        $this->assertEquals('About Us', $page->title);
    }
}
