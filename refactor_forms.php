<?php

// 1. Read form.blade.php
$content = file_get_contents('resources/views/frontend/form.blade.php');

// Extract the style block and form container
preg_match("/@push\('styles'\)(.*?)@endpush/s", $content, $style_match);
$style_content = isset($style_match[1]) ? trim($style_match[1]) : '';

preg_match('/<div class="form-container">.*?<\/div>\s*<\/div>/s', $content, $form_match);
$form_html = isset($form_match[0]) ? $form_match[0] : '';

if (!$form_html) {
    $parts = explode("@section('content')", $content);
    $parts2 = explode("@endsection", $parts[1]);
    $form_html = trim($parts2[0]);
}

// Create form-embed.blade.php
$embed_content = $style_content . "\n" . $form_html;
file_put_contents('resources/views/frontend/partials/form-embed.blade.php', $embed_content);

// Update form.blade.php to include the partial
$new_form_content = preg_replace(
    "/@push\('styles'\).*?@endsection/s",
    "@section('content')\n    @include('frontend.partials.form-embed')\n@endsection",
    $content
);
file_put_contents('resources/views/frontend/form.blade.php', $new_form_content);

// Update FrontendController
$controller_content = file_get_contents('app/Http/Controllers/FrontendController.php');

$shortcode_method = '
    /**
     * Parse Shortcodes in content
     */
    protected function parseShortcodes($content)
    {
        if (empty($content)) return $content;

        return preg_replace_callback(\'/\[form:([a-zA-Z0-9-]+)\]/\', function ($matches) {
            $slug = $matches[1];
            $form = \App\Models\Form::where(\'slug\', $slug)->where(\'is_active\', true)->first();
            
            if (!$form) return "<div style=\'padding:1rem;background:#fef2f2;color:#991b1b;border:1px solid #fecaca;border-radius:8px;\'>[Formulir tidak ditemukan: {$slug}]</div>";

            return view(\'frontend.partials.form-embed\', compact(\'form\'))->render();
        }, $content);
    }
';

// Inject parseShortcodes method before the last brace
$controller_content = preg_replace('/}\s*$/', $shortcode_method . "\n}\n", $controller_content);

// Apply parseShortcodes to showPost
$controller_content = str_replace(
    "return view('frontend.post', compact('post', 'recentPosts', 'categories', 'upcomingEvents'));",
    "\$post->content = \$this->parseShortcodes(\$post->content);\n        return view('frontend.post', compact('post', 'recentPosts', 'categories', 'upcomingEvents'));",
    $controller_content
);

// Apply parseShortcodes to showSlug (Pages)
$controller_content = str_replace(
    "return view('pages.show', compact('page', 'isPreview'));",
    "\$page->content = \$this->parseShortcodes(\$page->content);\n            return view('pages.show', compact('page', 'isPreview'));",
    $controller_content
);

file_put_contents('app/Http/Controllers/FrontendController.php', $controller_content);
echo "Done!\n";
