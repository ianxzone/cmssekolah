<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Slider;
use App\Models\SliderItem;
use App\Services\ImageService;
use App\Services\SecurityService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class SliderController extends Controller
{
    /**
     * Tampilkan daftar tema slider
     */
    public function index(Request $request)
    {
        $sliders = Slider::withCount(['items', 'activeItems'])
            ->orderBy('is_active', 'desc')
            ->orderBy('updated_at', 'desc')
            ->get();

        return view('admin.sliders.index', compact('sliders'));
    }

    /**
     * Simpan tema slider baru
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'name'        => 'required|string|max:150',
            'slug'        => 'nullable|string|max:150|unique:sliders,slug',
            'description' => 'nullable|string|max:1000',
            'delay'       => 'nullable|integer|min:1000|max:30000',
            'auto_play'   => 'nullable|boolean',
            'is_active'   => 'nullable|boolean',
        ]);

        if (empty($validated['slug'])) {
            $validated['slug'] = Str::slug($validated['name']);
            // Ensure unique slug
            $originalSlug = $validated['slug'];
            $count = 1;
            while (Slider::where('slug', $validated['slug'])->exists()) {
                $validated['slug'] = $originalSlug . '-' . $count++;
            }
        } else {
            $validated['slug'] = Str::slug($validated['slug']);
        }

        $validated['auto_play'] = $request->boolean('auto_play', true);
        $validated['is_active'] = $request->boolean('is_active');
        $validated['delay']     = $request->filled('delay') ? (int) $request->input('delay') : 6000;

        // Jika diset aktif, nonaktifkan slider lain
        if ($validated['is_active']) {
            Slider::where('is_active', true)->update(['is_active' => false]);
        }

        // Jika ini slider pertama, jadikan aktif secara otomatis
        if (Slider::count() === 0) {
            $validated['is_active'] = true;
        }

        $slider = Slider::create($validated);

        if (class_exists(SecurityService::class)) {
            SecurityService::logAudit('created', 'sliders', "Membuat tema slider baru: {$slider->name}", (string) $slider->id, null, $slider->toArray());
        }

        return redirect()->route('admin.sliders.items', $slider->id)
            ->with('success', "Tema slider '{$slider->name}' berhasil dibuat! Silakan kelola slide di dalamnya.");
    }

    /**
     * Perbarui info tema slider
     */
    public function update(Request $request, $id)
    {
        $slider = Slider::findOrFail($id);

        $validated = $request->validate([
            'name'        => 'required|string|max:150',
            'slug'        => 'required|string|max:150|unique:sliders,slug,' . $id,
            'description' => 'nullable|string|max:1000',
            'delay'       => 'nullable|integer|min:1000|max:30000',
            'auto_play'   => 'nullable|boolean',
            'is_active'   => 'nullable|boolean',
        ]);

        $validated['slug']      = Str::slug($validated['slug']);
        $validated['auto_play'] = $request->boolean('auto_play', true);
        $validated['is_active'] = $request->boolean('is_active');
        $validated['delay']     = $request->filled('delay') ? (int) $request->input('delay') : 6000;

        // Jika diset aktif, nonaktifkan tema slider lain
        if ($validated['is_active']) {
            Slider::where('id', '!=', $slider->id)->update(['is_active' => false]);
        }

        $oldData = $slider->toArray();
        $slider->update($validated);

        if (class_exists(SecurityService::class)) {
            SecurityService::logAudit('updated', 'sliders', "Memperbarui tema slider: {$slider->name}", (string) $slider->id, $oldData, $slider->fresh()->toArray());
        }

        return redirect()->route('admin.sliders.index')
            ->with('success', "Pengaturan slider '{$slider->name}' berhasil diperbarui.");
    }

    /**
     * Hapus tema slider
     */
    public function destroy($id)
    {
        $slider = Slider::with('items')->findOrFail($id);
        $name = $slider->name;

        // Hapus file gambar item jika tersimpan lokal di disk public
        foreach ($slider->items as $item) {
            if ($item->image && !Str::startsWith($item->image, ['http://', 'https://', 'images/'])) {
                Storage::disk('public')->delete($item->image);
            }
            if ($item->side_image && !Str::startsWith($item->side_image, ['http://', 'https://', 'images/'])) {
                Storage::disk('public')->delete($item->side_image);
            }
        }

        $wasActive = $slider->is_active;
        $slider->delete();

        // Jika slider yang dihapus adalah yang aktif, aktifkan slider lain yang tersedia
        if ($wasActive) {
            $other = Slider::first();
            if ($other) {
                $other->update(['is_active' => true]);
            }
        }

        if (class_exists(SecurityService::class)) {
            SecurityService::logAudit('deleted', 'sliders', "Menghapus tema slider: {$name}", (string) $id, null, null);
        }

        return redirect()->route('admin.sliders.index')
            ->with('success', "Tema slider '{$name}' dan seluruh slide di dalamnya berhasil dihapus.");
    }

    /**
     * Jadikan slider ini sebagai tema aktif di Beranda
     */
    public function setActive($id)
    {
        $slider = Slider::findOrFail($id);

        Slider::where('id', '!=', $slider->id)->update(['is_active' => false]);
        $slider->update(['is_active' => true]);

        if (class_exists(SecurityService::class)) {
            SecurityService::logAudit('updated', 'sliders', "Mengaktifkan tema slider '{$slider->name}' untuk Beranda", (string) $slider->id, null, ['is_active' => true]);
        }

        return redirect()->back()
            ->with('success', "Tema slider '{$slider->name}' kini aktif dan tampil di Beranda utama!");
    }

    /**
     * Halaman kelola slide di dalam satu tema slider (ala Revolution Slider)
     */
    public function items($id)
    {
        $slider = Slider::with(['items' => function ($q) {
            $q->orderBy('sort_order', 'asc');
        }])->findOrFail($id);

        return view('admin.sliders.items', compact('slider'));
    }

    /**
     * Simpan slide item baru ke dalam slider tema ini
     */
    public function storeItem(Request $request, $id)
    {
        $slider = Slider::findOrFail($id);

        $validated = $request->validate([
            'title'            => 'nullable|string|max:255',
            'subtitle'         => 'nullable|string|max:1000',
            'badge'            => 'nullable|string|max:150',
            'image_file'       => 'nullable|image|max:5120',
            'image_url'        => 'nullable|string|max:500',
            'side_image_file'  => 'nullable|image|max:5120',
            'side_image_url'   => 'nullable|string|max:500',
            'btn_text'         => 'nullable|string|max:100',
            'btn_link'         => 'nullable|string|max:500',
            'btn2_text'        => 'nullable|string|max:100',
            'btn2_link'        => 'nullable|string|max:500',
            'pills_raw'        => 'nullable|string|max:500',
            'sort_order'       => 'nullable|integer',
            'is_active'        => 'nullable|boolean',
        ]);

        // Handle Background Image
        $imagePath = null;
        if ($request->hasFile('image_file')) {
            $uploaded = ImageService::optimizeAndStore($request->file('image_file'), 'sliders', 'slide_' . time());
            $imagePath = $uploaded['path'];
        } elseif ($request->filled('image_url')) {
            $imagePath = trim($request->input('image_url'));
        }

        // Handle Side Image
        $sideImagePath = null;
        if ($request->hasFile('side_image_file')) {
            $uploaded = ImageService::optimizeAndStore($request->file('side_image_file'), 'sliders', 'side_' . time());
            $sideImagePath = $uploaded['path'];
        } elseif ($request->filled('side_image_url')) {
            $sideImagePath = trim($request->input('side_image_url'));
        }

        // Process Pills (separated by comma or newline)
        $pills = [];
        if (!empty($validated['pills_raw'])) {
            $rawList = preg_split('/[\r\n,]+/', $validated['pills_raw']);
            foreach ($rawList as $item) {
                $trimmed = trim($item);
                if (!empty($trimmed)) {
                    $pills[] = $trimmed;
                }
            }
        }

        $sortOrder = $request->filled('sort_order')
            ? (int) $request->input('sort_order')
            : ($slider->items()->max('sort_order') ?? 0) + 1;

        $slide = $slider->items()->create([
            'title'      => $validated['title'] ?? '',
            'subtitle'   => $validated['subtitle'] ?? null,
            'badge'      => $validated['badge'] ?? null,
            'image'      => $imagePath,
            'side_image' => $sideImagePath,
            'btn_text'   => $validated['btn_text'] ?? null,
            'btn_link'   => $validated['btn_link'] ?? null,
            'btn2_text'  => $validated['btn2_text'] ?? null,
            'btn2_link'  => $validated['btn2_link'] ?? null,
            'pills'      => !empty($pills) ? $pills : null,
            'sort_order' => $sortOrder,
            'is_active'  => $request->boolean('is_active', true),
        ]);

        if (class_exists(SecurityService::class)) {
            SecurityService::logAudit('created', 'sliders', "Menambahkan slide baru ke tema: {$slider->name}", (string) $slide->id, null, $slide->toArray());
        }

        return redirect()->route('admin.sliders.items', $slider->id)
            ->with('success', 'Slide baru berhasil ditambahkan ke tema ini!');
    }

    /**
     * Perbarui slide item
     */
    public function updateItem(Request $request, $id, $itemId)
    {
        $slider = Slider::findOrFail($id);
        $slide = $slider->items()->findOrFail($itemId);

        $validated = $request->validate([
            'title'            => 'nullable|string|max:255',
            'subtitle'         => 'nullable|string|max:1000',
            'badge'            => 'nullable|string|max:150',
            'image_file'       => 'nullable|image|max:5120',
            'image_url'        => 'nullable|string|max:500',
            'side_image_file'  => 'nullable|image|max:5120',
            'side_image_url'   => 'nullable|string|max:500',
            'btn_text'         => 'nullable|string|max:100',
            'btn_link'         => 'nullable|string|max:500',
            'btn2_text'        => 'nullable|string|max:100',
            'btn2_link'        => 'nullable|string|max:500',
            'pills_raw'        => 'nullable|string|max:500',
            'sort_order'       => 'nullable|integer',
            'is_active'        => 'nullable|boolean',
        ]);

        // Background Image
        $imagePath = $slide->image;
        if ($request->hasFile('image_file')) {
            if ($slide->image && !Str::startsWith($slide->image, ['http://', 'https://', 'images/'])) {
                Storage::disk('public')->delete($slide->image);
            }
            $uploaded = ImageService::optimizeAndStore($request->file('image_file'), 'sliders', 'slide_' . time());
            $imagePath = $uploaded['path'];
        } elseif ($request->filled('image_url')) {
            $imagePath = trim($request->input('image_url'));
        }

        // Side Image
        $sideImagePath = $slide->side_image;
        if ($request->hasFile('side_image_file')) {
            if ($slide->side_image && !Str::startsWith($slide->side_image, ['http://', 'https://', 'images/'])) {
                Storage::disk('public')->delete($slide->side_image);
            }
            $uploaded = ImageService::optimizeAndStore($request->file('side_image_file'), 'sliders', 'side_' . time());
            $sideImagePath = $uploaded['path'];
        } elseif ($request->filled('side_image_url')) {
            $sideImagePath = trim($request->input('side_image_url'));
        }

        // Pills
        $pills = [];
        if (!empty($validated['pills_raw'])) {
            $rawList = preg_split('/[\r\n,]+/', $validated['pills_raw']);
            foreach ($rawList as $item) {
                $trimmed = trim($item);
                if (!empty($trimmed)) {
                    $pills[] = $trimmed;
                }
            }
        }

        $sortOrder = $request->filled('sort_order') ? (int) $request->input('sort_order') : $slide->sort_order;

        $slide->update([
            'title'      => $validated['title'] ?? '',
            'subtitle'   => $validated['subtitle'] ?? null,
            'badge'      => $validated['badge'] ?? null,
            'image'      => $imagePath,
            'side_image' => $sideImagePath,
            'btn_text'   => $validated['btn_text'] ?? null,
            'btn_link'   => $validated['btn_link'] ?? null,
            'btn2_text'  => $validated['btn2_text'] ?? null,
            'btn2_link'  => $validated['btn2_link'] ?? null,
            'pills'      => !empty($pills) ? $pills : null,
            'sort_order' => $sortOrder,
            'is_active'  => $request->boolean('is_active', true),
        ]);

        return redirect()->route('admin.sliders.items', $slider->id)
            ->with('success', 'Slide berhasil diperbarui!');
    }

    /**
     * Hapus satu slide
     */
    public function destroyItem($id, $itemId)
    {
        $slider = Slider::findOrFail($id);
        $slide = $slider->items()->findOrFail($itemId);

        if ($slide->image && !Str::startsWith($slide->image, ['http://', 'https://', 'images/'])) {
            Storage::disk('public')->delete($slide->image);
        }
        if ($slide->side_image && !Str::startsWith($slide->side_image, ['http://', 'https://', 'images/'])) {
            Storage::disk('public')->delete($slide->side_image);
        }

        $slide->delete();

        return redirect()->route('admin.sliders.items', $slider->id)
            ->with('success', 'Slide berhasil dihapus.');
    }

    /**
     * Toggle status aktif satu slide
     */
    public function toggleItem($id, $itemId)
    {
        $slider = Slider::findOrFail($id);
        $slide = $slider->items()->findOrFail($itemId);

        $slide->update(['is_active' => !$slide->is_active]);

        $statusStr = $slide->is_active ? 'diaktifkan' : 'dinonaktifkan';
        return redirect()->route('admin.sliders.items', $slider->id)
            ->with('success', "Slide berhasil {$statusStr}.");
    }

    /**
     * Muat slide rekomendasi/preset ke dalam tema slider ini
     */
    public function loadPresets($id)
    {
        $slider = Slider::findOrFail($id);

        $presets = [
            [
                'title'      => "Pendidikan Islam Terpadu & Rabbani\nLPP Al Irsyad Al Islamiyyah",
                'subtitle'   => 'Membina generasi Rabbani dari usia emas anak (Daycare sejak lahir, Playgroup & TK Montessori) hingga SDIT, SMPIT, dan SMAIT berpadu akidah tauhid dan adab nabawiyah.',
                'badge'      => 'SPMB TA 2025/2026 - LPP Al Irsyad Karawang',
                'image'      => 'https://images.unsplash.com/photo-1580582932707-520aed937b7b?auto=format&fit=crop&q=80&w=1920',
                'side_image' => 'images/hero-students.png',
                'btn_text'   => 'Daftar SPMB Online',
                'btn_link'   => '#contact',
                'pills'      => ['Akreditasi A Unggul', 'Tahfidz Bersanad', 'Kelas Internasional ICP'],
                'sort_order' => 1,
                'is_active'  => true,
            ],
            [
                'title'      => 'Kurikulum Internasional Pearson (UK)',
                'subtitle'   => 'International Class Program (ICP) berstandar global Pearson Edexcel UK, memadukan sains internasional dengan adab tauhid Rabbani.',
                'badge'      => 'OFFICIAL PEARSON EDEXCEL PARTNER',
                'image'      => 'https://images.unsplash.com/photo-1524178232363-1fb2b075b655?auto=format&fit=crop&q=80&w=1920',
                'side_image' => null,
                'btn_text'   => 'Pelajari Pearson ICP',
                'btn_link'   => '/pearson-icp',
                'pills'      => ['Pearson Edexcel UK', 'Active English Immersion', 'Global Qualifications'],
                'sort_order' => 2,
                'is_active'  => true,
            ],
            [
                'title'      => 'Integrasi Nilai Qur\'ani, Sains & Adab Nabawiyah',
                'subtitle'   => 'Memadukan Kurikulum Merdeka Nasional dengan bimbingan tahfidz bersanad, pembiasaan adab harian, dan bilingual habit aktif.',
                'badge'      => 'KURIKULUM KHAS TERPADU AL IRSYAD',
                'image'      => 'https://images.unsplash.com/photo-1503676260728-1c00da094a0b?auto=format&fit=crop&q=80&w=1920',
                'side_image' => null,
                'btn_text'   => 'Pelajari Kurikulum Khas',
                'btn_link'   => '/kurikulum-khas',
                'pills'      => ['Tahfidz Bersanad', 'Bina Pribadi Islami', 'STEAM & Coding'],
                'sort_order' => 3,
                'is_active'  => true,
            ],
            [
                'title'      => 'Fasilitas Lengkap & Lingkungan Belajar Representatif',
                'subtitle'   => 'Menghadirkan lingkungan belajar yang aman, nyaman, dan berteknologi tinggi untuk memaksimalkan potensi nalar dan ibadah santri.',
                'badge'      => 'SARANA & PRASARANA MODERN',
                'image'      => 'https://images.unsplash.com/photo-1562774053-701939374585?auto=format&fit=crop&q=80&w=1920',
                'side_image' => null,
                'btn_text'   => 'Lihat Seluruh Fasilitas',
                'btn_link'   => '/fasilitas',
                'pills'      => ['Smart Classroom AC', 'Lab Sains & Komputer', 'Masjid Luas & Representatif'],
                'sort_order' => 4,
                'is_active'  => true,
            ],
            [
                'title'      => 'Pilihan Utama Tokoh, Pejabat & Profesional Karawang',
                'subtitle'   => 'Amanah kehormatan dipercaya oleh kalangan pejabat pemda, dokter spesialis, akademisi, dan profesional industri di Karawang.',
                'badge'      => 'KEPERCAYAAN STAKEHOLDER KARAWANG',
                'image'      => 'https://images.unsplash.com/photo-1524178232363-1fb2b075b655?auto=format&fit=crop&q=80&w=1920',
                'side_image' => null,
                'btn_text'   => 'Lihat Testimoni Tokoh',
                'btn_link'   => '#testimonials',
                'pills'      => ['Pejabat Pemda & ASN', 'Dokter & Tenaga Medis', 'Profesional Industri & BUMN'],
                'sort_order' => 5,
                'is_active'  => true,
            ],
        ];

        $currentMax = $slider->items()->max('sort_order') ?? 0;
        foreach ($presets as $preset) {
            $currentMax++;
            $preset['sort_order'] = $currentMax;
            $slider->items()->create($preset);
        }

        if (class_exists(SecurityService::class)) {
            SecurityService::logAudit('created', 'sliders', "Memuat template slide rekomendasi ke tema: {$slider->name}", (string) $slider->id, null, null);
        }

        return redirect()->route('admin.sliders.items', $slider->id)
            ->with('success', 'Preset template slide rekomendasi Al Irsyad berhasil dimuat ke dalam tema ini!');
    }
}
