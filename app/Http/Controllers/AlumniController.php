<?php

namespace App\Http\Controllers;

use App\Models\AlumniAngkatan;
use App\Models\AlumniVideo;
use App\Models\Setting;

class AlumniController extends Controller
{
    /**
     * Display the public Alumni page
     */
    public function index()
    {
        // Check if alumni page is enabled
        $isActive = Setting::get('alumni_is_active', '1');
        if ($isActive !== '1') {
            abort(404);
        }

        $settings = Setting::pluck('value', 'key')->toArray();

        $angkatanList = AlumniAngkatan::active()
            ->ordered()
            ->get();

        $videos = AlumniVideo::active()
            ->ordered()
            ->get();

        return view('frontend.alumni', compact('settings', 'angkatanList', 'videos'));
    }
}
