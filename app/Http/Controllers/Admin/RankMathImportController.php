<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Services\RankMathImportService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class RankMathImportController extends Controller
{
    /**
     * Tampilkan halaman awal import Rank Math.
     */
    public function index()
    {
        return view('admin.rankmath-import.index');
    }

    /**
     * Proses unggahan file JSON dan tampilkan pratinjau data.
     */
    public function preview(Request $request)
    {
        $request->validate([
            'json_file' => 'required|file|max:10240', // 10MB max
        ], [
            'json_file.required' => 'File JSON wajib diunggah.',
            'json_file.file' => 'Berkas harus berupa file yang valid.',
            'json_file.max' => 'Ukuran file maksimal adalah 10MB.',
        ]);

        $file = $request->file('json_file');

        if (strtolower($file->getClientOriginalExtension()) !== 'json') {
            return back()->with('error', 'File harus berformat .json dari hasil ekspor Rank Math.');
        }

        try {
            $service = new RankMathImportService();
            $data = $service->parseFile($file);

            if (empty($data)) {
                return back()->with('error', 'File JSON kosong atau tidak mengandung pengaturan Rank Math.');
            }

            // Preview what would be imported
            $preview = $service->preview($data);

            // Save parsed data to session for import step
            $path = $file->store('temp', 'local');
            session(['rankmath_import_file' => $path]);
            session(['rankmath_import_data' => $data]);

            return view('admin.rankmath-import.preview', compact('preview'));

        } catch (\Exception $e) {
            return back()->with('error', 'Terjadi kesalahan saat memproses file: ' . $e->getMessage());
        }
    }

    /**
     * Proses import data ke dalam database settings.
     */
    public function import(Request $request)
    {
        $data = session('rankmath_import_data');

        if (!$data) {
            return redirect()->route('admin.rankmath-import.index')
                ->with('error', 'Sesi import telah kedaluwarsa atau data tidak ditemukan. Silakan unggah ulang file JSON.');
        }

        try {
            $service = new RankMathImportService();
            $log = $service->import($data);

            // Log audit
            \App\Services\SecurityService::logAudit(
                'imported',
                'rankmath_settings',
                'Mengimpor ' . $log['summary']['imported'] . ' pengaturan SEO dari Rank Math'
            );

            // Clean up
            if (session()->has('rankmath_import_file')) {
                Storage::disk('local')->delete(session('rankmath_import_file'));
            }
            session()->forget(['rankmath_import_file', 'rankmath_import_data']);

            return view('admin.rankmath-import.result', compact('log'));

        } catch (\Exception $e) {
            return back()->with('error', 'Terjadi kesalahan saat mengimpor data: ' . $e->getMessage());
        }
    }
}
