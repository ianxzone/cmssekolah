<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Role;
use App\Models\Permission;

class RolePermissionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Create Permissions
        $permissions = [
            // Posts
            ['name' => 'view_posts', 'description' => 'View posts', 'group' => 'posts'],
            ['name' => 'create_posts', 'description' => 'Create new posts', 'group' => 'posts'],
            ['name' => 'edit_posts', 'description' => 'Edit existing posts', 'group' => 'posts'],
            ['name' => 'delete_posts', 'description' => 'Delete posts', 'group' => 'posts'],
            ['name' => 'publish_posts', 'description' => 'Publish/unpublish posts', 'group' => 'posts'],
            
            // Pages
            ['name' => 'view_pages', 'description' => 'View pages', 'group' => 'pages'],
            ['name' => 'create_pages', 'description' => 'Create new pages', 'group' => 'pages'],
            ['name' => 'edit_pages', 'description' => 'Edit existing pages', 'group' => 'pages'],
            ['name' => 'delete_pages', 'description' => 'Delete pages', 'group' => 'pages'],
            ['name' => 'publish_pages', 'description' => 'Publish/unpublish pages', 'group' => 'pages'],
            
            // Media
            ['name' => 'view_media', 'description' => 'View media files', 'group' => 'media'],
            ['name' => 'upload_media', 'description' => 'Upload media files', 'group' => 'media'],
            ['name' => 'delete_media', 'description' => 'Delete media files', 'group' => 'media'],
            
            // Categories & Tags
            ['name' => 'view_categories', 'description' => 'View categories', 'group' => 'categories'],
            ['name' => 'manage_categories', 'description' => 'Manage categories', 'group' => 'categories'],
            ['name' => 'view_tags', 'description' => 'View tags', 'group' => 'tags'],
            ['name' => 'manage_tags', 'description' => 'Manage tags', 'group' => 'tags'],
            
            // Events
            ['name' => 'view_events', 'description' => 'View events', 'group' => 'events'],
            ['name' => 'create_events', 'description' => 'Create new events', 'group' => 'events'],
            ['name' => 'edit_events', 'description' => 'Edit existing events', 'group' => 'events'],
            ['name' => 'delete_events', 'description' => 'Delete events', 'group' => 'events'],
            
            // Testimonials
            ['name' => 'view_testimonials', 'description' => 'View testimonials', 'group' => 'testimonials'],
            ['name' => 'create_testimonials', 'description' => 'Create new testimonials', 'group' => 'testimonials'],
            ['name' => 'edit_testimonials', 'description' => 'Edit existing testimonials', 'group' => 'testimonials'],
            ['name' => 'delete_testimonials', 'description' => 'Delete testimonials', 'group' => 'testimonials'],
            
            // Forms
            ['name' => 'view_forms', 'description' => 'View forms', 'group' => 'forms'],
            ['name' => 'create_forms', 'description' => 'Create new forms', 'group' => 'forms'],
            ['name' => 'edit_forms', 'description' => 'Edit existing forms', 'group' => 'forms'],
            ['name' => 'delete_forms', 'description' => 'Delete forms', 'group' => 'forms'],
            ['name' => 'view_form_submissions', 'description' => 'View form submissions', 'group' => 'forms'],
            ['name' => 'export_form_submissions', 'description' => 'Export form submissions', 'group' => 'forms'],
            
            // Users & Roles
            ['name' => 'view_users', 'description' => 'View users', 'group' => 'users'],
            ['name' => 'create_users', 'description' => 'Create new users', 'group' => 'users'],
            ['name' => 'edit_users', 'description' => 'Edit existing users', 'group' => 'users'],
            ['name' => 'delete_users', 'description' => 'Delete users', 'group' => 'users'],
            ['name' => 'manage_roles', 'description' => 'Manage roles and permissions', 'group' => 'users'],
            
            // Settings
            ['name' => 'view_settings', 'description' => 'View settings', 'group' => 'settings'],
            ['name' => 'edit_settings', 'description' => 'Edit settings', 'group' => 'settings'],
            
            // Maintenance
            ['name' => 'access_maintenance', 'description' => 'Access maintenance tools', 'group' => 'settings'],
            ['name' => 'clear_cache', 'description' => 'Clear application cache', 'group' => 'settings'],
            ['name' => 'toggle_maintenance_mode', 'description' => 'Toggle maintenance mode', 'group' => 'settings'],
        ];

        foreach ($permissions as $permissionData) {
            Permission::firstOrCreate(['name' => $permissionData['name']], $permissionData);
        }

        // Create Roles and Assign Permissions
        
        // Super Admin - Has ALL permissions automatically (no need to assign)
        Role::firstOrCreate([
            'name' => 'super_admin',
            'description' => 'Full system access with all permissions'
        ]);

        // Admin - Most permissions except user/role management
        $adminRole = Role::firstOrCreate([
            'name' => 'admin',
            'description' => 'Administrator with full content management access'
        ]);
        
        $adminPermissions = Permission::whereNotIn('group', ['users'])->pluck('id')->toArray();
        $adminRole->syncPermissions($adminPermissions);

        // Editor - Can manage content but not delete or manage users
        $editorRole = Role::firstOrCreate([
            'name' => 'editor',
            'description' => 'Can create, edit, and publish content'
        ]);
        
        $editorPermissions = Permission::whereIn('name', [
            'view_posts', 'create_posts', 'edit_posts', 'publish_posts',
            'view_pages', 'create_pages', 'edit_pages', 'publish_pages',
            'view_media', 'upload_media',
            'view_categories', 'manage_categories',
            'view_tags', 'manage_tags',
            'view_events', 'create_events', 'edit_events',
            'view_testimonials', 'create_testimonials', 'edit_testimonials',
            'view_forms', 'view_form_submissions', 'export_form_submissions',
            'view_settings',
        ])->pluck('id')->toArray();
        
        $editorRole->syncPermissions($editorPermissions);

        // Author - Can only create and edit own content
        $authorRole = Role::firstOrCreate([
            'name' => 'author',
            'description' => 'Can create and edit own posts'
        ]);
        
        $authorPermissions = Permission::whereIn('name', [
            'view_posts', 'create_posts', 'edit_posts',
            'view_pages', 'create_pages', 'edit_pages',
            'view_media', 'upload_media',
            'view_events', 'create_events', 'edit_events',
        ])->pluck('id')->toArray();
        
        $authorRole->syncPermissions($authorPermissions);

        $this->command->info('Roles and permissions created successfully!');
        $this->command->info('Available roles: super_admin, admin, editor, author');
    }
}
