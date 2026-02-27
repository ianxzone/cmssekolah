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
            $testimonials = \App\Models\Testimonial::where('is_active', true)
                ->latest()
                ->get();
        }

        return view('welcome', compact('settings', 'posts', 'events', 'testimonials'));
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
     * Show a detailed Post
     */
    public function showPost($slug)
    {
        $post = Post::with('category')
            ->where('slug', $slug)
            ->whereNotNull('published_at')
            ->where('published_at', '<=', now())
            ->firstOrFail();

        return view('frontend.post', compact('post'));
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
                    $rule[] = 'file|max:5120'; // 5MB limit
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
}
