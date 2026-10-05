<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Services\ImageService;
use Illuminate\Http\Request;

class SettingController extends Controller
{
    public function index()
    {
        $settings = \App\Models\Setting::pluck('value', 'key')->toArray();
        return view('admin.settings.index', compact('settings'));
    }

    public function update(Request $request)
    {
        $request->validate([
            'home_headmaster_image' => 'nullable|image|max:2048',
            'seo_default_image'     => 'nullable|image|max:2048',
            'site_logo_file'        => 'nullable|file|mimes:png,jpg,jpeg,svg,webp|max:4096',
            'site_favicon_file'     => 'nullable|file|mimes:ico,png,svg,jpg,jpeg|max:2048',
            'site_icon_file'        => 'nullable|file|mimes:png,jpg,jpeg,svg,webp|max:3072',
        ]);

        $data = $request->except('_token');

        // Handle Branding Assets (Logo, Favicon, Icon)
        $currentLogo = \App\Models\Setting::get('site_logo');
        if ($request->hasFile('site_logo_file')) {
            $path = $request->file('site_logo_file')->store('settings', 'public');
            \App\Models\Setting::set('site_logo', $path, 'image');
        } else {
            $url = trim($request->input('site_logo_url') ?? '');
            if (!empty($url)) {
                \App\Models\Setting::set('site_logo', $url, 'string');
            } elseif ($request->has('site_logo_url') && \Illuminate\Support\Str::startsWith($currentLogo ?? '', ['http://', 'https://'])) {
                \App\Models\Setting::set('site_logo', '', 'string');
            }
        }
        unset($data['site_logo_file'], $data['site_logo_url']);

        $currentFavicon = \App\Models\Setting::get('site_favicon');
        if ($request->hasFile('site_favicon_file')) {
            $path = $request->file('site_favicon_file')->store('settings', 'public');
            \App\Models\Setting::set('site_favicon', $path, 'image');
        } else {
            $url = trim($request->input('site_favicon_url') ?? '');
            if (!empty($url)) {
                \App\Models\Setting::set('site_favicon', $url, 'string');
            } elseif ($request->has('site_favicon_url') && \Illuminate\Support\Str::startsWith($currentFavicon ?? '', ['http://', 'https://'])) {
                \App\Models\Setting::set('site_favicon', '', 'string');
            }
        }
        unset($data['site_favicon_file'], $data['site_favicon_url']);

        $currentIcon = \App\Models\Setting::get('site_icon');
        if ($request->hasFile('site_icon_file')) {
            $path = $request->file('site_icon_file')->store('settings', 'public');
            \App\Models\Setting::set('site_icon', $path, 'image');
        } else {
            $url = trim($request->input('site_icon_url') ?? '');
            if (!empty($url)) {
                \App\Models\Setting::set('site_icon', $url, 'string');
            } elseif ($request->has('site_icon_url') && \Illuminate\Support\Str::startsWith($currentIcon ?? '', ['http://', 'https://'])) {
                \App\Models\Setting::set('site_icon', '', 'string');
            }
        }
        unset($data['site_icon_file'], $data['site_icon_url']);

        // Handle file uploads (e.g., headmaster_image, seo_default_image)
        if ($request->hasFile('home_headmaster_image')) {
            $optimized = ImageService::optimizeAndStore($request->file('home_headmaster_image'), 'settings', 'headmaster');
            \App\Models\Setting::set('home_headmaster_image', $optimized['path'], 'image');
            unset($data['home_headmaster_image']); // unset so we don't process it below
        }
        
        if ($request->hasFile('seo_default_image')) {
            $optimized = ImageService::optimizeAndStore($request->file('seo_default_image'), 'settings', 'og_image');
            \App\Models\Setting::set('seo_default_image', $optimized['path'], 'image');
            unset($data['seo_default_image']); // unset so we don't process it below
        }

        // Handle booleans (checkboxes are not sent if unchecked)
        $booleanKeys = [
            'home_show_headmaster',
            'home_show_stats',
            'home_show_news',
            'home_show_events',
            'home_show_facilities',
            'home_show_testimonials',
            'home_show_teachers',
            'home_show_prayer',
            'home_show_units',
            'home_show_curriculum',
            'home_show_pearson',
            'home_show_partnership',
            'matomo_disable_cookies',
            // SEO Booleans
            'seo_nofollow_external_links',
            'seo_new_window_external_links',
            'seo_breadcrumbs_enabled'
        ];

        foreach ($booleanKeys as $key) {
            $value = $request->has($key) ? '1' : '0';
            \App\Models\Setting::set($key, $value, 'boolean');
            unset($data[$key]); // unset processed items
        }

        // Handle array data structures (JSON conversion)
        $arrayKeys = [
            'navbar_links',
            'hero_slider_images',
            'stats_data',
            'school_missions',
            'superior_programs',
            'teachers_data',
            'facilities_list',
            'extracurriculars_list',
            'units_data',
            'curriculum_pillars',
            'partners_list',
            'seo_robots_global' // Rank Math Robots Array
        ];

        foreach ($arrayKeys as $key) {
            if ($request->has($key) && is_array($request->input($key))) {
                // Remove empty rows before encoding
                $filteredArray = array_filter($request->input($key), function ($item) {
                    if (is_array($item)) {
                        return !empty(array_filter($item, function ($val) {
                            return !is_null($val) && $val !== '';
                        }));
                    }
                    return !is_null($item) && $item !== '';
                });
                // Re-index array starting from 0
                $filteredArray = array_values($filteredArray);
                \App\Models\Setting::set($key, json_encode($filteredArray), 'json');
                unset($data[$key]);
            }
        }

        // Handle text/string inputs
        foreach ($data as $key => $value) {
            \App\Models\Setting::set($key, $value, 'text');
        }

        \App\Services\SecurityService::logAudit('updated', 'settings', 'Memperbarui pengaturan sistem dan identitas branding website');

        return redirect()->route('admin.settings.index')->with('success', 'System Settings updated successfully.');
    }
}
