<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\BiolinkProfile;
use App\Models\BiolinkSection;
use App\Models\BiolinkLink;
use App\Services\ImageService;

class BiolinkController extends Controller
{
    /**
     * Display Biolink Management Dashboard.
     */
    public function index()
    {
        $profile = BiolinkProfile::firstOrCreate(
            ['slug' => 'default'],
            [
                'title' => 'Al Irsyad Al Islamiyyah',
                'subtitle' => 'Karawang Branch',
                'badge_text' => 'Islamic Tech Generation',
                'theme_bg_color' => '#022c19',
                'theme_primary_color' => '#006837',
                'theme_accent_color' => '#FBB03B',
            ]
        );

        $sections = BiolinkSection::where('profile_id', $profile->id)
            ->orderBy('sort_order', 'asc')
            ->with(['links' => function ($q) {
                $q->orderBy('sort_order', 'asc');
            }])
            ->get();

        $allLinks = $sections->flatMap->links;
        $totalClicks = $allLinks->sum('clicks_count');
        $totalLinks = $allLinks->count();
        $activeLinks = $allLinks->where('is_active', true)->count();
        $topLinks = $allLinks->sortByDesc('clicks_count')->take(5)->values();

        return view('admin.biolink.index', compact('profile', 'sections', 'totalClicks', 'totalLinks', 'activeLinks', 'topLinks'));
    }

    /**
     * Update Profile, Theme, Social Links & SEO.
     */
    public function updateProfile(Request $request)
    {
        $profile = BiolinkProfile::firstOrCreate(['slug' => 'default']);

        $data = $request->validate([
            'title' => 'required|string|max:255',
            'subtitle' => 'nullable|string|max:255',
            'badge_text' => 'nullable|string|max:100',
            'badge_icon' => 'nullable|string|max:100',
            'bio' => 'nullable|string|max:1000',
            'theme_bg_color' => 'nullable|string|max:30',
            'theme_primary_color' => 'nullable|string|max:30',
            'theme_accent_color' => 'nullable|string|max:30',
            'youtube_url' => 'nullable|string|max:500',
            'footer_text' => 'nullable|string|max:255',
            'footer_subtext' => 'nullable|string|max:255',
            'meta_title' => 'nullable|string|max:255',
            'meta_description' => 'nullable|string|max:1000',
            'meta_keywords' => 'nullable|string|max:500',
            'avatar' => 'nullable|image|max:2048',
            'banner' => 'nullable|image|max:2048',
            'og_image_file' => 'nullable|image|max:2048',
        ]);

        // Booleans
        $data['show_verified_badge'] = $request->has('show_verified_badge');
        $data['show_pattern'] = $request->has('show_pattern');
        $data['show_scanline'] = $request->has('show_scanline');
        $data['show_youtube'] = $request->has('show_youtube');
        $data['is_active'] = $request->has('is_active');

        // File uploads with optimization
        if ($request->hasFile('avatar')) {
            $avatarResult = ImageService::optimizeAndStore($request->file('avatar'), 'biolink', 'avatar');
            $data['avatar_path'] = $avatarResult['path'];
        }

        if ($request->hasFile('banner')) {
            $bannerResult = ImageService::optimizeAndStore($request->file('banner'), 'biolink', 'banner');
            $data['banner_path'] = $bannerResult['path'];
        }

        if ($request->hasFile('og_image_file')) {
            $ogResult = ImageService::optimizeAndStore($request->file('og_image_file'), 'biolink', 'og_image');
            $data['og_image'] = \Illuminate\Support\Facades\Storage::url($ogResult['path']);
        } elseif ($request->filled('og_image')) {
            $data['og_image'] = $request->input('og_image');
        }

        // Process social links
        if ($request->has('social_links') && is_array($request->input('social_links'))) {
            $socialLinks = [];
            foreach ($request->input('social_links') as $item) {
                if (!empty($item['url'])) {
                    $socialLinks[] = [
                        'platform' => $item['platform'] ?? 'Social',
                        'icon' => $item['icon'] ?? 'fa-solid fa-link',
                        'url' => $item['url'],
                        'color_hover' => $item['color_hover'] ?? 'hover:text-brand-green',
                        'is_active' => isset($item['is_active']) ? (bool)$item['is_active'] : true,
                    ];
                }
            }
            $data['social_links'] = $socialLinks;
        }

        $profile->update($data);

        $tab = $request->input('_tab', 'profile');
        return redirect()->route('admin.biolink.index', ['tab' => $tab])->with('success', 'Pengaturan Biolink berhasil diperbarui.');
    }

