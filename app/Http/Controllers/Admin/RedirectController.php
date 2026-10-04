<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Redirect;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\StreamedResponse;

class RedirectController extends Controller
{
    /**
     * Display a listing of redirects with stats & search.
     */
    public function index(Request $request)
    {
        $query = Redirect::query();

        // Search
        if ($request->filled('search')) {
            $search = $request->input('search');
            $query->where(function ($q) use ($search) {
                $q->where('source_url', 'like', "%{$search}%")
                  ->orWhere('target_url', 'like', "%{$search}%")
                  ->orWhere('notes', 'like', "%{$search}%");
            });
        }

        // Filter status code
        if ($request->filled('code')) {
            $query->where('status_code', $request->input('code'));
        }

        // Filter match type
        if ($request->filled('match_type')) {
            $query->where('match_type', $request->input('match_type'));
        }

        // Filter active status
        if ($request->filled('status')) {
            $query->where('is_active', $request->input('status') === '1');
        }

        // Stats
        $stats = [
            'total' => Redirect::count(),
            'active' => Redirect::where('is_active', true)->count(),
            'total_hits' => Redirect::sum('hits'),
            'type_301' => Redirect::where('status_code', 301)->count(),
        ];

        $redirects = $query->latest('id')->paginate(15)->withQueryString();

        return view('admin.redirects.index', compact('redirects', 'stats'));
    }

    /**
     * Store a newly created redirect.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'source_url' => 'required|string|max:500',
            'target_url' => 'required|string|max:1000',
            'match_type' => 'required|in:exact,prefix,regex',
            'status_code' => 'required|integer|in:301,302,307,410',
            'notes' => 'nullable|string|max:500',
            'is_active' => 'nullable|boolean',
        ]);

        $validated['is_active'] = $request->boolean('is_active', true);

        // Normalize if not regex
        if ($validated['match_type'] !== 'regex') {
            $validated['source_url'] = Redirect::normalizePath($validated['source_url']);
        }

        Redirect::create($validated);

        return redirect()->route('admin.redirects.index')
            ->with('success', 'Aturan pengalihan (redirect) berhasil ditambahkan.');
    }

    /**
     * Update the specified redirect.
     */
    public function update(Request $request, Redirect $redirect)
    {
        $validated = $request->validate([
            'source_url' => 'required|string|max:500',
            'target_url' => 'required|string|max:1000',
            'match_type' => 'required|in:exact,prefix,regex',
            'status_code' => 'required|integer|in:301,302,307,410',
            'notes' => 'nullable|string|max:500',
            'is_active' => 'nullable|boolean',
        ]);

        $validated['is_active'] = $request->boolean('is_active', true);

        if ($validated['match_type'] !== 'regex') {
            $validated['source_url'] = Redirect::normalizePath($validated['source_url']);
        }

        $redirect->update($validated);

        return redirect()->route('admin.redirects.index')
            ->with('success', 'Aturan redirect berhasil diperbarui.');
    }

    /**
     * Remove the specified redirect.
     */
    public function destroy(Redirect $redirect)
    {
        $redirect->delete();

        return redirect()->route('admin.redirects.index')
            ->with('success', 'Aturan redirect berhasil dihapus.');
    }

    /**
     * Toggle the active status of a redirect.
     */
    public function toggle(Redirect $redirect)
    {
        $redirect->update(['is_active' => !$redirect->is_active]);

        $statusText = $redirect->is_active ? 'diaktifkan' : 'dinonaktifkan';
        return redirect()->route('admin.redirects.index')
            ->with('success', "Redirect {$redirect->source_url} berhasil {$statusText}.");
    }

