<?php

namespace App\Http\Controllers;

use App\Models\Post;
use App\Models\Category;
use App\Models\Form;
use Illuminate\Http\Request;

class FrontendController extends Controller
{
    /**
     * Display the Homepage (Blog Index)
     */
    public function index()
    {
        $settings = \App\Models\Setting::pluck('value', 'key')->toArray();

        $posts = collect();
        if (($settings['home_show_news'] ?? '1') == '1') {
            $posts = Post::with('category')
                ->whereNotNull('published_at')
                ->where('published_at', '<=', now())
                ->latest('published_at')
                ->take(3)
                ->get();
        }

        $events = collect();
        if (($settings['home_show_events'] ?? '1') == '1') {
            $events = \App\Models\Event::where('start_time', '>=', now())
                ->orderBy('start_time', 'asc')
                ->take(3)
                ->get();
        }

        $testimonials = collect();
        if (($settings['home_show_testimonials'] ?? '1') == '1') {
            $testiLimit = (int) ($settings['home_testimonials_limit'] ?? 5);
            $testimonials = \App\Models\Testimonial::where('is_active', true)
                ->latest()
                ->take($testiLimit)
                ->get();
        }

        $teachers = collect();
        if (($settings['home_show_teachers'] ?? '1') == '1') {
            $teachers = \App\Models\Teacher::where('is_active', true)
                ->orderBy('order', 'asc')
                ->orderBy('id', 'asc')
                ->get();
        }

        return view('welcome', compact('settings', 'posts', 'events', 'testimonials', 'teachers'));
    }

    /**
     * Display All Posts (Berita)
     */
    public function posts()
    {
        $posts = Post::with('category')
            ->whereNotNull('published_at')
            ->where('published_at', '<=', now())
            ->latest('published_at')
            ->paginate(9);

        return view('frontend.index', compact('posts'));
    }

    /**
     * Display All Events (Agenda)
     */
    public function events()
    {
        $events = \App\Models\Event::where('start_time', '>=', now())
            ->orderBy('start_time', 'asc')
            ->paginate(12);

        return view('frontend.events', compact('events'));
    }

    /**
     * Show a specific Event
     */
    public function showEvent(\App\Models\Event $event)
    {
        return view('frontend.event', compact('event'));
    }

    /**
     * Show a detailed Post with sidebar data and approved comments
     */
    public function showPost($slug)
    {
        $post = Post::with(['category', 'author', 'approvedComments'])
            ->where('slug', $slug)
            ->whereNotNull('published_at')
            ->where('published_at', '<=', now())
            ->firstOrFail();

        // Sidebar data
        $recentPosts = Post::with(['category', 'author'])
            ->whereNotNull('published_at')
            ->where('published_at', '<=', now())
            ->where('id', '!=', $post->id)
            ->latest('published_at')
            ->take(5)
            ->get();

        $categories = Category::withCount(['posts' => function ($q) {
            $q->whereNotNull('published_at')->where('published_at', '<=', now());
        }])->having('posts_count', '>', 0)->get();

        $upcomingEvents = \App\Models\Event::where('start_time', '>=', now())
            ->orderBy('start_time', 'asc')
            ->take(2)
            ->get();

        $post->content = $this->parseShortcodes($post->content);
        return view('frontend.post', compact('post', 'recentPosts', 'categories', 'upcomingEvents'));
    }

    /**
     * Store a comment submitted by visitors (pending moderation).
     */
    public function storeComment(Request $request, $slug)
    {
        $post = Post::where('slug', $slug)
            ->whereNotNull('published_at')
            ->where('published_at', '<=', now())
            ->firstOrFail();

        // CAPTCHA & Honeypot Verification
        $captchaResult = \App\Services\CaptchaService::verify($request->all(), 'comments');
        if (!$captchaResult['success']) {
            \App\Services\SecurityService::logThreat('spam_bot', 'low', "Spam bot tertangkap pada Komentar: " . $captchaResult['message']);
            return back()->withInput()->withErrors(['captcha' => $captchaResult['message']]);
        }

        $validated = $request->validate([
            'name' => 'required|string|max:100',
            'email' => 'required|email|max:150',
            'phone' => 'required|string|min:8|max:25',
            'content' => 'required|string|max:2000',
        ], [
            'name.required' => 'Nama lengkap wajib diisi.',
            'name.max' => 'Nama maksimal 100 karakter.',
            'email.required' => 'Alamat email wajib diisi.',
            'email.email' => 'Format email tidak valid.',
            'phone.required' => 'Nomor HP / WhatsApp wajib diisi.',
            'phone.min' => 'Nomor HP minimal 8 karakter.',
            'phone.max' => 'Nomor HP maksimal 25 karakter.',
            'content.required' => 'Isi komentar tidak boleh kosong.',
            'content.max' => 'Komentar maksimal 2000 karakter.',
        ]);

        $post->comments()->create([
            'name' => strip_tags($validated['name']),
            'email' => $validated['email'],
            'phone' => strip_tags($validated['phone']),
            'content' => strip_tags($validated['content']),
            'status' => 'pending',
            'ip_address' => $request->ip(),
            'user_agent' => $request->userAgent(),
        ]);

        return back()->with('comment_success', 'Terima kasih! Komentar Anda berhasil dikirim dan akan diverifikasi oleh moderator terlebih dahulu sebelum dipublikasikan.');
    }

