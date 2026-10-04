import re

# 1. Read form.blade.php
with open('resources/views/frontend/form.blade.php', 'r', encoding='utf-8') as f:
    content = f.read()

# Extract the style block and form container
style_match = re.search(r'@push\(\'styles\'\)(.*?)@endpush', content, re.DOTALL)
style_content = style_match.group(1).strip() if style_match else ''

form_match = re.search(r'<div class="form-container">.*?</div>\s*</div>', content, re.DOTALL)
form_html = form_match.group(0) if form_match else ''

if not form_html:
    # fallback
    form_html = content.split("@section('content')")[1].split("@endsection")[0].strip()

# Create form-embed.blade.php
embed_content = f"""
{style_content}
{form_html}
"""
with open('resources/views/frontend/partials/form-embed.blade.php', 'w', encoding='utf-8') as f:
    f.write(embed_content)

# Update form.blade.php to include the partial
new_form_content = re.sub(
    r'@push\(\'styles\'\).*?@endsection',
    "@section('content')\n    @include('frontend.partials.form-embed')\n@endsection",
    content,
    flags=re.DOTALL
)
with open('resources/views/frontend/form.blade.php', 'w', encoding='utf-8') as f:
    f.write(new_form_content)

# Update FrontendController
with open('app/Http/Controllers/FrontendController.php', 'r', encoding='utf-8') as f:
    controller_content = f.read()

shortcode_method = '''
    /**
     * Parse Shortcodes in content
     */
    protected function parseShortcodes($content)
    {
        if (empty($content)) return $content;

        return preg_replace_callback('/\[form:([a-zA-Z0-9-]+)\]/', function ($matches) {
            $slug = $matches[1];
            $form = \App\Models\Form::where('slug', $slug)->where('is_active', true)->first();
            
            if (!$form) return "<div style='padding:1rem;background:#fef2f2;color:#991b1b;border:1px solid #fecaca;border-radius:8px;'>[Formulir tidak ditemukan: {$slug}]</div>";

            return view('frontend.partials.form-embed', compact('form'))->render();
        }, $content);
    }
'''

# Inject parseShortcodes method before the last brace
controller_content = re.sub(r'}\s*$', shortcode_method + '\n}\n', controller_content)

# Apply parseShortcodes to showPost
controller_content = controller_content.replace(
    "return view('frontend.post', compact('post', 'recentPosts', 'categories', 'upcomingEvents'));",
    "$post->content = $this->parseShortcodes($post->content);\n        return view('frontend.post', compact('post', 'recentPosts', 'categories', 'upcomingEvents'));"
)

# Apply parseShortcodes to showSlug (Pages)
controller_content = controller_content.replace(
    "return view('pages.show', compact('page', 'isPreview'));",
    "$page->content = $this->parseShortcodes($page->content);\n            return view('pages.show', compact('page', 'isPreview'));"
)

with open('app/Http/Controllers/FrontendController.php', 'w', encoding='utf-8') as f:
    f.write(controller_content)
print('Done!')
