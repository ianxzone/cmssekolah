<?php

namespace App\Services;

use App\Models\Setting;
use Illuminate\Support\Facades\Log;
use Illuminate\Http\UploadedFile;
use Exception;

/**
 * Service to import Rank Math SEO settings from a JSON export file.
 *
 * Supports the standard rank-math-settings.json export format with
 * top-level keys: general, titles, sitemap, modules.
 */
class RankMathImportService
{
    /**
     * Map of Rank Math keys (dot notation) to CMS settings.
     * Each entry: 'rm.key.path' => ['key' => 'cms_key', 'type' => 'text|boolean|json', 'label' => 'Human label']
     */
    protected array $mapping = [
        // Titles & Meta
        'titles.title_separator'        => ['key' => 'seo_title_separator',        'type' => 'text',    'label' => 'Title Separator'],
        'titles.open_graph_image'       => ['key' => 'seo_default_og_image_url',   'type' => 'text',    'label' => 'Default Open Graph Image'],
        'titles.homepage_title'         => ['key' => 'seo_homepage_title',         'type' => 'text',    'label' => 'Homepage Title'],
        'titles.homepage_description'   => ['key' => 'seo_default_description',    'type' => 'text',    'label' => 'Default Meta Description'],
        'titles.robots_global'          => ['key' => 'seo_robots_global',          'type' => 'json',    'label' => 'Global Robots Meta'],
        'titles.advanced_robots_global' => ['key' => 'seo_advanced_robots_global', 'type' => 'json',    'label' => 'Advanced Robots Meta'],

        // Knowledge Graph / Branding
        'titles.knowledgegraph_name'    => ['key' => 'site_name',                  'type' => 'text',    'label' => 'Nama Situs (Knowledge Graph)'],
        'titles.knowledgegraph_logo'    => ['key' => 'site_logo',                  'type' => 'text',    'label' => 'Logo Situs (Knowledge Graph)'],

        // General Settings
        'general.google_verify'              => ['key' => 'seo_google_site_verification',  'type' => 'text',    'label' => 'Google Site Verification'],
        'general.bing_verify'                => ['key' => 'seo_bing_site_verification',    'type' => 'text',    'label' => 'Bing Site Verification'],
        'general.nofollow_external_links'    => ['key' => 'seo_nofollow_external_links',   'type' => 'boolean', 'label' => 'Nofollow Link Eksternal'],
        'general.new_window_external_links'  => ['key' => 'seo_new_window_external_links', 'type' => 'boolean', 'label' => 'Buka Link Eksternal di Tab Baru'],

        // Breadcrumbs
        'general.breadcrumbs'           => ['key' => 'seo_breadcrumbs_enabled',    'type' => 'boolean', 'label' => 'Breadcrumbs (Aktif/Nonaktif)'],
        'general.breadcrumbs_separator' => ['key' => 'seo_breadcrumbs_separator',  'type' => 'text',    'label' => 'Breadcrumbs Separator'],
    ];

    /**
     * Parse the uploaded JSON file and return decoded data.
     *
     * @param string|UploadedFile $file
     * @return array
     * @throws Exception
     */
    public function parseFile($file): array
    {
        $path = $file instanceof UploadedFile ? $file->getRealPath() : $file;

        if (!file_exists($path)) {
            throw new Exception("File tidak ditemukan: {$path}");
        }

        $content = file_get_contents($path);
        $data = json_decode($content, true);

        if (json_last_error() !== JSON_ERROR_NONE) {
            throw new Exception("Format JSON tidak valid: " . json_last_error_msg());
        }

        if (empty($data)) {
            throw new Exception("File JSON kosong.");
        }

        return $data;
    }

    /**
     * Preview the changes that would be made during import.
     * Returns data formatted for the preview Blade view.
     *
     * @param array $data Parsed Rank Math JSON data
     * @return array ['settings_count' => int, 'items' => [...], 'summary' => [...]]
     */
    public function preview(array $data): array
    {
        return $this->process($data, save: false);
    }

    /**
     * Perform the actual import, saving settings to the database.
     *
     * @param array $data Parsed Rank Math JSON data
     * @return array ['summary' => [...], 'details' => [...]]
     */
    public function import(array $data): array
    {
        return $this->process($data, save: true);
    }

