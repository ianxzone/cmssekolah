<?php

namespace Tests\Feature;

use App\Models\Post;
use App\Models\Event;
use App\Models\Page;
use App\Models\Setting;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class PermalinkTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function it_generates_unique_slugs_automatically()
    {
        $post1 = Post::create([
            'title' => 'Sample Post',
            'content' => 'Content 1',
            'published_at' => now(),
        ]);

        $post2 = Post::create([
            'title' => 'Sample Post',
            'content' => 'Content 2',
            'published_at' => now(),
        ]);

        $this->assertEquals('sample-post', $post1->slug);
        $this->assertEquals('sample-post-2', $post2->slug);
    }

    /** @test */
    public function it_resolves_default_permalink_structure()
    {
        // Default is /berita/%postname%
        $post = Post::create([
            'title' => 'My News',
            'slug' => 'my-news',
            'content' => 'Test content',
            'published_at' => now(),
        ]);

        $response = $this->get('/berita/my-news');
        $response->assertStatus(200);
        $response->assertSee('My News');
    }

    /** @test */
    public function it_resolves_post_name_structure()
    {
        Setting::set('permalink_structure', '/%postname%');

        $post = Post::create([
            'title' => 'Clean URL',
            'slug' => 'clean-url',
            'content' => 'Test content',
            'published_at' => now(),
        ]);

        $response = $this->get('/clean-url');
        $response->assertStatus(200);
        $response->assertSee('Clean URL');
    }

    /** @test */
    public function it_prioritizes_pages_over_posts()
    {
        Setting::set('permalink_structure', '/%postname%');

        // Create a Post and a Page with the same concept
        $post = Post::create(['title' => 'About', 'slug' => 'about-post', 'content' => 'Post Content']);
        $page = Page::create(['title' => 'About Page', 'slug' => 'about', 'content' => 'Page Content', 'type' => 'default']);

        // Set post slug to 'about' manually to test conflict (trait handles it usually but let's test resolution)
        $post->slug = 'about'; 
        $post->saveQuietly();

        $response = $this->get('/about');
        $response->assertStatus(200);
        $response->assertSee('Page Content');
        $response->assertDontSee('Post Content');
    }

    /** @test */
    public function it_resolves_dated_permalinks()
    {
        Setting::set('permalink_structure', '/%year%/%monthnum%/%day%/%postname%');

        $date = now();
        $post = Post::create([
            'title' => 'Dated Post',
            'slug' => 'dated-post',
            'content' => 'Test内容',
            'published_at' => $date,
        ]);

        $path = $date->format('/Y/m/d/') . 'dated-post';
        $response = $this->get($path);
        
        $response->assertStatus(200);
        $response->assertSee('Dated Post');
    }

    /** @test */
    public function it_resolves_event_permalinks()
    {
        Setting::set('permalink_event_structure', '/agenda/%postname%');

        $event = Event::create([
            'title' => 'Big Event',
            'slug' => 'big-event',
            'type' => 'offline',
            'start_time' => now()->addDays(1),
            'description' => 'Event description',
        ]);

        $response = $this->get('/agenda/big-event');
        $response->assertStatus(200);
        $response->assertSee('Big Event');
    }
}
