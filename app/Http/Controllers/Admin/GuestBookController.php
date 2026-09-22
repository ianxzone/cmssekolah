<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\GuestBookSetting;
use App\Models\GuestBookService;
use App\Models\GuestBookEntry;
use Illuminate\Support\Facades\Storage;
use Symfony\Component\HttpFoundation\StreamedResponse;
use App\Services\ImageService;

class GuestBookController extends Controller
{
    /**
     * Display the Guest Book admin management dashboard.
     */
    public function index(Request $request)
    {
        $settings = GuestBookSetting::getSettings();
        $services = GuestBookService::orderBy('sort_order', 'asc')->get();

        // Statistics
        $todayCount = GuestBookEntry::today()->count();
        $pendingCount = GuestBookEntry::where('status', 'pending')->count();
        $acceptedCount = GuestBookEntry::where('status', 'accepted')->count();
        $completedCount = GuestBookEntry::where('status', 'completed')->count();
        $totalClicks = GuestBookService::sum('clicks_count');

        // Entries Query
        $entriesQuery = GuestBookEntry::query();

        if ($request->filled('search')) {
            $search = $request->search;
            $entriesQuery->where(function ($q) use ($search) {
                $q->where('name', 'like', "%{$search}%")
                  ->orWhere('institution', 'like', "%{$search}%")
                  ->orWhere('phone', 'like', "%{$search}%")
                  ->orWhere('meet_with', 'like', "%{$search}%")
                  ->orWhere('purpose', 'like', "%{$search}%");
            });
        }

        if ($request->filled('status') && $request->status !== 'all') {
            $entriesQuery->where('status', $request->status);
        }

        if ($request->filled('category') && $request->category !== 'all') {
            $entriesQuery->where('category', $request->category);
        }

        if ($request->filled('date')) {
            $entriesQuery->whereDate('created_at', $request->date);
        }

        $entries = $entriesQuery->orderBy('created_at', 'desc')->paginate(15)->withQueryString();

        return view('admin.guestbook.index', compact(
            'settings',
            'services',
            'entries',
            'todayCount',
            'pendingCount',
            'acceptedCount',
            'completedCount',
            'totalClicks'
        ));
    }

    /**
     * Update Portal & Guestbook Settings.
     */
    public function updateSettings(Request $request)
    {
        $settings = GuestBookSetting::getSettings();

        $data = $request->validate([
            'title' => 'required|string|max:255',
            'subtitle' => 'nullable|string|max:255',
            'greeting_title' => 'required|string|max:255',
            'greeting_text' => 'nullable|string|max:1000',
            'footer_text' => 'nullable|string|max:255',
            'enable_direct_form' => 'nullable|boolean',
            'wa_notification_number' => 'nullable|string|max:30',
            'banner_image' => 'nullable|image|max:2048',
            'logo_image' => 'nullable|image|max:2048',
        ]);

        $data['enable_direct_form'] = $request->has('enable_direct_form');

        if ($request->hasFile('banner_image')) {
            if ($settings->banner_path && Storage::disk('public')->exists($settings->banner_path)) {
                Storage::disk('public')->delete($settings->banner_path);
            }
            $opt = ImageService::optimizeAndStore($request->file('banner_image'), 'guestbook', 'banner');
            $data['banner_path'] = $opt['path'];
        }

        if ($request->hasFile('logo_image')) {
            if ($settings->logo_path && Storage::disk('public')->exists($settings->logo_path)) {
                Storage::disk('public')->delete($settings->logo_path);
            }
            $opt = ImageService::optimizeAndStore($request->file('logo_image'), 'guestbook', 'logo');
            $data['logo_path'] = $opt['path'];
        }

        $settings->update($data);

        return redirect()->route('admin.guestbook.index', ['tab' => 'settings'])->with('success', 'Pengaturan Portal Buku Tamu berhasil diperbarui.');
    }

    /**
     * Store new portal service link.
     */
    public function storeService(Request $request)
    {
        $data = $request->validate([
            'title' => 'required|string|max:255',
            'subtitle' => 'nullable|string|max:255',
            'url' => 'nullable|string|max:1000',
            'icon' => 'nullable|string|max:100',
            'icon_color' => 'nullable|string|max:30',
            'icon_bg_color' => 'nullable|string|max:30',
            'sort_order' => 'nullable|integer',
            'is_active' => 'nullable|boolean',
        ]);

        $data['is_active'] = $request->has('is_active');
        $data['sort_order'] = $data['sort_order'] ?? (GuestBookService::max('sort_order') + 1);

        GuestBookService::create($data);

        return redirect()->route('admin.guestbook.index', ['tab' => 'services'])->with('success', 'Layanan Buku Tamu baru berhasil ditambahkan.');
    }

