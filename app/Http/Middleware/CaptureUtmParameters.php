<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cookie;
use Symfony\Component\HttpFoundation\Response;

class CaptureUtmParameters
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        // Daftar parameter UTM dan kampanye yang dilacak
        $parametersToCapture = [
            'utm_source',
            'utm_medium',
            'utm_campaign',
            'utm_term',
            'utm_content',
            'fbclid',
            'gclid',
            'ttclid',
        ];

        $hasNewTrackingData = false;
        $trackingData = [];

        foreach ($parametersToCapture as $param) {
            // Jika ada di URL, tangkap dan simpan untuk diperbarui
            if ($request->has($param)) {
                $hasNewTrackingData = true;
                $trackingData[$param] = $request->input($param);
            } 
            // Jika tidak ada di URL tapi ada di Cookie, pertahankan
            elseif (Cookie::has($param)) {
                $trackingData[$param] = Cookie::get($param);
            }
        }

        // Jika ada parameter pelacakan baru dari URL, setel/perbarui cookie untuk 30 hari
        if ($hasNewTrackingData) {
            foreach ($trackingData as $key => $value) {
                // Set cookie: nama, value, durasi (dalam menit: 30 hari * 24 jam * 60 menit)
                Cookie::queue(Cookie::make($key, $value, 60 * 24 * 30));
            }
        }

        // Simpan data tracking di attributes request untuk akses mudah selama request berjalan
        $request->attributes->set('tracking_data', $trackingData);

        return $next($request);
    }
}
