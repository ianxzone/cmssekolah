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
            'seo_default_image' => 'nullable|image|max:2048',
        ]);

        $data = $request->except('_token');

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
            'matomo_disable_cookies'
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
            'curriculum_pillars'
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

        return redirect()->route('admin.settings.index')->with('success', 'System Settings updated successfully.');
    }
}