    /**
     * Update an existing portal service link.
     */
    public function updateService(Request $request, $id)
    {
        $service = GuestBookService::findOrFail($id);

        $data = $request->validate([
            'title' => 'required|string|max:255',
            'subtitle' => 'nullable|string|max:255',
            'url' => 'nullable|string|max:1000',
            'icon' => 'nullable|string|max:100',
            'icon_color' => 'nullable|string|max:30',
            'icon_bg_color' => 'nullable|string|max:30',
            'sort_order' => 'nullable|integer',
            'is_active' => 'nullable|boolean',
        ]);

        $data['is_active'] = $request->has('is_active');

        $service->update($data);

        return redirect()->route('admin.guestbook.index', ['tab' => 'services'])->with('success', 'Layanan berhasil diperbarui.');
    }

    /**
     * Delete a portal service.
     */
    public function destroyService($id)
    {
        $service = GuestBookService::findOrFail($id);
        $service->delete();

        return redirect()->route('admin.guestbook.index', ['tab' => 'services'])->with('success', 'Layanan berhasil dihapus.');
    }

    /**
     * Update status and notes of a visitor entry.
     */
    public function updateEntryStatus(Request $request, $id)
    {
        $entry = GuestBookEntry::findOrFail($id);

        $data = $request->validate([
            'status' => 'required|in:pending,accepted,completed',
            'admin_notes' => 'nullable|string|max:1000',
        ]);

        $entry->update($data);

        if ($request->ajax() || $request->wantsJson()) {
            return response()->json([
                'success' => true,
                'message' => 'Status kunjungan tamu berhasil diperbarui.',
                'status' => $entry->status,
                'status_badge' => $entry->status_badge,
            ]);
        }

        return redirect()->route('admin.guestbook.index', ['tab' => 'entries'])->with('success', 'Status kunjungan tamu berhasil diperbarui.');
    }

    /**
     * Delete visitor entry.
     */
    public function destroyEntry($id)
    {
        $entry = GuestBookEntry::findOrFail($id);
        $entry->delete();

        return redirect()->route('admin.guestbook.index', ['tab' => 'entries'])->with('success', 'Catatan kunjungan tamu berhasil dihapus.');
    }

    /**
     * Export visitor entries to CSV.
     */
    public function exportEntries(Request $request)
    {
        $entriesQuery = GuestBookEntry::query();

        if ($request->filled('search')) {
            $search = $request->search;
            $entriesQuery->where(function ($q) use ($search) {
                $q->where('name', 'like', "%{$search}%")
                  ->orWhere('institution', 'like', "%{$search}%")
                  ->orWhere('phone', 'like', "%{$search}%");
            });
        }

        if ($request->filled('status') && $request->status !== 'all') {
            $entriesQuery->where('status', $request->status);
        }

        if ($request->filled('date')) {
            $entriesQuery->whereDate('created_at', $request->date);
        }

        $entries = $entriesQuery->orderBy('created_at', 'desc')->get();

        $filename = 'buku_tamu_al_irsyad_' . date('Y_m_d_His') . '.csv';

        $headers = [
            'Content-Type' => 'text/csv; charset=UTF-8',
            'Content-Disposition' => "attachment; filename=\"{$filename}\"",
            'Pragma' => 'no-cache',
            'Cache-Control' => 'must-revalidate, post-check=0, pre-check=0',
            'Expires' => '0',
        ];

        $callback = function () use ($entries) {
            $handle = fopen('php://output', 'w');
            // Write UTF-8 BOM for Excel compatibility
            fprintf($handle, chr(0xEF) . chr(0xBB) . chr(0xBF));

            // Header row
            fputcsv($handle, [
                'No',
                'Tanggal & Waktu',
                'Nama Tamu',
                'Kategori Tamu',
                'Instansi / Hubungan',
                'Nomor WhatsApp/HP',
                'Email',
                'Bertemu Dengan',
                'Keperluan Kunjungan',
                'Status',
                'Catatan Petugas',
            ]);

            foreach ($entries as $index => $item) {
                fputcsv($handle, [
                    $index + 1,
                    $item->created_at ? $item->created_at->format('d/m/Y H:i:s') : '-',
                    $item->name,
                    $item->category,
                    $item->institution ?: '-',
                    $item->phone,
                    $item->email ?: '-',
                    $item->meet_with ?: '-',
                    $item->purpose,
                    match ($item->status) {
                        'accepted' => 'Diterima',
                        'completed' => 'Selesai',
                        default => 'Menunggu',
                    },
                    $item->admin_notes ?: '-',
                ]);
            }

            fclose($handle);
        };

        return new StreamedResponse($callback, 200, $headers);
    }
}
