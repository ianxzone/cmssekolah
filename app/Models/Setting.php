<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Setting extends Model
{
    protected $fillable = ['key', 'value', 'type'];

    public static function get($key, $default = null)
    {
        $setting = self::where('key', $key)->first();
        return $setting ? $setting->value : $default;
    }

    public static function set($key, $value, $type = 'text')
    {
        return self::updateOrCreate(
            ['key' => $key],
            ['value' => $value, 'type' => $type]
        );
    }

    /**
     * Resolve asset/storage/external URL for an image setting key
     */
    public static function urlFor(string $key, ?string $default = null): ?string
    {
        $val = trim(self::get($key, '') ?? '');
        if (empty($val)) {
            return $default;
        }

        if (\Illuminate\Support\Str::startsWith($val, ['http://', 'https://', '//'])) {
            return $val;
        }

        if (file_exists(public_path($val))) {
            return asset($val);
        }

        if (\Illuminate\Support\Facades\Storage::disk('public')->exists($val)) {
            return \Illuminate\Support\Facades\Storage::url($val);
        }

        return asset($val);
    }

    public static function logoUrl(): string
    {
        return self::urlFor('site_logo', asset('images/logo-al-irsyad.png'));
    }

    public static function faviconUrl(): string
    {
        return self::urlFor('site_favicon', asset('images/favicon.png'));
    }

    public static function siteName(): string
    {
        return self::get('site_name', 'LPP AL IRSYAD');
    }

    public static function siteTagline(): string
    {
        return self::get('site_tagline', 'LAJNAH PENDIDIKAN & PENGAJARAN');
    }

    public static function siteIconText(): string
    {
        return self::get('site_icon_text', 'LPP');
    }
}
