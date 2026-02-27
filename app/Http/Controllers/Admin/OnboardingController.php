<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Setting;
use Illuminate\Support\Facades\DB;

class OnboardingController extends Controller
{
    public function index()
    {
        return view('admin.onboarding.index');
    }

    public function save(Request $request)
    {
        // Simple mapping of inputs to settings
        $settings = $request->only([
            'school_name',
            'school_logo',
            'school_tagline',
            'school_phone',
            'school_email',
            'school_address',
            'school_latitude',
            'school_longitude',
            'school_vision',
            'school_mission'
        ]);

        foreach ($settings as $key => $value) {
            if ($value !== null) {
                Setting::set($key, $value);
            }
        }

        // Mark onboarding as completed
        Setting::set('onboarding_completed', '1');

        return response()->json(['success' => true]);
    }

    public function skip()
    {
        Setting::set('onboarding_completed', '1');
        return redirect()->route('admin.dashboard');
    }
}
