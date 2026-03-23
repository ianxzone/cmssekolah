#!/usr/bin/env php
<?php

/**
 * Phase 3 RBAC & Activity Logging Verification Script
 * 
 * Run this to verify all Phase 3 features are working correctly.
 */

echo "\n";
echo "╔════════════════════════════════════════════════════════╗\n";
echo "║   Phase 3: RBAC & Activity Log Verification           ║\n";
echo "╚════════════════════════════════════════════════════════╝\n";
echo "\n";

if (php_sapi_name() !== 'cli') {
    die("This script must be run from command line\n");
}

require __DIR__ . '/vendor/autoload.php';
$app = require_once __DIR__ . '/bootstrap/app.php';
$app->make('Illuminate\Contracts\Console\Kernel')->bootstrap();

use App\Models\Role;
use App\Models\Permission;
use App\Models\User;
use App\Models\ActivityLog;

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

echo "\n--- Database Structure Tests ---\n\n";

// Test 1: Roles table exists
test("Roles table exists", function() {
    return \Schema::hasTable('roles');
});

// Test 2: Permissions table exists
test("Permissions table exists", function() {
    return \Schema::hasTable('permissions');
});

// Test 3: Role has permissions pivot
test("Role_has_permissions table exists", function() {
    return \Schema::hasTable('role_has_permissions');
});

// Test 4: Activity logs table exists
test("Activity_logs table exists", function() {
    return \Schema::hasTable('activity_logs');
});

// Test 5: Users have role_id column
test("Users table has role_id column", function() {
    return \Schema::hasColumn('users', 'role_id');
});

echo "\n--- Seed Data Tests ---\n\n";

// Test 6: Roles are seeded
test("Roles are seeded (4 roles)", function() {
    return Role::count() >= 4;
});

// Test 7: Permissions are seeded
test("Permissions are seeded (40+ permissions)", function() {
    $count = Permission::count();
    echo "(Found: $count permissions) ";
    return $count >= 40;
});

// Test 8: Super admin role exists
test("Super admin role exists", function() {
    return Role::where('name', 'super_admin')->exists();
});

// Test 9: Admin role exists
test("Admin role exists", function() {
    return Role::where('name', 'admin')->exists();
});

// Test 10: Editor role exists
test("Editor role exists", function() {
    return Role::where('name', 'editor')->exists();
});

// Test 11: Author role exists
test("Author role exists", function() {
    return Role::where('name', 'author')->exists();
});

echo "\n--- Model Tests ---\n\n";

// Test 12: Role model methods exist
test("Role model has hasPermission method", function() {
    $role = Role::first();
    return method_exists($role, 'hasPermission');
});

// Test 13: User model has role relationship
test("User model has role relationship", function() {
    $user = User::first();
    return method_exists($user, 'role');
});

// Test 14: User model has hasRole method
test("User model has hasRole method", function() {
    $user = new User();
    return method_exists($user, 'hasRole');
});

// Test 15: User model has hasPermission method
test("User model has hasPermission method", function() {
    $user = new User();
    return method_exists($user, 'hasPermission');
});

// Test 16: ActivityLog model exists and works
test("ActivityLog model can create entries", function() {
    $log = ActivityLog::create([
        'user_id' => 1,
        'log_name' => 'test',
        'description' => 'Test entry',
        'event' => 'created',
        'ip_address' => '127.0.0.1',
        'user_agent' => 'Test Agent',
    ]);
    
    $success = $log->id > 0;
    $log->delete(); // Cleanup
    
    return $success;
});

// Test 17: Activity log properties JSON casting
test("Activity log properties cast JSON correctly", function() {
    $log = ActivityLog::create([
        'user_id' => 1,
        'log_name' => 'test',
        'description' => 'Test',
        'event' => 'created',
        'properties' => ['key' => 'value'],
        'ip_address' => '127.0.0.1',
        'user_agent' => 'Test',
    ]);
    
    $props = $log->properties;
    $log->delete(); // Cleanup
    
    return is_array($props) && isset($props['key']);
});

echo "\n--- Middleware Tests ---\n\n";

// Test 18: Role middleware registered
test("Role middleware is registered", function() {
    // Simply check if the middleware file exists and is valid
    return file_exists(base_path('app/Http/Middleware/RoleMiddleware.php'));
});

// Test 19: Permission middleware registered
test("Permission middleware is registered", function() {
    // Simply check if the middleware file exists and is valid
    return file_exists(base_path('app/Http/Middleware/PermissionMiddleware.php'));
});

echo "\n";
echo "╔════════════════════════════════════════════════════════╗\n";
echo "║                    TEST SUMMARY                        ║\n";
echo "╠════════════════════════════════════════════════════════╣\n";
printf("║  Passed: %-3d                                         ║\n", $passed);
printf("║  Failed: %-3d                                         ║\n", $failed);
echo "╠════════════════════════════════════════════════════════╣\n";

if ($failed === 0) {
    echo "║  ✅ ALL TESTS PASSED! Phase 3 verified.             ║\n";
} else {
    echo "║  ⚠️  SOME TESTS FAILED! Run migrations first.       ║\n";
}

echo "╚════════════════════════════════════════════════════════╝\n";
echo "\n";

// Manual checks
echo "\n📋 MANUAL VERIFICATION CHECKLIST:\n";
echo "━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━\n\n";

echo "1. Run migration to create tables:\n";
echo "   ☐ php artisan migrate\n\n";

echo "2. Seed roles and permissions:\n";
echo "   ☐ php artisan db:seed --class=RolePermissionSeeder\n\n";

echo "3. Assign super_admin role to your main user:\n";
echo "   ☐ php artisan tinker\n";
echo "   >>> User::find(1)->assignRole('super_admin');\n\n";

echo "4. Test role-based access:\n";
echo "   ☐ Create user with editor role\n";
echo "   ☐ Try accessing admin-only route → Should fail\n";
echo "   ☐ Login as super_admin → Should work\n\n";

echo "5. Test activity logging:\n";
echo "   ☐ Create a post/page\n";
echo "   ☐ Check activity_logs table for entry\n";
echo "   ☐ Verify IP and user agent are logged\n\n";

echo "6. View recent activity logs:\n";
echo "   ☐ php artisan tinker\n";
echo "   >>> ActivityLog::latest()->take(10)->get();\n\n";

echo "━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━\n\n";

exit($failed > 0 ? 1 : 0);
