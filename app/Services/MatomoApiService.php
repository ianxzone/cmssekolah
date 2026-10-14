<?php

namespace App\Services;

use App\Models\Setting;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Cache;
use Carbon\Carbon;

class MatomoApiService
{
    /**
     * Get active Matomo API base URL & Site ID based on user configuration.
     */
    public static function getConfig(): ?array
    {
        $source = Setting::get('matomo_api_source', 'self_hosted');
        $token = Setting::get('matomo_api_token', '');

        if (empty($token)) {
            return null;
        }

        if ($source === 'cloud') {
            $url = Setting::get('matomo_cloud_url', '');
            $siteId = Setting::get('matomo_cloud_site_id', '');
        } else {
            $url = Setting::get('matomo_self_hosted_url', '');
            $siteId = Setting::get('matomo_self_hosted_site_id', '');
        }

        if (empty($url) || empty($siteId)) {
            return null;
        }

        return [
            'url'     => rtrim($url, '/'),
            'site_id' => $siteId,
            'token'   => $token,
            'source'  => $source,
        ];
    }

    /**
     * Fetch Live Visits Summary from Matomo API (Cached for 30 minutes).
     */
    public static function getVisitsSummary(): ?array
    {
        $config = self::getConfig();
        if (!$config) {
            return null;
        }

        $cacheKey = 'matomo_visits_summary_' . $config['site_id'];

        return Cache::remember($cacheKey, 1800, function () use ($config) {
            try {
                $endpoint = $config['url'] . '/index.php';
                $response = Http::timeout(4)->get($endpoint, [
                    'module'     => 'API',
                    'method'     => 'VisitsSummary.get',
                    'idSite'     => $config['site_id'],
                    'period'     => 'range',
                    'date'       => Carbon::now()->subDays(6)->toDateString() . ',' . Carbon::now()->toDateString(),
                    'format'     => 'JSON',
                    'token_auth' => $config['token'],
                ]);

                if ($response->successful()) {
                    return $response->json();
                }
            } catch (\Throwable $e) {
                // Return null if request times out or server is offline
            }
            return null;
        });
    }

    /**
     * Fetch Daily Trend (Last 7 Days) for Chart.
     */
    public static function getDailyTrend(): ?array
    {
        $config = self::getConfig();
        if (!$config) {
            return null;
        }

        $cacheKey = 'matomo_daily_trend_' . $config['site_id'];

        return Cache::remember($cacheKey, 1800, function () use ($config) {
            try {
                $endpoint = $config['url'] . '/index.php';
                $response = Http::timeout(4)->get($endpoint, [
                    'module'     => 'API',
                    'method'     => 'VisitsSummary.getVisits',
                    'idSite'     => $config['site_id'],
                    'period'     => 'day',
                    'date'       => 'last7',
                    'format'     => 'JSON',
                    'token_auth' => $config['token'],
                ]);

                if ($response->successful()) {
                    return $response->json();
                }
            } catch (\Throwable $e) {
                // Return null on failure
            }
            return null;
        });
    }
}
