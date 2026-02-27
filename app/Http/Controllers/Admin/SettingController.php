<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
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
        $data = $request->except('_token');

        // Handle file uploads (e.g., headmaster_image, logos)
        $imageFields = ['home_headmaster_image', 'school_logo', 'school_favicon'];
        foreach ($imageFields as $field) {
            if ($request->hasFile($field)) {
                $imagePath = $request->file($field)->store('settings', 'public');
                \App\Models\Setting::set($field, $imagePath, 'image');
                unset($data[$field]); // unset so we don't process it below
            }
        }

        // Handle booleans (checkboxes are not sent if unchecked)
        $booleanKeys = [
            'home_show_headmaster',
            'home_show_stats',
            'home_show_news',
            'home_show_events',
            'home_show_facilities',
            'home_show_testimonials'
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
            'superior_programs',
            'teachers_data',
            'facilities_list',
            'extracurriculars_list'
        ];

        foreach ($arrayKeys as $key) {
            if ($request->has($key) && is_array($request->input($key))) {
                // Remove empty rows before encoding
                $filteredArray = array_filter($request->input($key), function ($item) {
                    // Check if at least one meaningful sub-key has a value
                    return !empty(array_filter($item));
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