    /**
     * Resolve a slug — try Post first, then Page, with smart fallback for legacy WordPress ID permalinks.
     */
    public function showSlug($slug)
    {
        // 1. Try exact post match first
        $post = Post::with('category')
            ->where('slug', $slug)
            ->whereNotNull('published_at')
            ->where('published_at', '<=', now())
            ->first();

        if ($post) {
            return $this->showPost($slug);
        }

        // 2. Smart Match: If visitor requested a URL ending with -{id} (e.g. legacy WP permalinks like /judul-post-36007),
        // but database has the base slug /judul-post (without ID)
        if (preg_match('/^(.*?)-(\d+)$/', $slug, $matches)) {
            $baseSlug = $matches[1];
            $postByBase = Post::where('slug', $baseSlug)
                ->whereNotNull('published_at')
                ->where('published_at', '<=', now())
                ->first();

            if ($postByBase) {
                return redirect()->to(url('/' . $postByBase->slug), 301);
            }
        }

        // 3. Smart Match: If database has the slug WITH ID (e.g. /judul-post-36007),
        // but visitor requested the base slug without ID /judul-post
        $candidate = Post::where('slug', 'like', $slug . '-%')
            ->whereNotNull('published_at')
            ->where('published_at', '<=', now())
            ->get()
            ->first(function ($p) use ($slug) {
                return preg_match('/^' . preg_quote($slug, '/') . '-\d+$/', $p->slug);
            });

        if ($candidate) {
            return redirect()->to(url('/' . $candidate->slug), 301);
        }

        // Fallback to page
        $page = \App\Models\Page::where('slug', $slug)->first();
        if ($page) {
            if (!$page->is_published && !auth()->check()) {
                abort(404);
            }
            $isPreview = !$page->is_published && auth()->check();
            $page->content = $this->parseShortcodes($page->content);
            return view('pages.show', compact('page', 'isPreview'));
        }

        abort(404);
    }

    /**
     * Show Posts by Category
     */
    public function showCategory($slug)
    {
        $category = Category::where('slug', $slug)->firstOrFail();

        $posts = $category->posts()
            ->whereNotNull('published_at')
            ->where('published_at', '<=', now())
            ->latest('published_at')
            ->paginate(9);

        return view('frontend.category', compact('category', 'posts'));
    }

    /**
     * Show a specific Form
     */
    public function showForm($slug)
    {
        $form = Form::where('slug', $slug)
            ->where('is_active', true)
            ->firstOrFail();

        return view('frontend.form', compact('form'));
    }

    /**
     * Handle Form Submission
     */
    public function submitForm(Request $request, $slug)
    {
        $form = Form::where('slug', $slug)
            ->where('is_active', true)
            ->firstOrFail();

        // Dynamically build validation rules based on form structure
        $rules = [];
        $fields = is_string($form->fields) ? json_decode($form->fields, true) : $form->fields;
        $fileFields = [];

        if (is_array($fields)) {
            foreach ($fields as $field) {
                $label = $field['name'] ?? 'Untitled Field';
                $inputName = \Illuminate\Support\Str::slug($label, '_');
                $rule = [];

                if (!empty($field['required'])) {
                    $rule[] = 'required';
                } else {
                    $rule[] = 'nullable';
                }

                if ($field['type'] === 'email') {
                    $rule[] = 'email';
                } elseif ($field['type'] === 'number') {
                    $rule[] = 'numeric';
                } elseif ($field['type'] === 'date') {
                    $rule[] = 'date';
                } elseif ($field['type'] === 'file') {
                    $rule[] = 'file|mimes:jpg,jpeg,png,webp,pdf,doc,docx|max:2048'; // 2MB limit with safe MIME whitelist
                    $fileFields[] = $inputName;
                } elseif ($field['type'] === 'checkbox') {
                    $rule[] = 'array';
                }

                $rules[$inputName] = implode('|', $rule);
            }
        }

        // CAPTCHA & Honeypot Verification
        if ($form->use_captcha) {
            $captchaResult = \App\Services\CaptchaService::verify($request->all(), 'forms');
            if (!$captchaResult['success']) {
                \App\Services\SecurityService::logThreat('spam_bot', 'low', "Spam bot tertangkap pada Formulir Dinamis: " . $captchaResult['message']);
                return back()->withInput()->withErrors(['captcha' => $captchaResult['message']]);
            }
        }

        $validatedData = $request->validate($rules);
        $dataToSave = $validatedData;

        // Handle File Uploads
        foreach ($fileFields as $fileInputName) {
            if ($request->hasFile($fileInputName)) {
                $file = $request->file($fileInputName);
                // Save to 'local' disk instead of 'public' to prevent PII exposure
                $path = $file->store('submissions/' . $form->slug, 'local');
                $dataToSave[$fileInputName] = $path;
            }
        }

        // Save submission
        $form->submissions()->create([
            'data' => $dataToSave,
            'ip_address' => $request->ip(),
            'user_agent' => $request->userAgent(),
        ]);

        return redirect()->back()->with('success', 'Terima kasih! Formulir Anda telah berhasil dikirim.');
    }