    /**
     * Core processing method used by both preview() and import().
     *
     * @param array $data  Parsed Rank Math data
     * @param bool  $save  Whether to actually save settings
     * @return array
     */
    protected function process(array $data, bool $save = false): array
    {
        $items = [];    // For preview table
        $details = [];  // For result log table
        $imported = 0;
        $skipped = 0;
        $failed = 0;

        // 1) Process standard mapping entries
        foreach ($this->mapping as $rmPath => $config) {
            $value = $this->getNestedValue($data, $rmPath);

            // Skip empty/null values
            if ($value === null || $value === '') {
                $skipped++;
                $details[] = [
                    'label'   => $config['label'],
                    'key'     => $config['key'],
                    'status'  => 'skipped',
                    'message' => 'Tidak ditemukan di file Rank Math',
                ];
                continue;
            }

            try {
                $formattedValue = $this->formatValue($value, $config['type']);
                $currentValue = Setting::get($config['key']);

                // Build preview item
                $items[] = [
                    'label'         => $config['label'],
                    'rank_math_key' => $rmPath,
                    'cms_key'       => $config['key'],
                    'value'         => $value,
                    'current_value' => $currentValue,
                ];

                if ($save) {
                    Setting::set($config['key'], $formattedValue, $config['type']);
                }

                $imported++;
                $details[] = [
                    'label'   => $config['label'],
                    'key'     => $config['key'],
                    'status'  => $currentValue !== null ? 'updated' : 'imported',
                    'message' => $currentValue !== null
                        ? "Diperbarui: \"{$currentValue}\" → \"{$formattedValue}\""
                        : "Nilai baru: \"{$formattedValue}\"",
                ];
            } catch (Exception $e) {
                $failed++;
                $details[] = [
                    'label'   => $config['label'],
                    'key'     => $config['key'],
                    'status'  => 'failed',
                    'message' => $e->getMessage(),
                ];
                Log::error("RankMath Import Error [{$rmPath}]: " . $e->getMessage());
            }
        }

        // 2) Process title template (special handling for variable conversion)
        $this->processTemplates($data, $items, $details, $imported, $skipped, $failed, $save);

        return [
            'settings_count' => count($items),
            'items'          => $items,
            'details'        => $details,
            'summary'        => [
                'total_processed' => $imported + $skipped + $failed,
                'imported'        => $imported,
                'skipped'         => $skipped,
                'failed'          => $failed,
            ],
        ];
    }

    /**
     * Process special template settings like pt_post_title that need variable conversion.
     */
    protected function processTemplates(
        array $data,
        array &$items,
        array &$details,
        int &$imported,
        int &$skipped,
        int &$failed,
        bool $save
    ): void {
        $rmPath = 'titles.pt_post_title';
        $label = 'Default Title Format (Post)';
        $cmsKey = 'seo_default_title_format';
        $value = $this->getNestedValue($data, $rmPath);

        if ($value === null || $value === '') {
            $skipped++;
            $details[] = [
                'label'   => $label,
                'key'     => $cmsKey,
                'status'  => 'skipped',
                'message' => 'Tidak ditemukan di file Rank Math',
            ];
            return;
        }

        try {
            $separator = $this->getNestedValue($data, 'titles.title_separator') ?? '-';
            $siteName = $this->getNestedValue($data, 'titles.knowledgegraph_name')
                ?? Setting::get('site_name', config('app.name', ''));

            // Convert: keep %title%, replace %sep% and %sitename%
            $formattedValue = str_replace(
                ['%sep%', '%sitename%', '%sitedesc%'],
                [$separator, $siteName, Setting::get('site_tagline', '')],
                $value
            );

            $currentValue = Setting::get($cmsKey);

            $items[] = [
                'label'         => $label,
                'rank_math_key' => $rmPath,
                'cms_key'       => $cmsKey,
                'value'         => $value,
                'current_value' => $currentValue,
            ];

            if ($save) {
                Setting::set($cmsKey, $formattedValue, 'text');
            }

            $imported++;
            $details[] = [
                'label'   => $label,
                'key'     => $cmsKey,
                'status'  => $currentValue !== null ? 'updated' : 'imported',
                'message' => "Template: \"{$value}\" → \"{$formattedValue}\"",
            ];
        } catch (Exception $e) {
            $failed++;
            $details[] = [
                'label'   => $label,
                'key'     => $cmsKey,
                'status'  => 'failed',
                'message' => $e->getMessage(),
            ];
        }
    }

    /**
     * Format a value based on its target type.
     */
    protected function formatValue(mixed $value, string $type): string
    {
        return match ($type) {
            'boolean' => in_array($value, ['on', '1', 1, true, 'true', 'yes'], true) ? '1' : '0',
            'json'    => is_array($value) ? json_encode($value) : (string) $value,
            default   => (string) $value,
        };
    }

    /**
     * Get a value from a nested array using dot notation.
     * Also supports flat keys for backward compatibility.
     */
    protected function getNestedValue(array $array, string $key, mixed $default = null): mixed
    {
        // Try flat key first
        if (array_key_exists($key, $array)) {
            return $array[$key];
        }

        // Traverse dot notation
        $segments = explode('.', $key);
        $current = $array;

        foreach ($segments as $segment) {
            if (is_array($current) && array_key_exists($segment, $current)) {
                $current = $current[$segment];
            } else {
                return $default;
            }
        }

        return $current;
    }
}
