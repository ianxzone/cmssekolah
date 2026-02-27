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

        return view('admin.dashboard', compact('stats', 'labels', 'chartData'));
    }
}
