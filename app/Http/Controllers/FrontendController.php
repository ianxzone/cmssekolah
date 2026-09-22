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
     * Resolve a slug — try Post first, then Page.
     */
    public function showSlug($slug)
    {
        // Try post first
        $post = Post::with('category')
            ->where('slug', $slug)
            ->whereNotNull('published_at')
            ->where('published_at', '<=', now())
            ->first();

        if ($post) {
            return $this->showPost($slug);
        }

        // Fallback to page
        $page = \App\Models\Page::where('slug', $slug)->firstOrFail();
        if (!$page->is_published && !auth()->check()) {
            abort(404);
        }
        $isPreview = !$page->is_published && auth()->check();
        return view('pages.show', compact('page', 'isPreview'));
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
                    $rule[] = 'file|max:2048'; // 2MB limit
                    $fileFields[] = $inputName;
                } elseif ($field['type'] === 'checkbox') {
                    $rule[] = 'array';
                }

                $rules[$inputName] = implode('|', $rule);
            }
        }

        $validatedData = $request->validate($rules);
        $dataToSave = $validatedData;

        // Handle File Uploads
        foreach ($fileFields as $fileInputName) {
            if ($request->hasFile($fileInputName)) {
                $file = $request->file($fileInputName);
                $path = $file->store('submissions/' . $form->slug, 'public');
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
     * Halaman Khusus: Pearson International Class Program (ICP)
     */
    public function pearson()
    {
        $settings = \App\Models\Setting::pluck('value', 'key')->toArray();
        return view('frontend.pearson-icp', compact('settings'));
    }

    /**
     * Generate dynamic sitemap.xml
     */
    public function sitemap()
    {
        $posts = Post::whereNotNull('published_at')->where('published_at', '<=', now())->orderBy('updated_at', 'desc')->get();
        $pages = \App\Models\Page::where('status', 'published')->orderBy('updated_at', 'desc')->get();
        $categories = Category::orderBy('updated_at', 'desc')->get();
        $events = \App\Models\Event::orderBy('updated_at', 'desc')->get();

        return response()->view('frontend.sitemap', compact('posts', 'pages', 'categories', 'events'))
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
        $content .= "Sitemap: " . url('sitemap.xml') . "\n";

        return response($content, 200)->header('Content-Type', 'text/plain');
    }
}
