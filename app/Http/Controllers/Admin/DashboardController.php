<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Page;
use App\Models\Post;
use App\Models\FormSubmission;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;

class DashboardController extends Controller
{
    /**
     * Handle the admin dashboard view.
     */
    public function index()
    {
        // Gather simple stats
        $stats = [
            'pages' => Page::count(),
            'posts' => Post::count(),
            'submissions' => FormSubmission::count(),
        ];

        // Chart Data: Submissions Over Time (Last 7 Days)
        $chartData = collect();
        $labels = collect();

        for ($i = 6; $i >= 0; $i--) {
            $date = Carbon::today()->subDays($i);
            $labels->push($date->format('M d'));

            $count = FormSubmission::whereDate('created_at', $date)->count();
            $chartData->push($count);
        }

        // PPDB & Lead Intelligence Stats (Fase 2)
        $ppdbStats = [
            'wa_today' => 0,
            'wa_7days' => 0,
            'wa_total' => 0,
            'spmb_today' => 0,
            'spmb_7days' => 0,
            'spmb_total' => 0,
            'brochure_total' => 0,
            'guestbook_total' => 0,
        ];
        $recentPpdbLeads = collect();

        try {
            if (\Illuminate\Support\Facades\Schema::hasTable('guest_book_entries')) {
                $ppdbStats['guestbook_total'] = \App\Models\GuestBookEntry::count();
            }

            if (\Illuminate\Support\Facades\Schema::hasTable('ppdb_events')) {
                $today = Carbon::today();
                $sevenDaysAgo = Carbon::today()->subDays(7);

                $ppdbStats['wa_today'] = \App\Models\PpdbEvent::where('event_name', 'click_wa_ppdb')
                    ->where('created_at', '>=', $today)
                    ->count();

                $ppdbStats['wa_7days'] = \App\Models\PpdbEvent::where('event_name', 'click_wa_ppdb')
                    ->where('created_at', '>=', $sevenDaysAgo)
                    ->count();

                $ppdbStats['wa_total'] = \App\Models\PpdbEvent::where('event_name', 'click_wa_ppdb')->count();

                $ppdbStats['spmb_today'] = \App\Models\PpdbEvent::where('event_name', 'click_spmb_portal')
                    ->where('created_at', '>=', $today)
                    ->count();

                $ppdbStats['spmb_7days'] = \App\Models\PpdbEvent::where('event_name', 'click_spmb_portal')
                    ->where('created_at', '>=', $sevenDaysAgo)
                    ->count();

                $ppdbStats['spmb_total'] = \App\Models\PpdbEvent::where('event_name', 'click_spmb_portal')->count();

                $ppdbStats['brochure_total'] = \App\Models\PpdbEvent::where('event_name', 'download_brosur')->count();

                $recentPpdbLeads = \App\Models\PpdbEvent::whereIn('event_name', ['click_wa_ppdb', 'click_spmb_portal', 'download_brosur'])
                    ->latest()
                    ->take(6)
                    ->get();
            }
        } catch (\Throwable $e) {
            // Graceful fallback if database is offline or not migrated yet
        }

        // Fetch Matomo API Analytics if configured (Fase 3)
        $matomoConfig = \App\Services\MatomoApiService::getConfig();
        $matomoSummary = null;
        $matomoTrend = null;

        if ($matomoConfig) {
            $matomoSummary = \App\Services\MatomoApiService::getVisitsSummary();
            $matomoTrend = \App\Services\MatomoApiService::getDailyTrend();
        }

        return view('admin.dashboard', compact('stats', 'labels', 'chartData', 'ppdbStats', 'recentPpdbLeads', 'matomoConfig', 'matomoSummary', 'matomoTrend'));
    }

    /**
     * Show the About & Promo page.
     */
    public function about()
    {
        return view('admin.about');
    }

    /**
     * Generate printable periodic analytics and PPDB report
     */
    public function report(Request $request)
    {
        $type = $request->query('type', 'month');
        if (!in_array($type, ['month', 'quarter', 'year'])) {
            $type = 'month';
        }

        $year = (int)$request->query('year', date('Y'));
        $month = (int)$request->query('month', date('n'));
        $quarter = (int)$request->query('quarter', ceil(date('n') / 3));

        $report = \App\Services\PpdbReportService::getReportData($type, $year, $month, $quarter);

        return view('admin.analytics.report', compact('report', 'type', 'year', 'month', 'quarter'));
    }
}
