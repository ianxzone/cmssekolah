<?php

namespace Tests\Feature;

use App\Models\User;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class Phase2SecurityTest extends TestCase
{
    use RefreshDatabase;
    
    protected function setUp(): void
    {
        parent::setUp();
        
        $this->admin = User::create([
            'name' => 'Admin User',
            'email' => 'admin@test.com',
            'password' => bcrypt('password123'),
        ]);
    }
    
    /**
     * TEST 1: Rate Limiting on Login
     */
    public function test_login_is_rate_limited(): void
    {
        // Make 6 login attempts (limit is 5 per minute)
        for ($i = 0; $i < 6; $i++) {
            $response = $this->post(route('admin.login.post'), [
                'email' => 'nonexistent@test.com',
                'password' => 'wrongpassword'
            ]);
        }
        
        // 6th attempt should be rate limited
        $response->assertStatus(429); // Too Many Requests
    }
    
    /**
     * TEST 2: Rate Limiting on Form Submissions
     */
    public function test_form_submission_is_rate_limited(): void
    {
        // Create a test form first
        $form = \App\Models\Form::create([
            'title' => 'Test Form',
            'slug' => 'test-form',
            'fields' => json_encode([
                ['name' => 'Test Field', 'type' => 'text', 'required' => true]
            ]),
            'is_active' => true,
        ]);
        
        // Make 11 form submissions (limit is 10 per minute)
        for ($i = 0; $i < 11; $i++) {
            $response = $this->post(route('forms.submit', $form->slug), [
                'test_field' => 'test value'
            ]);
        }
        
        // 11th attempt should be rate limited
        $response->assertStatus(429);
    }
    
    /**
     * TEST 3: Security Headers Are Present
     */
    public function test_security_headers_are_set(): void
    {
        $response = $this->get('/');
        
        $response->assertHeader('X-Frame-Options', 'SAMEORIGIN');
        $response->assertHeader('X-Content-Type-Options', 'nosniff');
        $response->assertHeader('X-XSS-Protection', '1; mode=block');
        $response->assertHeader('Referrer-Policy', 'strict-origin-when-cross-origin');
        $response->assertHeader('Content-Security-Policy');
    }
    
    /**
     * TEST 4: Password Strength Validation in Install
     */
    public function test_weak_passwords_are_rejected_in_install(): void
    {
        $response = $this->post(route('install.admin.save'), [
            'name' => 'Test Admin',
            'email' => 'admin@test.com',
            'password' => 'weak', // Too weak
            'password_confirmation' => 'weak',
        ]);
        
        $response->assertSessionHasErrors('password');
    }
    
    /**
     * TEST 5: Strong Password Requirements
     */
    public function test_strong_password_requirements(): void
    {
        // Password without uppercase
        $response = $this->post(route('install.admin.save'), [
            'name' => 'Test Admin',
            'email' => 'admin@test.com',
            'password' => 'password123!',
            'password_confirmation' => 'password123!',
        ]);
        $response->assertSessionHasErrors('password');
        
        // Password without number
        $response = $this->post(route('install.admin.save'), [
            'name' => 'Test Admin',
            'email' => 'admin@test.com',
            'password' => 'Password!',
            'password_confirmation' => 'Password!',
        ]);
        $response->assertSessionHasErrors('password');
        
        // Password without special character
        $response = $this->post(route('install.admin.save'), [
            'name' => 'Test Admin',
            'email' => 'admin@test.com',
            'password' => 'Password123',
            'password_confirmation' => 'Password123',
        ]);
        $response->assertSessionHasErrors('password');
    }
    
    /**
     * TEST 6: Valid Strong Password Accepted
     */
    public function test_strong_password_is_accepted(): void
    {
        Storage::fake('local');
        
        // First, simulate successful installation up to admin creation
        file_put_contents(storage_path('installed'), date('Y-m-d H:i:s'));
        
        $response = $this->post(route('install.admin.save'), [
            'name' => 'Test Admin',
            'email' => 'admin@test.com',
            'password' => 'StrongPass123!',
            'password_confirmation' => 'StrongPass123!',
        ]);
        
        // Should not have password errors
        $response->assertSessionDoesntHaveErrors('password');
    }
    
    /**
     * TEST 7: MIME Type Validation in Media Upload
     */
    public function test_media_upload_validates_mime_type(): void
    {
        Storage::fake('public');
        
        // Try to upload PHP file disguised as image
        $fakeImage = UploadedFile::fake()->createWithContent(
            'shell.php',
            '<?php system($_GET["cmd"]); ?>'
        );
        
        $response = $this->actingAs($this->admin)
            ->post(route('admin.media.store'), [
                'file' => $fakeImage
            ]);
        
        $response->assertSessionHasErrors('file');
        $this->assertStringContainsStringIgnoringCase(
            'not allowed',
            $response->session()->get('errors')->first('file')
        );
    }
    
    /**
     * TEST 8: Extension-MIME Type Mismatch Detection
     */
    public function test_detects_extension_mime_mismatch(): void
    {
        Storage::fake('public');
        
        // Create a text file with .jpg extension
        $fakeImage = UploadedFile::fake()->createWithContent(
            'image.jpg',
            'This is actually a text file, not an image!'
        );
        
        $response = $this->actingAs($this->admin)
            ->post(route('admin.media.store'), [
                'file' => $fakeImage
            ]);
        
        // Should detect mismatch or invalid MIME type
        $response->assertSessionHasErrors('file');
    }
    
    /**
     * TEST 9: Executable Content Detection in Files
     */
    public function test_detects_executable_content_in_uploads(): void
    {
        Storage::fake('public');
        
        // Create a file with PHP code but named as text
        $maliciousFile = UploadedFile::fake()->createWithContent(
            'readme.txt',
            '<?php eval($_POST["cmd"]); ?>'
        );
        
        $response = $this->actingAs($this->admin)
            ->post(route('admin.media.store'), [
                'file' => $maliciousFile
            ]);
        
        $response->assertSessionHasErrors('file');
        $this->assertStringContainsStringIgnoringCase(
            'suspicious',
            strtolower($response->session()->get('errors')->first('file'))
        );
    }
    
    /**
     * TEST 10: Valid Image Upload Works
     */
    public function test_valid_image_upload_succeeds(): void
    {
        Storage::fake('public');
        
        // Create a valid image
        $image = UploadedFile::fake()->image('photo.jpg', 800, 600);
        
        $response = $this->actingAs($this->admin)
            ->post(route('admin.media.store'), [
                'file' => $image
            ]);
        
        $response->assertSessionDoesntHaveErrors('file');
        Storage::disk('public')->assertExists('media/' . $image->hashName());
    }
    
    /**
     * TEST 11: CSRF Token Regeneration on Login
     */
    public function test_csrf_token_regenerates_on_login(): void
    {
        $oldToken = session()->getToken();
        
        $user = User::create([
            'name' => 'Login Test User',
            'email' => 'login@test.com',
            'password' => bcrypt('StrongPass123!'),
        ]);
        
        $response = $this->post(route('admin.login.post'), [
            'email' => 'login@test.com',
            'password' => 'StrongPass123!',
        ]);
        
        $newToken = session()->getToken();
        
        // Token should be regenerated
        $this->assertNotEquals($oldToken, $newToken);
    }
    
    /**
     * TEST 12: Email Verification Required
     */
    public function test_user_must_verify_email(): void
    {
        // Check that User model implements MustVerifyEmail
        $user = new User();
        $this->assertInstanceOf(
            \Illuminate\Contracts\Auth\MustVerifyEmail::class,
            $user
        );
    }
    
    /**
     * TEST 13: Role Field Fillable in User Model
     */
    public function test_role_field_is_fillable(): void
    {
        $user = new User();
        $fillable = $user->getFillable();
        
        $this->assertContains('role', $fillable);
    }
    
    /**
     * TEST 14: Clickjacking Protection
     */
    public function test_clickjacking_protection_header(): void
    {
        $response = $this->get('/');
        
        $response->assertHeader('X-Frame-Options', 'SAMEORIGIN');
    }
    
    /**
     * TEST 15: CSP Header Prevents XSS
     */
    public function test_csp_header_is_set(): void
    {
        $response = $this->get('/');
        
        $response->assertHeader('Content-Security-Policy');
        $csp = $response->headers->get('Content-Security-Policy');
        
        // CSP should restrict script sources
        $this->assertStringContainsString("default-src 'self'", $csp);
        $this->assertStringContainsString("script-src", $csp);
    }
}
