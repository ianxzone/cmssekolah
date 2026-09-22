<?php

namespace Tests\Feature;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use Tests\TestCase;

class MediaUploadTest extends TestCase
{
    use RefreshDatabase;

    public function test_it_rejects_file_larger_than_2mb(): void
    {
        Storage::fake('public');

        // Create a 2.5MB dummy file (2560 KB)
        $file = UploadedFile::fake()->create('large-image.jpg', 2560, 'image/jpeg');

        // Login as an admin/user if authentication is required or post directly
        $user = User::factory()->make(['id' => 1]);
        $response = $this->actingAs($user)->post(route('admin.media.store'), [
            'file' => $file,
        ], ['Accept' => 'application/json']);

        $response->assertStatus(422);
        $response->assertJsonValidationErrors(['file']);
    }

    public function test_it_accepts_and_optimizes_image_under_2mb(): void
    {
        Storage::fake('public');

        // Create a dummy image
        $img = imagecreatetruecolor(800, 600);
        $bg = imagecolorallocate($img, 10, 100, 50);
        imagefilledrectangle($img, 0, 0, 800, 600, $bg);

        $tmpFile = tempnam(sys_get_temp_dir(), 'test_media_') . '.jpg';
        imagejpeg($img, $tmpFile, 90);
        imagedestroy($img);

        $uploadedFile = new UploadedFile($tmpFile, 'sample-photo.jpg', 'image/jpeg', null, true);

        $user = User::factory()->make(['id' => 1]);
        $response = $this->actingAs($user)->post(route('admin.media.store'), [
            'file' => $uploadedFile,
            'title' => 'Sample Photo',
        ], ['Accept' => 'application/json']);

        $response->assertStatus(200);
        $response->assertJsonPath('success', true);
        $this->assertSame('image/webp', $response->json('media.mime_type'));

        @unlink($tmpFile);
    }
}
