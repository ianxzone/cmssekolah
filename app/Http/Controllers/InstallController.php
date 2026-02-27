<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\File;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class InstallController extends Controller
{
    public function index()
    {
        if (File::exists(storage_path('installed'))) {
            return redirect('/');
        }
        return view('install.index');
    }

    public function requirements()
    {
        $requirements = [
            'PHP >= 8.2' => PHP_VERSION_ID >= 80200,
            'BCMath Extension' => extension_loaded('bcmath'),
            'Ctype Extension' => extension_loaded('ctype'),
            'JSON Extension' => extension_loaded('json'),
            'Mbstring Extension' => extension_loaded('mbstring'),
            'OpenSSL Extension' => extension_loaded('openssl'),
            'PDO Extension' => extension_loaded('pdo'),
            'Tokenizer Extension' => extension_loaded('tokenizer'),
            'XML Extension' => extension_loaded('xml'),
            'Storage Writable' => is_writable(storage_path()),
            '.env Writable' => is_writable(base_path('.env')),
        ];

        return view('install.requirements', compact('requirements'));
    }

    public function environment()
    {
        return view('install.environment');
    }

    public function saveEnvironment(Request $request)
    {
        $request->validate([
            'app_name' => 'required',
            'db_host' => 'required',
            'db_port' => 'required',
            'db_database' => 'required',
            'db_username' => 'required',
        ]);

        $envFile = base_path('.env');
        $env = file_get_contents($envFile);

        $data = [
            'APP_NAME' => '"' . $request->app_name . '"',
            'DB_HOST' => $request->db_host,
            'DB_PORT' => $request->db_port,
            'DB_DATABASE' => $request->db_database,
            'DB_USERNAME' => $request->db_username,
            'DB_PASSWORD' => $request->db_password ?? '',
        ];

        foreach ($data as $key => $value) {
            $env = preg_replace("/^{$key}=.*/m", "{$key}={$value}", $env);
        }

        file_put_contents($envFile, $env);

        return redirect()->route('install.database');
    }

    public function database()
    {
        return view('install.database');
    }

    public function runMigration()
    {
        try {
            Artisan::call('migrate:fresh', ['--force' => true]);
            Artisan::call('db:seed', ['--force' => true]);
            return response()->json(['success' => true]);
        } catch (\Exception $e) {
            return response()->json(['success' => false, 'message' => $e->getMessage()]);
        }
    }

    public function admin()
    {
        return view('install.admin');
    }

    public function saveAdmin(Request $request)
    {
        $request->validate([
            'name' => 'required',
            'email' => 'required|email',
            'password' => 'required|min:8|confirmed',
        ]);

        // Clear existing users just in case
        User::truncate();

        User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'role' => 'admin', // Ensure role field exists or matches your schema
        ]);

        return redirect()->route('install.finish');
    }

    public function finish()
    {
        File::put(storage_path('installed'), date('Y-m-d H:i:s'));
        return view('install.finish');
    }
}
