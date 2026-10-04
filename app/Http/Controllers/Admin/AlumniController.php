<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\AlumniAngkatan;
use App\Models\AlumniVideo;
use App\Models\Setting;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class AlumniController extends Controller
{
    /**
     * Admin alumni index — tabbed interface: Angkatan | Video | Settings
     */
    public function index(Request $request)
    {
        $tab = $request->get('tab', 'angkatan');

        $angkatanList = AlumniAngkatan::orderBy('tahun_lulus', 'desc')->get();
        $videoList = AlumniVideo::orderBy('sort_order', 'asc')->orderBy('tahun', 'desc')->get();

        $settings = Setting::pluck('value', 'key')->toArray();

        return view('admin.alumni.index', compact('tab', 'angkatanList', 'videoList', 'settings'));
    }

    // ─── ANGKATAN CRUD ────────────────────────────────────────

    public function storeAngkatan(Request $request)
    {
        $validated = $request->validate([
            'tahun_lulus'       => 'required|integer|min:2000|max:2100|unique:alumni_angkatan,tahun_lulus',
            'nama_angkatan'    => 'required|string|max:100',
            'nomor_angkatan'   => 'required|integer|min:1',
            'persen_ptn'       => 'nullable|numeric|min:0|max:100',
            'persen_pts'       => 'nullable|numeric|min:0|max:100',
            'persen_ptln'      => 'nullable|numeric|min:0|max:100',
            'persen_kedinasan' => 'nullable|numeric|min:0|max:100',
            'flyer_image'      => 'nullable|image|max:5120',
            'catatan'          => 'nullable|string|max:1000',
            'is_highlighted'   => 'nullable|boolean',
            'is_active'        => 'nullable|boolean',
        ]);

        // Handle flyer upload
        if ($request->hasFile('flyer_image')) {
            $validated['flyer_image'] = $request->file('flyer_image')->store('alumni/flyers', 'public');
        }

        $validated['is_highlighted'] = $request->boolean('is_highlighted');
        $validated['is_active'] = $request->boolean('is_active', true);
        $validated['sort_order'] = AlumniAngkatan::max('sort_order') + 1;

        $createdAngkatan = AlumniAngkatan::create($validated);
        \App\Services\SecurityService::logAudit('created', 'alumni', "Menambah angkatan alumni: {$createdAngkatan->nama_angkatan} ({$createdAngkatan->tahun_lulus})", (string)$createdAngkatan->id, null, $createdAngkatan->toArray());

        return redirect()->route('admin.alumni.index', ['tab' => 'angkatan'])
            ->with('success', 'Angkatan alumni berhasil ditambahkan!');
    }

    public function updateAngkatan(Request $request, $id)
    {
        $angkatan = AlumniAngkatan::findOrFail($id);

        $validated = $request->validate([
            'tahun_lulus'       => 'required|integer|min:2000|max:2100|unique:alumni_angkatan,tahun_lulus,' . $id,
            'nama_angkatan'    => 'required|string|max:100',
            'nomor_angkatan'   => 'required|integer|min:1',
            'persen_ptn'       => 'nullable|numeric|min:0|max:100',
            'persen_pts'       => 'nullable|numeric|min:0|max:100',
            'persen_ptln'      => 'nullable|numeric|min:0|max:100',
            'persen_kedinasan' => 'nullable|numeric|min:0|max:100',
            'flyer_image'      => 'nullable|image|max:5120',
            'catatan'          => 'nullable|string|max:1000',
            'is_highlighted'   => 'nullable|boolean',
            'is_active'        => 'nullable|boolean',
        ]);

        // Handle flyer upload
        if ($request->hasFile('flyer_image')) {
            // Delete old flyer
            if ($angkatan->flyer_image) {
                Storage::disk('public')->delete($angkatan->flyer_image);
            }
            $validated['flyer_image'] = $request->file('flyer_image')->store('alumni/flyers', 'public');
        }

        $validated['is_highlighted'] = $request->boolean('is_highlighted');
        $validated['is_active'] = $request->boolean('is_active', true);

        $oldData = $angkatan->toArray();
        $angkatan->update($validated);

        \App\Services\SecurityService::logAudit('updated', 'alumni', "Memperbarui angkatan alumni: {$angkatan->nama_angkatan} ({$angkatan->tahun_lulus})", (string)$angkatan->id, $oldData, $angkatan->fresh()->toArray());

        return redirect()->route('admin.alumni.index', ['tab' => 'angkatan'])
            ->with('success', 'Angkatan alumni berhasil diperbarui!');
    }

    public function destroyAngkatan($id)
    {
        $angkatan = AlumniAngkatan::findOrFail($id);
        $oldData = $angkatan->toArray();

        // Delete flyer file
        if ($angkatan->flyer_image) {
            Storage::disk('public')->delete($angkatan->flyer_image);
        }

        $angkatan->delete();

        \App\Services\SecurityService::logAudit('deleted', 'alumni', "Menghapus angkatan alumni: {$angkatan->nama_angkatan} ({$angkatan->tahun_lulus})", (string)$id, $oldData);

        return redirect()->route('admin.alumni.index', ['tab' => 'angkatan'])
            ->with('success', 'Angkatan alumni berhasil dihapus!');
    }

    // ─── VIDEO CRUD ───────────────────────────────────────────

    public function storeVideo(Request $request)
    {
        $validated = $request->validate([
            'judul'       => 'required|string|max:255',
            'deskripsi'   => 'nullable|string|max:1000',
            'youtube_url' => 'required|url|max:500',
            'tahun'       => 'nullable|integer|min:2000|max:2100',
            'is_active'   => 'nullable|boolean',
        ]);

        // Extract embed ID
        $embedId = AlumniVideo::extractYoutubeId($validated['youtube_url']);
        if (!$embedId) {
            return back()->withErrors(['youtube_url' => 'URL YouTube tidak valid.'])->withInput();
        }

        $validated['youtube_embed_id'] = $embedId;
        $validated['is_active'] = $request->boolean('is_active', true);
        $validated['sort_order'] = AlumniVideo::max('sort_order') + 1;

        AlumniVideo::create($validated);

        return redirect()->route('admin.alumni.index', ['tab' => 'video'])
            ->with('success', 'Video alumni berhasil ditambahkan!');
    }

    public function updateVideo(Request $request, $id)
    {
        $video = AlumniVideo::findOrFail($id);

        $validated = $request->validate([
            'judul'       => 'required|string|max:255',
            'deskripsi'   => 'nullable|string|max:1000',
            'youtube_url' => 'required|url|max:500',
            'tahun'       => 'nullable|integer|min:2000|max:2100',
            'is_active'   => 'nullable|boolean',
        ]);

        $embedId = AlumniVideo::extractYoutubeId($validated['youtube_url']);
        if (!$embedId) {
            return back()->withErrors(['youtube_url' => 'URL YouTube tidak valid.'])->withInput();
        }

        $validated['youtube_embed_id'] = $embedId;
        $validated['is_active'] = $request->boolean('is_active', true);

        $video->update($validated);

        return redirect()->route('admin.alumni.index', ['tab' => 'video'])
            ->with('success', 'Video alumni berhasil diperbarui!');
    }

    public function destroyVideo($id)
    {
        $video = AlumniVideo::findOrFail($id);
        $video->delete();

        return redirect()->route('admin.alumni.index', ['tab' => 'video'])
            ->with('success', 'Video alumni berhasil dihapus!');
    }

    // ─── SETTINGS ─────────────────────────────────────────────

    public function updateSettings(Request $request)
    {
        $validated = $request->validate([
            'alumni_hero_title'       => 'nullable|string|max:200',
            'alumni_hero_subtitle'    => 'nullable|string|max:200',
            'alumni_hero_description' => 'nullable|string|max:1000',
            'alumni_stats_title'      => 'nullable|string|max:200',
            'alumni_flyer_title'      => 'nullable|string|max:200',
            'alumni_brand_title'      => 'nullable|string|max:200',
            'alumni_brand_subtitle'   => 'nullable|string|max:200',
            'alumni_cta_text'         => 'nullable|string|max:100',
            'alumni_cta_url'          => 'nullable|string|max:500',
            'alumni_is_active'        => 'nullable|boolean',
            'nav_labels'              => 'nullable|array',
            'nav_labels.*'            => 'nullable|string|max:100',
            'nav_urls'                => 'nullable|array',
            'nav_urls.*'              => 'nullable|string|max:500',
        ]);

        foreach (['alumni_hero_title', 'alumni_hero_subtitle', 'alumni_hero_description', 'alumni_stats_title', 'alumni_flyer_title', 'alumni_brand_title', 'alumni_brand_subtitle', 'alumni_cta_text', 'alumni_cta_url'] as $key) {
            if ($request->has($key)) {
                Setting::set($key, $validated[$key] ?? '');
            }
        }

        Setting::set('alumni_is_active', $request->boolean('alumni_is_active') ? '1' : '0');

        if ($request->has('nav_labels') && is_array($request->nav_labels)) {
            $navLinks = [];
            foreach ($request->nav_labels as $i => $label) {
                $label = trim($label ?? '');
                $url = trim($request->nav_urls[$i] ?? '#');
                if ($label !== '') {
                    $navLinks[] = [
                        'label'  => $label,
                        'url'    => $url ?: '#',
                        'active' => strtolower($label) === 'alumni',
                    ];
                }
            }
            Setting::set('alumni_navbar_links', json_encode($navLinks));
        }

        return redirect()->route('admin.alumni.index', ['tab' => 'settings'])
            ->with('success', 'Pengaturan alumni berhasil disimpan!');
    }
}
