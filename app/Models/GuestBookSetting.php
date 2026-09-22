<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class GuestBookSetting extends Model
{
    use HasFactory;

    protected $table = 'guest_book_settings';

    protected $fillable = [
        'title',
        'subtitle',
        'greeting_title',
        'greeting_text',
        'banner_path',
        'logo_path',
        'footer_text',
        'enable_direct_form',
        'wa_notification_number',
    ];

    protected $casts = [
        'enable_direct_form' => 'boolean',
    ];

    /**
     * Get single instance of settings.
     */
    public static function getSettings()
    {
        return static::firstOrCreate([], [
            'title' => 'Portal Buku Tamu',
            'subtitle' => 'Ahlan wa Sahlan di Al Irsyad',
            'greeting_title' => "Assalamu'alaikum",
            'greeting_text' => 'Bismillah. Tafadhdhol, silakan pilih layanan yang Anda tuju atau isi buku tamu digital:',
            'footer_text' => '© 2026 Al Irsyad. Jazakumullahu khairan.',
            'enable_direct_form' => true,
        ]);
    }
}
