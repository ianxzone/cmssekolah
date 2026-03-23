<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Auth;

class Setting extends Model
{
    protected $fillable = ['key', 'value', 'type'];
    
    /**
     * Whitelist of allowed setting keys
     * This prevents SQL injection through arbitrary key names
     */
    protected static $allowedKeys = [
        // General Settings
        'school_name',
        'school_tagline',
        'school_logo',
        'school_favicon',
        
        // Theme Settings
        'theme_color_primary',
        'theme_color_secondary',
        'theme_active',
        
        // Home Page Settings
        'home_show_headmaster',
        'home_show_stats',
        'home_show_news',
        'home_show_events',
        'home_show_facilities',
        'home_show_testimonials',
        'home_headmaster_image',
        'home_headmaster_name',
        'home_headmaster_message',
        
        // Content Arrays (JSON)
        'navbar_links',
        'hero_slider_images',
        'stats_data',
        'superior_programs',
        'teachers_data',
        'facilities_list',
        'extracurriculars_list',
        'school_missions',
        
        // Contact & Social Media
        'contact_address',
        'contact_phone',
        'contact_email',
        'contact_ppdb_link',
        'social_facebook',
        'social_instagram',
        'social_youtube',
        'social_twitter',
        
        // Permalink Settings
        'permalink_structure',
        'permalink_event_structure',
        'permalink_category_base',
        'permalink_tag_base',
        
        // WhatsApp Integration
        'whatsapp_show',
        'whatsapp_number',
        'whatsapp_message',
        'whatsapp_btn_text',
        'whatsapp_icon',
        
        // Custom Scripts (Use with caution)
        'custom_header_scripts',
        'custom_footer_scripts',
        
        // Onboarding
        'onboarding_completed',
    ];
    
    /**
     * Get a setting value safely
     * 
     * @param string $key The setting key
     * @param mixed $default Default value if not found
     * @return mixed
     */
    public static function get($key, $default = null)
    {
        // Validate key against whitelist
        if (!self::isValidKey($key)) {
            // Log attempt for security monitoring
            Log::warning('Attempted to access invalid setting key: ' . $key, [
                'ip' => request()->ip(),
                'user_agent' => request()->userAgent(),
                'user_id' => Auth::id()
            ]);
            
            return $default;
        }
        
        // Sanitize key (only allow alphanumeric and underscore)
        $sanitizedKey = preg_replace('/[^a-z0-9_]/i', '', $key);
        
        $setting = self::where('key', $sanitizedKey)->first();
        return $setting ? $setting->value : $default;
    }
    
    /**
     * Set a setting value safely
     * 
     * @param string $key The setting key
     * @param mixed $value The value to set
     * @param string $type The type (text, json, boolean, image)
     * @return Setting
     */
    public static function set($key, $value, $type = 'text')
    {
        // Validate key against whitelist
        if (!self::isValidKey($key)) {
            throw new \InvalidArgumentException(
                "Invalid setting key: {$key}. Only predefined keys are allowed."
            );
        }
        
        // Sanitize key
        $sanitizedKey = preg_replace('/[^a-z0-9_]/i', '', $key);
        
        // Validate and sanitize value based on type
        $sanitizedValue = self::sanitizeValue($value, $type);
        
        return self::updateOrCreate(
            ['key' => $sanitizedKey],
            [
                'value' => $sanitizedValue,
                'type' => $type
            ]
        );
    }
    
    /**
     * Check if a key is in the allowed list
     */
    protected static function isValidKey($key): bool
    {
        return in_array($key, self::$allowedKeys);
    }
    
    /**
     * Sanitize value based on type
     */
    protected static function sanitizeValue($value, $type)
    {
        switch ($type) {
            case 'boolean':
                return filter_var($value, FILTER_VALIDATE_BOOLEAN) ? '1' : '0';
                
            case 'json':
                if (is_array($value)) {
                    return json_encode($value);
                }
                // Validate JSON string
                json_decode($value);
                if (json_last_error() === JSON_ERROR_NONE) {
                    return $value;
                }
                throw new \InvalidArgumentException('Invalid JSON format');
                
            case 'image':
                // Image paths should be relative URLs
                return filter_var($value, FILTER_SANITIZE_URL);
                
            case 'text':
            default:
                // Strip tags and sanitize string
                return strip_tags(trim($value));
        }
    }
    
    /**
     * Get all settings as key-value pairs
     */
    public static function getAll(): array
    {
        return self::pluck('value', 'key')->toArray();
    }
    
    /**
     * Get multiple settings by keys
     */
    public static function getMultiple(array $keys): array
    {
        // Filter only valid keys
        $validKeys = array_filter($keys, [self::class, 'isValidKey']);
        
        return self::whereIn('key', $validKeys)
            ->pluck('value', 'key')
            ->toArray();
    }
}
