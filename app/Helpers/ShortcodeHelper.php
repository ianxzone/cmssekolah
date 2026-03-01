<?php

namespace App\Helpers;

use Illuminate\Support\Str;

class ShortcodeHelper
{
    /**
     * Parse content for shortcodes.
     * 
     * @param string $content
     * @return string
     */
    public static function parse($content)
    {
        if (empty($content)) {
            return '';
        }

        // [pdf url="..."]
        $content = preg_replace_callback('/\[pdf\s+url=["\']([^"\']+)["\']\s*\]/', function ($matches) {
            $url = $matches[1];

            // Handle relative URLs if needed (e.g., from storage)
            if (!Str::startsWith($url, ['http://', 'https://', '/'])) {
                $url = \Illuminate\Support\Facades\Storage::url($url);
            }

            return '
            <div class="pdf-container" style="margin: 20px 0; border: 1px solid var(--border-color); border-radius: 12px; overflow: hidden; box-shadow: var(--shadow-sm);">
                <div class="pdf-header" style="background: var(--bg-light); padding: 10px 20px; border-bottom: 1px solid var(--border-color); display: flex; justify-content: space-between; align-items: center;">
                    <span style="font-weight: 700; font-size: 0.9rem; color: var(--primary-dark); display: flex; align-items: center; gap: 8px;">
                        <i data-feather="file-text" style="width: 16px;"></i> Document PDF
                    </span>
                    <a href="' . $url . '" target="_blank" class="btn-pdf-download" style="font-size: 0.8rem; background: var(--primary); color: white; padding: 5px 12px; border-radius: 6px; text-decoration: none; font-weight: 600;">
                        Download PDF
                    </a>
                </div>
                <div class="pdf-body" style="background: #525659; position: relative; padding-bottom: 75%; height: 0; overflow: hidden;">
                    <iframe src="' . $url . '" style="position: absolute; top: 0; left: 0; width: 100%; height: 100%; border: none;"></iframe>
                </div>
                <script>if(window.feather) feather.replace();</script>
            </div>';
        }, $content);

        return $content;
    }
}