    /**
     * Testimonials Listing Page
     */
    public function testimonials(Request $request)
    {
        $settings = \App\Models\Setting::pluck('value', 'key')->toArray();
        $query = \App\Models\Testimonial::where('is_active', true);

        if ($request->has('role') && in_array($request->role, ['parent', 'student', 'alumni'])) {
            $query->where('role', $request->role);
        }

        $testimonials = $query->latest()->paginate(12)->withQueryString();

        return view('testimonials.index', compact('testimonials', 'settings'));
    }

    /**
     * Halaman Khusus: Kurikulum Khas Al Irsyad
     */
    public function kurikulum()
    {
        $settings = \App\Models\Setting::pluck('value', 'key')->toArray();
        return view('frontend.kurikulum', compact('settings'));
    }

    /**
     * Halaman Khusus: Fasilitas & Sarana Prasarana
     */
    public function fasilitas()
    {
        $settings = \App\Models\Setting::pluck('value', 'key')->toArray();
        return view('frontend.fasilitas', compact('settings'));
    }

    /**
     * Halaman Khusus: Ekstrakurikuler & Pengembangan Bakat Santri
     */
    public function ekskul()
    {
        $settings = \App\Models\Setting::pluck('value', 'key')->toArray();
        return view('frontend.ekskul', compact('settings'));
    }

    /**
     * Halaman Khusus: Pearson International Class Program (ICP)
     */
    public function pearson()
    {
        $settings = \App\Models\Setting::pluck('value', 'key')->toArray();
        return view('frontend.pearson-icp', compact('settings'));
    }

    /**
     * Generate dynamic sitemap_index.xml
     */
    public function sitemapIndex()
    {
        return response()->view('frontend.sitemap.index')
            ->header('Content-Type', 'text/xml');
    }

    public function sitemapPosts()
    {
        $items = Post::whereNotNull('published_at')->where('published_at', '<=', now())->orderBy('updated_at', 'desc')->get();
        return response()->view('frontend.sitemap.items', ['items' => $items, 'type' => 'post'])
            ->header('Content-Type', 'text/xml');
    }

    public function sitemapPages()
    {
        $items = \App\Models\Page::where('status', 'published')->orderBy('updated_at', 'desc')->get();
        return response()->view('frontend.sitemap.items', ['items' => $items, 'type' => 'page'])
            ->header('Content-Type', 'text/xml');
    }

    public function sitemapCategories()
    {
        $items = Category::orderBy('updated_at', 'desc')->get();
        return response()->view('frontend.sitemap.items', ['items' => $items, 'type' => 'category'])
            ->header('Content-Type', 'text/xml');
    }

    public function sitemapEvents()
    {
        $items = \App\Models\Event::orderBy('updated_at', 'desc')->get();
        return response()->view('frontend.sitemap.items', ['items' => $items, 'type' => 'event'])
            ->header('Content-Type', 'text/xml');
    }

    /**
     * Generate dynamic robots.txt
     */
    public function robots()
    {
        $content = "User-agent: *\n";
        $content .= "Allow: /\n";
        $content .= "Disallow: /admin/\n";
        $content .= "Disallow: /install/\n\n";
        $content .= "Sitemap: " . url('sitemap_index.xml') . "\n";

        return response($content, 200)->header('Content-Type', 'text/plain');
    }

    /**
     * Parse Shortcodes in content
     */
    protected function parseShortcodes($content)
    {
        if (empty($content)) return $content;

        return preg_replace_callback('/\[form:([a-zA-Z0-9-]+)\]/', function ($matches) {
            $slug = $matches[1];
            $form = \App\Models\Form::where('slug', $slug)->where('is_active', true)->first();
            
            if (!$form) {
                return "<div style='padding:1rem;background:#fef2f2;color:#991b1b;border:1px solid #fecaca;border-radius:8px;'>[Formulir tidak ditemukan: {$slug}]</div>";
            }

            return view('frontend.partials.form-embed', compact('form'))->render();
        }, $content);
    }
}
