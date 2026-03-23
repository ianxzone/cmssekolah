<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Services\WPImportService;
use Illuminate\Http\Request;

class ImportController extends Controller
{
    protected $importService;

    public function __construct(WPImportService $importService)
    {
        $this->importService = $importService;
    }

    public function index()
    {
        return view('admin.tools.import');
    }

    public function store(Request $request)
    {
        $request->validate([
            'xml_file' => 'required|file|mimes:xml,wxr',
        ]);

        $xmlString = file_get_contents($request->file('xml_file')->getRealPath());
        
        try {
            $logs = $this->importService->importFromXml($xmlString);
            return redirect()->back()->with('success', 'Import Berhasil: ' . count($logs) . ' item diproses.')
                             ->with('import_logs', $logs);
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Import Gagal: ' . $e->getMessage());
        }
    }
}
