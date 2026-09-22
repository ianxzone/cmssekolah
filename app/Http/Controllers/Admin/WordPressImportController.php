<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Services\WordPressImportService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class WordPressImportController extends Controller
{
    /**
     * Tampilkan halaman awal import WordPress.
     */
    public function index()
    {
        return view('admin.wordpress-import.index');
    }

    /**
     * Proses unggahan file XML dan tampilkan pratinjau data.
     */
    public function preview(Request $request)
    {
        $request->validate([
            'xml_file' => 'required|file|max:51200'
        ], [
            'xml_file.required' => 'File XML wajib diunggah.',
            'xml_file.file' => 'Berkas harus berupa file yang valid.',
            'xml_file.max' => 'Ukuran file maksimal adalah 50MB.'
        ]);

        $file = $request->file('xml_file');
        
        if ($file->getClientOriginalExtension() !== 'xml') {
            return back()->with('error', 'File harus berekstensi .xml.');
        }

        try {
            $path = $file->store('temp', 'local');
            $fullPath = Storage::disk('local')->path($path);

            $service = new WordPressImportService();
            $data = $service->parseXml($fullPath);

            if (empty($data)) {
                return back()->with('error', 'Gagal membaca file XML atau file kosong.');
            }

            session(['wp_import_file' => $path]);
            session(['wp_import_data' => $data]);

            return view('admin.wordpress-import.preview', compact('data'));

        } catch (\Exception $e) {
            return back()->with('error', 'Terjadi kesalahan saat memproses file: ' . $e->getMessage());
        }
    }

    /**
     * Proses import data ke dalam database.
     */
    public function import(Request $request)
    {
        $request->validate([
            'import_categories' => 'nullable|boolean',
            'import_tags' => 'nullable|boolean',
            'import_posts' => 'nullable|boolean',
            'import_pages' => 'nullable|boolean',
            'download_images' => 'nullable|boolean',
            'duplicate_handling' => 'nullable|in:skip,rename',
        ]);

        $data = session('wp_import_data');
        
        if (!$data) {
            return redirect()->route('admin.wordpress-import.index')
                             ->with('error', 'Sesi import telah kedaluwarsa atau data tidak ditemukan. Silakan unggah ulang file XML.');
        }

        set_time_limit(300);
        ini_set('memory_limit', '512M');

        try {
            $options = [
                'import_categories' => $request->boolean('import_categories'),
                'import_tags' => $request->boolean('import_tags'),
                'import_posts' => $request->boolean('import_posts'),
                'import_pages' => $request->boolean('import_pages'),
                'download_images' => $request->boolean('download_images'),
                'duplicate_handling' => $request->input('duplicate_handling', 'skip')
            ];

            $service = new WordPressImportService();
            $service->import($data, $options);
            
            $log = $service->getLog();

            // Clean up
            if (session()->has('wp_import_file')) {
                Storage::disk('local')->delete(session('wp_import_file'));
            }
            session()->forget(['wp_import_file', 'wp_import_data']);

            return view('admin.wordpress-import.result', compact('log'));

        } catch (\Exception $e) {
            return back()->with('error', 'Terjadi kesalahan saat mengimpor data: ' . $e->getMessage());
        }
    }
}
