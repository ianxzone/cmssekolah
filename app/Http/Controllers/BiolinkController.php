<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\BiolinkProfile;
use App\Models\BiolinkLink;

class BiolinkController extends Controller
{
    /**
     * Display the public biolink page.
     */
    public function index()
    {
        $profile = BiolinkProfile::where('is_active', true)
            ->with(['sections' => function ($query) {
                $query->where('is_active', true)
                    ->orderBy('sort_order', 'asc')
                    ->with(['activeLinks']);
            }])
            ->first();

        // Fallback auto-recovery: jika ada profil di database, pastikan tetap tampil dan auto-heal
        if (!$profile) {
            $fallback = BiolinkProfile::first();
            if ($fallback) {
                $fallback->update(['is_active' => true]);
                $profile = $fallback->load(['sections' => function ($query) {
                    $query->where('is_active', true)
                        ->orderBy('sort_order', 'asc')
                        ->with(['activeLinks']);
                }]);
            } else {
                abort(404, 'Halaman Biolink belum dikonfigurasi.');
            }
        }

        return view('frontend.biolink', compact('profile'));
    }

    /**
     * Track link click and redirect to destination.
     */
    public function click($id)
    {
        $link = BiolinkLink::findOrFail($id);
        $link->increment('clicks_count');

        return redirect()->away($link->url);
    }
}