    /**
     * Import redirects from Rank Math SEO export file (CSV or JSON).
     */
    public function import(Request $request)
    {
        $request->validate([
            'import_file' => 'required|file|max:20480', // 20MB
        ], [
            'import_file.required' => 'Pilih file ekspor Rank Math terlebih dahulu.',
            'import_file.max' => 'Ukuran file maksimal 20MB.',
        ]);

        $file = $request->file('import_file');
        $ext = strtolower($file->getClientOriginalExtension());
        $originalName = strtolower($file->getClientOriginalName());

        if (!in_array($ext, ['csv', 'json', 'txt', 'htaccess']) && !str_ends_with($originalName, '.htaccess')) {
            return back()->with('error', 'Format file tidak didukung. Harap upload file CSV, JSON, atau .htaccess dari Rank Math.');
        }

        $imported = 0;
        $updated = 0;

        try {
            if ($ext === 'json') {
                $content = file_get_contents($file->getRealPath());
                $data = json_decode($content, true);

                if (!is_array($data)) {
                    return back()->with('error', 'Format file JSON tidak valid.');
                }

                // Handle nested structure if Rank Math wraps in key
                $items = isset($data['redirections']) ? $data['redirections'] : $data;

                foreach ($items as $item) {
                    $target = $item['redirect_to'] ?? $item['target_url'] ?? $item['destination'] ?? null;
                    $code = intval($item['header_code'] ?? $item['status_code'] ?? 301);
                    $hits = intval($item['hits'] ?? 0);

                    // Normalize status: handle 'active'/'inactive', 1/0, true/false, 'on'/'off'
                    $rawStatus = $item['status'] ?? $item['is_active'] ?? 'active';
                    $isActive = !in_array($rawStatus, ['inactive', '0', 0, false, 'false', 'off'], true);

                    // Rank Math may use a nested `sources` array with pattern + comparison
                    $sourceEntries = [];
                    if (!empty($item['sources']) && is_array($item['sources'])) {
                        foreach ($item['sources'] as $src) {
                            $pattern = $src['pattern'] ?? null;
                            $comparison = strtolower($src['comparison'] ?? 'exact');

                            // Map Rank Math comparison types to our match types
                            if (in_array($comparison, ['start', 'contains', 'prefix'])) {
                                $comparison = 'prefix';
                            } elseif ($comparison === 'regex') {
                                $comparison = 'regex';
                            } else {
                                $comparison = 'exact';
                            }

                            if ($pattern) {
                                $sourceEntries[] = ['source' => $pattern, 'match_type' => $comparison];
                            }
                        }
                    }

                    // Fallback: use flat source URL if no sources array
                    if (empty($sourceEntries)) {
                        $source = $item['url_to_redirect'] ?? $item['source_url'] ?? $item['source'] ?? null;
                        if (!$source || !$target) {
                            continue;
                        }
                        $matchingType = strtolower($item['matching_type'] ?? $item['match_type'] ?? 'exact');
                        if (!in_array($matchingType, ['exact', 'prefix', 'regex'])) {
                            $matchingType = 'exact';
                        }
                        $sourceEntries[] = ['source' => $source, 'match_type' => $matchingType];
                    }

                    if (!$target) {
                        continue;
                    }

                    // Create a redirect for each source entry
                    foreach ($sourceEntries as $entry) {
                        $normalizedSource = $entry['match_type'] !== 'regex'
                            ? Redirect::normalizePath($entry['source'])
                            : trim($entry['source']);

                        $redirect = Redirect::updateOrCreate(
                            ['source_url' => $normalizedSource],
                            [
                                'target_url' => trim($target),
                                'match_type' => $entry['match_type'],
                                'status_code' => in_array($code, [301, 302, 307, 410]) ? $code : 301,
                                'hits' => $hits,
                                'is_active' => $isActive,
                                'notes' => 'Diimpor dari Rank Math JSON',
                            ]
                        );

                        if ($redirect->wasRecentlyCreated) {
                            $imported++;
                        } else {
                            $updated++;
                        }
                    }
                }
            } elseif ($ext === 'csv') {
                // CSV Parsing
                $handle = fopen($file->getRealPath(), 'r');
                if (!$handle) {
                    return back()->with('error', 'Gagal membaca file CSV.');
                }

                $header = fgetcsv($handle);
                if (!$header) {
                    fclose($handle);
                    return back()->with('error', 'File CSV kosong.');
                }
                // Clean BOM and lowercase header keys
                $cleanHeaders = array_map(function ($h) {
                    return strtolower(trim(preg_replace('/[\x00-\x1F\x80-\xFF]/', '', $h)));
                }, $header);

                // Find column indexes
                $sourceIdx = null;
                $targetIdx = null;
                $codeIdx = null;
                $matchIdx = null;
                $hitsIdx = null;
                $statusIdx = null;

                foreach ($cleanHeaders as $i => $h) {
                    if (in_array($h, ['url_to_redirect', 'source', 'source_url', 'from', 'url'])) $sourceIdx = $i;
                    if (in_array($h, ['redirect_to', 'destination', 'target_url', 'target', 'to'])) $targetIdx = $i;
                    if (in_array($h, ['header_code', 'status_code', 'type', 'code'])) $codeIdx = $i;
                    if (in_array($h, ['matching_type', 'match_type', 'match'])) $matchIdx = $i;
                    if (in_array($h, ['hits', 'count', 'views'])) $hitsIdx = $i;
                    if (in_array($h, ['status', 'is_active', 'active'])) $statusIdx = $i;
                }

                // If headers not matched, fall back to index 0 (source) and index 1 (target)
                if ($sourceIdx === null && count($cleanHeaders) >= 2) {
                    $sourceIdx = 0;
                    $targetIdx = 1;
                    $codeIdx = count($cleanHeaders) >= 3 ? 2 : null;
                }

                while (($row = fgetcsv($handle)) !== false) {
                    if (!isset($row[$sourceIdx]) || !isset($row[$targetIdx])) {
                        continue;
                    }

                    $source = trim($row[$sourceIdx]);
                    $target = trim($row[$targetIdx]);

                    if (empty($source) || empty($target)) {
                        continue;
                    }

                    $code = 301;
                    if ($codeIdx !== null && isset($row[$codeIdx]) && is_numeric($row[$codeIdx])) {
                        $code = intval($row[$codeIdx]);
                    }

                    $matchingType = 'exact';
                    if ($matchIdx !== null && isset($row[$matchIdx])) {
                        $m = strtolower(trim($row[$matchIdx]));
                        if (in_array($m, ['exact', 'prefix', 'regex'])) {
                            $matchingType = $m;
                        }
                    }

                    $hits = 0;
                    if ($hitsIdx !== null && isset($row[$hitsIdx]) && is_numeric($row[$hitsIdx])) {
                        $hits = intval($row[$hitsIdx]);
                    }

                    $isActive = true;
                    if ($statusIdx !== null && isset($row[$statusIdx])) {
                        $st = strtolower(trim($row[$statusIdx]));
                        if (in_array($st, ['0', 'false', 'inactive', 'off'])) {
                            $isActive = false;
                        }
                    }

                    $normalizedSource = $matchingType !== 'regex' ? Redirect::normalizePath($source) : $source;

                    $redirect = Redirect::updateOrCreate(
                        ['source_url' => $normalizedSource],
                        [
                            'target_url' => $target,
                            'match_type' => $matchingType,
                            'status_code' => in_array($code, [301, 302, 307, 410]) ? $code : 301,
                            'hits' => $hits,
                            'is_active' => $isActive,
                            'notes' => 'Diimpor dari Rank Math CSV',
                        ]
                    );

                    if ($redirect->wasRecentlyCreated) {
                        $imported++;
                    } else {
                        $updated++;
                    }
                }

                fclose($handle);
            } else {
                // Text / .htaccess / Nginx Parsing
                $content = file_get_contents($file->getRealPath());
                $lines = explode("\n", $content);
                
                foreach ($lines as $line) {
                    $line = trim($line);
                    if (empty($line) || str_starts_with($line, '#')) continue;
                    
                    $source = null;
                    $target = null;
                    $code = 301;
                    $matchType = 'exact';
                    
                    // .htaccess format: Redirect 301 /old https://new
                    if (preg_match('/^Redirect\s+([0-9]+)\s+([^\s]+)\s+([^\s]+)$/i', $line, $matches)) {
                        $code = intval($matches[1]);
                        $source = $matches[2];
                        $target = $matches[3];
                    } 
                    // .htaccess format: RedirectMatch 301 ^/old/?$ https://new
                    elseif (preg_match('/^RedirectMatch\s+([0-9]+)\s+([^\s]+)\s+([^\s]+)$/i', $line, $matches)) {
                        $code = intval($matches[1]);
                        $source = $matches[2];
                        $target = $matches[3];
                        $matchType = 'regex';
                    }
                    // .htaccess format: RewriteRule ^old$ /new [R=301,L]
                    elseif (preg_match('/^RewriteRule\s+([^\s]+)\s+([^\s]+)/i', $line, $matches)) {
                        $source = $matches[1];
                        $target = $matches[2];
                        $code = 301;
                        if (preg_match('/R=([0-9]+)/i', $line, $codeMatches)) {
                            $code = intval($codeMatches[1]);
                        }
                        $matchType = 'regex';
                    }
                    // Nginx format: rewrite ^/old/?$ https://new permanent;
                    elseif (preg_match('/^rewrite\s+([^\s]+)\s+([^\s]+)\s+(permanent|redirect);$/i', $line, $matches)) {
                        $source = $matches[1];
                        $target = $matches[2];
                        $code = strtolower($matches[3]) === 'permanent' ? 301 : 302;
                        $matchType = 'regex';
                    }

                    if ($source && $target) {
                        // Clean Rank Math's basic RewriteRule regex (e.g. ^path/?$) to exact match
                        if ($matchType === 'regex') {
                            $cleanSource = str_replace(['^', '$', '/?'], '', $source);
                            $cleanSource = trim($cleanSource, '/');
                            
                            // If it doesn't contain other regex characters, treat as exact
                            if (!preg_match('/[\(\)\.\*\+\[\]\|]/', $cleanSource)) {
                                $matchType = 'exact';
                                $source = $cleanSource;
                            }
                        }

                        $normalizedSource = $matchType !== 'regex'
                            ? Redirect::normalizePath($source)
                            : trim($source);

                        $redirect = Redirect::updateOrCreate(
                            ['source_url' => $normalizedSource],
                            [
                                'target_url' => trim($target),
                                'match_type' => $matchType,
                                'status_code' => in_array($code, [301, 302, 307, 410]) ? $code : 301,
                                'hits' => 0,
                                'is_active' => true,
                                'notes' => 'Diimpor dari file Text/Server Config',
                            ]
                        );

                        if ($redirect->wasRecentlyCreated) {
                            $imported++;
                        } else {
                            $updated++;
                        }
                    }
                }
            }

            return redirect()->route('admin.redirects.index')
                ->with('success', "Proses import selesai: {$imported} aturan baru ditambahkan, {$updated} aturan diperbarui.");

        } catch (\Throwable $e) {
            return back()->with('error', 'Terjadi kesalahan saat mengimpor file: ' . $e->getMessage());
        }
    }

    /**
     * Export all redirects to CSV file.
     */
    public function export(): StreamedResponse
    {
        $fileName = 'sdit-redirects-' . date('Y-m-d') . '.csv';

        return response()->streamDownload(function () {
            $handle = fopen('php://output', 'w');

            // UTF-8 BOM for Excel compatibility
            fprintf($handle, chr(0xEF) . chr(0xBB) . chr(0xBF));

            // Header matching Rank Math / standard CSV
            fputcsv($handle, [
                'url_to_redirect',
                'redirect_to',
                'header_code',
                'matching_type',
                'hits',
                'status',
                'notes',
            ]);

            Redirect::orderBy('id', 'asc')->chunk(200, function ($redirects) use ($handle) {
                foreach ($redirects as $r) {
                    fputcsv($handle, [
                        $r->source_url,
                        $r->target_url,
                        $r->status_code,
                        $r->match_type,
                        $r->hits,
                        $r->is_active ? 'active' : 'inactive',
                        $r->notes ?? '',
                    ]);
                }
            });

            fclose($handle);
        }, $fileName, [
            'Content-Type' => 'text/csv; charset=UTF-8',
            'Cache-Control' => 'no-cache, no-store, must-revalidate',
        ]);
    }
}
