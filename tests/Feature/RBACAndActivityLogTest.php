<?php

namespace Tests\Feature;

use App\Models\User;
use App\Models\Role;
use App\Models\Permission;
use App\Models\Post;
use App\Models\ActivityLog;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class RBACAndActivityLogTest extends TestCase
{
    use RefreshDatabase;
    
    protected function setUp(): void
    {
        parent::setUp();
        
        // Create roles and permissions
        $this->seed(\Database\Seeders\RolePermissionSeeder::class);
        
        // Create test users with different roles
        $this->superAdmin = User::create([
            'name' => 'Super Admin',
            'email' => 'superadmin@test.com',
            'password' => bcrypt('StrongPass123!'),
        ])->assignRole('super_admin');
        
        $this->admin = User::create([
            'name' => 'Admin User',
            'email' => 'admin@test.com',
            'password' => bcrypt('StrongPass123!'),
        ])->assignRole('admin');
        
        $this->editor = User::create([
            'name' => 'Editor User',
            'email' => 'editor@test.com',
            'password' => bcrypt('StrongPass123!'),
        ])->assignRole('editor');
        
        $this->author = User::create([
            'name' => 'Author User',
            'email' => 'author@test.com',
            'password' => bcrypt('StrongPass123!'),
        ])->assignRole('author');
    }
    
    /**
     * TEST 1: Role Creation
     */
    public function test_roles_are_created(): void
    {
        $this->assertDatabaseHas('roles', ['name' => 'super_admin']);
        $this->assertDatabaseHas('roles', ['name' => 'admin']);
        $this->assertDatabaseHas('roles', ['name' => 'editor']);
        $this->assertDatabaseHas('roles', ['name' => 'author']);
    }
    
    /**
     * TEST 2: Permissions Are Created
     */
    public function test_permissions_are_created(): void
    {
        $this->assertDatabaseHas('permissions', ['name' => 'create_posts']);
        $this->assertDatabaseHas('permissions', ['name' => 'edit_posts']);
        $this->assertDatabaseHas('permissions', ['name' => 'delete_posts']);
        $this->assertDatabaseHas('permissions', ['name' => 'manage_roles']);
    }
    
    /**
     * TEST 3: Super Admin Has All Permissions
     */
    public function test_super_admin_has_all_permissions(): void
    {
        $this->assertTrue($this->superAdmin->hasPermission('create_posts'));
        $this->assertTrue($this->superAdmin->hasPermission('delete_posts'));
        $this->assertTrue($this->superAdmin->hasPermission('manage_roles'));
        $this->assertTrue($this->superAdmin->hasPermission('non_existent_permission')); // Should return true for anything
    }
    
    /**
     * TEST 4: Admin Role Permissions
     */
    public function test_admin_role_permissions(): void
    {
        $adminUser = $this->admin;
        
        // Admin should have content permissions
        $this->assertTrue($adminUser->hasPermission('create_posts'));
        $this->assertTrue($adminUser->hasPermission('edit_posts'));
        
        // Admin should NOT have user management permissions
        $this->assertFalse($adminUser->hasPermission('manage_roles'));
    }
    
    /**
     * TEST 5: Editor Role Permissions
     */
    public function test_editor_role_permissions(): void
    {
        $editorUser = $this->editor;
        
        // Editor can publish posts
        $this->assertTrue($editorUser->hasPermission('publish_posts'));
        
        // Editor cannot delete posts
        $this->assertFalse($editorUser->hasPermission('delete_posts'));
        
        // Editor cannot manage users
        $this->assertFalse($editorUser->hasPermission('view_users'));
    }
    
    /**
     * TEST 6: Author Role Permissions
     */
    public function test_author_role_permissions(): void
    {
        $authorUser = $this->author;
        
        // Author can create posts
        $this->assertTrue($authorUser->hasPermission('create_posts'));
        
        // Author cannot publish posts
        $this->assertFalse($authorUser->hasPermission('publish_posts'));
        
        // Author cannot delete posts
        $this->assertFalse($authorUser->hasPermission('delete_posts'));
    }
    
    /**
     * TEST 7: Role Middleware - Access Granted
     */
    public function test_role_middleware_grants_access(): void
    {
        $response = $this->actingAs($this->admin)
            ->get(route('admin.dashboard'));
        
        $response->assertStatus(200);
    }
    
    /**
     * TEST 8: Activity Log - Create Event
     */
    public function test_activity_log_create_event(): void
    {
        $post = Post::create([
            'title' => 'Test Post',
            'slug' => 'test-post',
            'content' => 'Test content',
            'user_id' => $this->admin->id,
        ]);
        
        // Log the creation
        ActivityLog::logCreated($this->admin, $post);
        
        $this->assertDatabaseHas('activity_logs', [
            'user_id' => $this->admin->id,
            'log_name' => 'posts',
            'event' => 'created',
            'subject_type' => Post::class,
            'subject_id' => $post->id,
        ]);
    }
    
    /**
     * TEST 9: Activity Log - Update Event
     */
    public function test_activity_log_update_event(): void
    {
        $post = Post::create([
            'title' => 'Test Post',
            'slug' => 'test-post',
            'content' => 'Test content',
            'user_id' => $this->admin->id,
        ]);
        
        $post->update(['title' => 'Updated Title']);
        
        ActivityLog::logUpdated($this->admin, $post, ['old_title' => 'Test Post', 'new_title' => 'Updated Title']);
        
        $this->assertDatabaseHas('activity_logs', [
            'user_id' => $this->admin->id,
            'event' => 'updated',
            'description' => 'Post updated',
        ]);
        
        $log = ActivityLog::latest()->first();
        $this->assertEquals(['old_title' => 'Test Post', 'new_title' => 'Updated Title'], $log->properties);
    }
    
    /**
     * TEST 10: Activity Log - Delete Event
     */
    public function test_activity_log_delete_event(): void
    {
        $post = Post::create([
            'title' => 'Test Post',
            'slug' => 'test-post',
            'content' => 'Test content',
            'user_id' => $this->admin->id,
        ]);
        
        $postId = $post->id;
        $post->delete();
        
        ActivityLog::logDeleted($this->admin, $post, ['title' => 'Test Post']);
        
        $this->assertDatabaseHas('activity_logs', [
            'user_id' => $this->admin->id,
            'event' => 'deleted',
            'subject_type' => Post::class,
            'subject_id' => null, // Deleted subject has no ID
        ]);
    }
    
    /**
     * TEST 11: User Can Check Own Role
     */
    public function test_user_can_check_own_role(): void
    {
        $this->assertTrue($this->superAdmin->hasRole('super_admin'));
        $this->assertTrue($this->admin->hasRole('admin'));
        $this->assertFalse($this->author->hasRole('admin'));
    }
    
    /**
     * TEST 12: User Can Have Any Role
     */
    public function test_user_can_have_any_role(): void
    {
        $this->assertTrue($this->superAdmin->hasAnyRole(['super_admin', 'admin']));
        $this->assertTrue($this->author->hasAnyRole(['author', 'editor']));
        $this->assertFalse($this->author->hasAnyRole(['admin', 'super_admin']));
    }
    
    /**
     * TEST 13: Activity Log Stores IP and User Agent
     */
    public function test_activity_log_stores_ip_and_user_agent(): void
    {
        $post = Post::create([
            'title' => 'IP Test Post',
            'slug' => 'ip-test-post',
            'content' => 'Test',
            'user_id' => $this->admin->id,
        ]);
        
        ActivityLog::logCreated($this->admin, $post);
        
        $log = ActivityLog::latest()->first();
        
        $this->assertNotNull($log->ip_address);
        $this->assertNotNull($log->user_agent);
    }
    
    /**
     * TEST 14: Assign Role To User
     */
    public function test_assign_role_to_user(): void
    {
        $newUser = User::create([
            'name' => 'New User',
            'email' => 'newuser@test.com',
            'password' => bcrypt('StrongPass123!'),
        ]);
        
        $this->assertNull($newUser->role);
        
        $newUser->assignRole('editor');
        
        $this->assertNotNull($newUser->role);
        $this->assertEquals('editor', $newUser->role->name);
    }
    
    /**
     * TEST 15: Permission Query Scopes
     */
    public function test_permission_query_scopes(): void
    {
        $postLogs = ActivityLog::forLog('posts')->get();
        $this->assertInstanceOf(\Illuminate\Database\Eloquent\Collection::class, $postLogs);
        
        $userLogs = ActivityLog::byUser($this->admin->id)->get();
        $this->assertInstanceOf(\Illuminate\Database\Eloquent\Collection::class, $userLogs);
        
        $createdLogs = ActivityLog::forEvent('created')->get();
        $this->assertInstanceOf(\Illuminate\Database\Eloquent\Collection::class, $createdLogs);
    }
}
