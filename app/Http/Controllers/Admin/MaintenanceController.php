<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Str;

class MaintenanceController extends Controller
{
    public function index()
    {
        $isDown = app()->isDownForMaintenance();

        // Use standard way to check secret if possible, or just look in storage file
        // Laravel's maintenance token is usually only needed during the request to bypass.
        // We can just generate a new secret each time we turn it on.
        return view('admin.maintenance.index', compact('isDown'));
    }

    public function toggle(Request $request)
    {
        $action = $request->input('action'); // 'up' or 'down'

        if ($action === 'down') {
            // Generate a random secret for bypassing
            $secret = Str::random(16);

            // Call artisan down with the secret
            Artisan::call('down', [
                '--secret' => $secret
            ]);

            // Save the secret temporarily in session so we can display it once
            session()->flash('success', 'Maintenance mode enabled. Setting bypass cookie...');
            session()->flash('maintenance_secret', $secret);

            // Redirect to the secret URL so Laravel natively sets the 'laravel_maintenance' cookie.
            // Afterwards, Laravel will automatically redirect the user to the frontend homepage (/).
            return redirect('/' . $secret);
        } elseif ($action === 'up') {
            Artisan::call('up');
            return redirect()->route('admin.maintenance.index')->with('success', 'Maintenance mode disabled.');
        }

        return redirect()->route('admin.maintenance.index')->with('error', 'Invalid action.');
    }

    public function clearCache()
    {
        Artisan::call('cache:clear');
        Artisan::call('view:clear');
        Artisan::call('config:clear');
        Artisan::call('route:clear');

        return redirect()->route('admin.maintenance.index')->with('success', 'Application cache cleared successfully!');
    }

    public function optimize()
    {
        Artisan::call('optimize');

        return redirect()->route('admin.maintenance.index')->with('success', 'Application optimized successfully!');
    }

    public function uploadUpdate(Request $request)
    {
        $request->validate([
            'update_file' => 'required|mimes:zip|max:51200', // max 50MB
        ]);

        if ($request->hasFile('update_file')) {
            $file = $request->file('update_file');
            $zip = new \ZipArchive;

            if ($zip->open($file->getRealPath()) === TRUE) {
                // Extract to base path
                $zip->extractTo(base_path());
                $zip->close();

                // Run migrations if any
                try {
                    Artisan::call('migrate', ['--force' => true]);
                } catch (\Exception $e) {
                    // Log error or ignore if no migrations
                }

                return redirect()->route('admin.maintenance.index')->with('success', 'Update script uploaded and extracted successfully!');
            } else {
                return redirect()->route('admin.maintenance.index')->with('error', 'Failed to open the zip file.');
            }
        }

        return redirect()->route('admin.maintenance.index')->with('error', 'No update file uploaded.');
    }
}
