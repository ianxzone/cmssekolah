#!/usr/bin/env php
<?php

/**
 * Security Fix Verification Script
 * 
 * This script helps verify that Phase 1 security fixes are working correctly.
 * Run this from command line: php verify_security.php
 */

echo "\n";
echo "╔════════════════════════════════════════════════════════╗\n";
echo "║   CMS Sekolah - Security Fix Verification Tool        ║\n";
echo "║   Phase 1: Critical Security Fixes                    ║\n";
echo "╚════════════════════════════════════════════════════════╝\n";
echo "\n";

// Check if running in CLI
if (php_sapi_name() !== 'cli') {
    die("This script must be run from command line\n");
}

// Bootstrap Laravel
require __DIR__ . '/vendor/autoload.php';
$app = require_once __DIR__ . '/bootstrap/app.php';
$app->make('Illuminate\Contracts\Console\Kernel')->bootstrap();

use App\Models\Setting;

$passed = 0;
$failed = 0;

function test($name, $callback) {
    global $passed, $failed;
    
    echo "Testing: {$name} ... ";
    
    try {
        $result = $callback();
        if ($result) {
            echo "✅ PASS\n";
            $passed++;
        } else {
            echo "❌ FAIL\n";
            $failed++;
        }
    } catch (Exception $e) {
        echo "❌ ERROR: " . $e->getMessage() . "\n";
        $failed++;
    }
}

echo "\n--- Testing Setting Model Security ---\n\n";

// Test 1: SQL Injection Prevention
test("SQL Injection key is rejected", function() {
    $result = Setting::get("school_name' OR '1'='1", 'blocked');
    return $result === 'blocked';
});

// Test 2: Whitelist Validation
test("Non-whitelisted key throws exception", function() {
    try {
        Setting::set('malicious_key', 'value');
        return false; // Should have thrown exception
    } catch (InvalidArgumentException $e) {
        return true;
    }
});

// Test 3: Valid Key Works
test("Valid whitelisted key works", function() {
    Setting::set('school_name', 'Test School', 'text');
    return Setting::get('school_name') === 'Test School';
});

// Test 4: XSS Prevention
test("XSS payload is sanitized", function() {
    Setting::set('school_name', '<script>alert("XSS")</script>Safe', 'text');
    $result = Setting::get('school_name');
    return strpos($result, '<script>') === false && strpos($result, 'Safe') !== false;
});

// Test 5: Boolean Sanitization
test("Boolean values are sanitized", function() {
    Setting::set('home_show_news', 'true', 'boolean');
    return Setting::get('home_show_news') === '1';
});

// Test 6: JSON Validation
test("Valid JSON is accepted", function() {
    $data = ['key' => 'value'];
    Setting::set('navbar_links', $data, 'json');
    $retrieved = json_decode(Setting::get('navbar_links'), true);
    return $retrieved === $data;
});

// Test 7: Invalid JSON Rejected
test("Invalid JSON throws exception", function() {
    try {
        Setting::set('test_field', '{invalid json}', 'json');
        return false; // Should have thrown exception
    } catch (InvalidArgumentException $e) {
        return true;
    }
});

echo "\n--- Testing File System Security ---\n\n";

// Test 8: Maintenance Controller exists
test("MaintenanceController has security methods", function() {
    $controller = new \App\Http\Controllers\Admin\MaintenanceController();
    return method_exists($controller, 'validateZipContents');
});

// Test 9: Dangerous extensions list exists
test("Dangerous extensions list is defined", function() {
    $controller = new \App\Http\Controllers\Admin\MaintenanceController();
    $reflection = new ReflectionClass($controller);
    $property = $reflection->getProperty('dangerousExtensions');
    $property->setAccessible(true);
    $extensions = $property->getValue($controller);
    return count($extensions) > 10 && in_array('php', $extensions);
});

// Test 10: View files are updated
test("Custom scripts are disabled in views", function() {
    $viewPath = __DIR__ . '/resources/views/themes/modern/layouts/app.blade.php';
    $content = file_get_contents($viewPath);
    
    // Check if custom_header_scripts is commented out
    $hasCommentedHeader = strpos($content, '{{-- {!! $settings[\'custom_header_scripts\'] !!} --}}') !== false;
    $hasCommentedFooter = strpos($content, '{{-- {!! $settings[\'custom_footer_scripts\'] !!} --}}') !== false;
    
    return $hasCommentedHeader && $hasCommentedFooter;
});

echo "\n--- Testing Environment Configuration ---\n\n";

// Test 11: Check .env exists
test(".env file exists", function() {
    return file_exists(__DIR__ . '/.env');
});

// Test 12: APP_KEY is set
test("APP_KEY is configured", function() {
    $envContent = file_get_contents(__DIR__ . '/.env');
    return strpos($envContent, 'APP_KEY=base64:') !== false;
});

// Test 13: Database connection configured
test("Database is configured", function() {
    $envContent = file_get_contents(__DIR__ . '/.env');
    return strpos($envContent, 'DB_CONNECTION=mysql') !== false;
});

echo "\n";
echo "╔════════════════════════════════════════════════════════╗\n";
echo "║                    TEST SUMMARY                        ║\n";
echo "╠════════════════════════════════════════════════════════╣\n";
printf("║  Passed: %-3d                                         ║\n", $passed);
printf("║  Failed: %-3d                                         ║\n", $failed);
echo "╠════════════════════════════════════════════════════════╣\n";

if ($failed === 0) {
    echo "║  ✅ ALL TESTS PASSED! Security fixes verified.      ║\n";
} else {
    echo "║  ⚠️  SOME TESTS FAILED! Review the output above.    ║\n";
}

echo "╚════════════════════════════════════════════════════════╝\n";
echo "\n";

// Manual checks
echo "\n📋 MANUAL VERIFICATION CHECKLIST:\n";
echo "━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━\n\n";

echo "1. Update your .env file with these CRITICAL settings:\n";
echo "   ☐ APP_DEBUG=false\n";
echo "   ☐ DB_PASSWORD=<strong_password>\n";
echo "   ☐ SESSION_SECURE_COOKIE=true\n\n";

echo "2. Test ZIP upload blocking:\n";
echo "   ☐ Try uploading ZIP with malicious.php → Should be rejected\n";
echo "   ☐ Try uploading ZIP with path traversal → Should be rejected\n";
echo "   ☐ Upload safe ZIP with .txt/.css/.js → Should work\n\n";

echo "3. Test SQL injection prevention:\n";
echo "   ☐ Try Setting::get(\"malicious' OR '1'='1\") → Returns default\n";
echo "   ☐ Try Setting::set('bad_key', 'x') → Throws exception\n\n";

echo "4. Clear all caches:\n";
echo "   ☐ php artisan config:clear\n";
echo "   ☐ php artisan cache:clear\n";
echo "   ☐ php artisan view:clear\n\n";

echo "5. Monitor logs for security warnings:\n";
echo "   ☐ tail -f storage/logs/laravel.log\n\n";

echo "━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━\n\n";

exit($failed > 0 ? 1 : 0);
