<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\GuestBookSetting;
use App\Models\GuestBookService;
use App\Models\GuestBookEntry;

class GuestBookController extends Controller
{
    /**
     * Display the public Buku Tamu Portal page.
     */
    public function index()
    {
        $settings = GuestBookSetting::getSettings();
        $services = GuestBookService::active()->get();

        return view('guestbook.index', compact('settings', 'services'));
    }

    /**
     * Track click on a service and redirect to its target URL.
     */
    public function click($id)
    {
        $service = GuestBookService::findOrFail($id);
        $service->increment('clicks_count');

        if (!empty($service->url)) {
            return redirect()->away($service->url);
        }

        return redirect()->route('guestbook.index');
    }

    /**
     * Store visitor check-in entry.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'category' => 'required|string|max:100',
            'institution' => 'nullable|string|max:255',
            'phone' => 'required|string|max:30',
            'email' => 'nullable|email|max:255',
            'meet_with' => 'nullable|string|max:255',
            'purpose' => 'required|string|max:1000',
            'signature' => 'nullable|string',
        ]);

        $validated['status'] = 'pending';
        $validated['check_in_at'] = now();

        $entry = GuestBookEntry::create($validated);

        $settings = GuestBookSetting::getSettings();
        $waUrl = null;
        if (!empty($settings->wa_notification_number)) {
            $phoneClean = preg_replace('/[^0-9]/', '', $settings->wa_notification_number);
            if (str_starts_with($phoneClean, '0')) {
                $phoneClean = '62' . substr($phoneClean, 1);
            }
            $msg = urlencode("Halo Petugas Al Irsyad, ada tamu baru telah mengisi Buku Tamu Digital:\n"
                . "Nama: {$entry->name}\n"
                . "Instansi: " . ($entry->institution ?: '-') . "\n"
                . "Kategori: {$entry->category}\n"
                . "Bertemu: " . ($entry->meet_with ?: '-') . "\n"
                . "Keperluan: {$entry->purpose}\n"
                . "Waktu: " . $entry->created_at->format('d/m/Y H:i'));
            $waUrl = "https://api.whatsapp.com/send?phone={$phoneClean}&text={$msg}";
        }

        if ($request->ajax() || $request->wantsJson()) {
            return response()->json([
                'success' => true,
                'message' => 'Alhamdulillah, data kunjungan Anda berhasil dicatat. Terima kasih telah berkunjung ke SDIT Al Irsyad.',
                'entry_id' => $entry->id,
                'wa_url' => $waUrl,
            ]);
        }

        return redirect()->route('guestbook.index')->with('success', 'Alhamdulillah, data kunjungan Anda berhasil dicatat. Terima kasih telah berkunjung ke SDIT Al Irsyad.');
    }
}