    /**
     * Store a new section.
     */
    public function storeSection(Request $request)
    {
        $data = $request->validate([
            'profile_id' => 'required|exists:biolink_profiles,id',
            'title' => 'required|string|max:255',
            'icon' => 'nullable|string|max:100',
            'layout_type' => 'required|in:list,grid_2',
            'sort_order' => 'nullable|integer',
        ]);

        $data['is_active'] = $request->has('is_active');
        $data['sort_order'] = $data['sort_order'] ?? 0;

        BiolinkSection::create($data);

        return redirect()->route('admin.biolink.index', ['tab' => 'links'])->with('success', 'Seksi baru berhasil ditambahkan.');
    }

    /**
     * Update an existing section.
     */
    public function updateSection(Request $request, $id)
    {
        $section = BiolinkSection::findOrFail($id);

        $data = $request->validate([
            'title' => 'required|string|max:255',
            'icon' => 'nullable|string|max:100',
            'layout_type' => 'required|in:list,grid_2',
            'sort_order' => 'nullable|integer',
        ]);

        $data['is_active'] = $request->has('is_active');
        $data['sort_order'] = $data['sort_order'] ?? 0;

        $section->update($data);

        return redirect()->route('admin.biolink.index', ['tab' => 'links'])->with('success', 'Seksi berhasil diperbarui.');
    }

    /**
     * Delete a section.
     */
    public function destroySection($id)
    {
        $section = BiolinkSection::findOrFail($id);
        $section->delete();

        return redirect()->route('admin.biolink.index', ['tab' => 'links'])->with('success', 'Seksi dan seluruh tautan di dalamnya berhasil dihapus.');
    }

    /**
     * Store a new link.
     */
    public function storeLink(Request $request)
    {
        $data = $request->validate([
            'section_id' => 'required|exists:biolink_sections,id',
            'title' => 'required|string|max:255',
            'subtitle' => 'nullable|string|max:255',
            'url' => 'required|url|max:1000',
            'icon' => 'nullable|string|max:100',
            'icon_color' => 'nullable|string|max:100',
            'icon_bg_color' => 'nullable|string|max:100',
            'badge_text' => 'nullable|string|max:50',
            'badge_color' => 'nullable|string|max:50',
            'style_type' => 'required|in:standard,highlighted',
            'sort_order' => 'nullable|integer',
        ]);

        $data['open_new_tab'] = $request->has('open_new_tab');
        $data['is_active'] = $request->has('is_active');
        $data['sort_order'] = $data['sort_order'] ?? 0;

        BiolinkLink::create($data);

        return redirect()->route('admin.biolink.index', ['tab' => 'links'])->with('success', 'Tautan berhasil ditambahkan.');
    }

    /**
     * Update an existing link.
     */
    public function updateLink(Request $request, $id)
    {
        $link = BiolinkLink::findOrFail($id);

        $data = $request->validate([
            'section_id' => 'required|exists:biolink_sections,id',
            'title' => 'required|string|max:255',
            'subtitle' => 'nullable|string|max:255',
            'url' => 'required|url|max:1000',
            'icon' => 'nullable|string|max:100',
            'icon_color' => 'nullable|string|max:100',
            'icon_bg_color' => 'nullable|string|max:100',
            'badge_text' => 'nullable|string|max:50',
            'badge_color' => 'nullable|string|max:50',
            'style_type' => 'required|in:standard,highlighted',
            'sort_order' => 'nullable|integer',
        ]);

        $data['open_new_tab'] = $request->has('open_new_tab');
        $data['is_active'] = $request->has('is_active');
        $data['sort_order'] = $data['sort_order'] ?? 0;

        $link->update($data);

        return redirect()->route('admin.biolink.index', ['tab' => 'links'])->with('success', 'Tautan berhasil diperbarui.');
    }

    /**
     * Delete a link.
     */
    public function destroyLink($id)
    {
        $link = BiolinkLink::findOrFail($id);
        $link->delete();

        return redirect()->route('admin.biolink.index', ['tab' => 'links'])->with('success', 'Tautan berhasil dihapus.');
    }
}
