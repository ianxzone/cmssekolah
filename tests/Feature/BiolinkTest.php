<?php

namespace Tests\Feature;

use Tests\TestCase;
use App\Models\BiolinkProfile;
use App\Models\BiolinkSection;
use App\Models\BiolinkLink;

class BiolinkTest extends TestCase
{
    public function test_biolink_public_page_can_be_rendered(): void
    {
        $response = $this->get('/links');

        $response->assertStatus(200);
        $response->assertSee('Al Irsyad Al Islamiyyah');
        $response->assertSee('Daftar PPDB Online');
        $response->assertSee('Islamic Tech Generation');
    }

    public function test_biolink_alias_can_be_rendered(): void
    {
        $response = $this->get('/biolink');

        $response->assertStatus(200);
        $response->assertSee('Al Irsyad Al Islamiyyah');
    }

    public function test_biolink_click_tracking_increments_and_redirects(): void
    {
        $link = BiolinkLink::first();
        $this->assertNotNull($link);

        $initialClicks = $link->clicks_count;

        $response = $this->get('/links/click/' . $link->id);

        $response->assertStatus(302);
        $response->assertRedirect($link->url);

        $link->refresh();
        $this->assertEquals($initialClicks + 1, $link->clicks_count);
    }

    public function test_admin_biolink_dashboard_can_be_rendered(): void
    {
        $response = $this->get('/admin/biolink');

        $response->assertStatus(200);
        $response->assertSee('Biolink Manager');
        $response->assertSee('Pendaftaran (PPDB)');
        $response->assertSee('Daftar PPDB Online');
    }

    public function test_admin_can_update_profile_settings(): void
    {
        $profile = BiolinkProfile::first();

        $response = $this->post('/admin/biolink/profile', [
            'title' => 'Al Irsyad Al Islamiyyah Test',
            'subtitle' => 'Cabang Karawang',
            'badge_text' => 'Islamic Tech Future',
            'bio' => 'Test Deskripsi Singkat Biolink',
            'theme_bg_color' => '#022c19',
            'theme_primary_color' => '#006837',
            'theme_accent_color' => '#FBB03B',
            'show_verified_badge' => '1',
            'show_pattern' => '1',
            'show_scanline' => '1',
            'is_active' => '1',
        ]);

        $response->assertStatus(302);
        $response->assertSessionHas('success');

        $profile->refresh();
        $this->assertEquals('Al Irsyad Al Islamiyyah Test', $profile->title);
        $this->assertEquals('Islamic Tech Future', $profile->badge_text);

        // Reset
        $profile->update([
            'title' => 'Al Irsyad Al Islamiyyah',
            'subtitle' => 'Karawang Branch',
            'badge_text' => 'Islamic Tech Generation',
        ]);
    }

    public function test_admin_can_create_update_and_delete_section(): void
    {
        $profile = BiolinkProfile::first();

        // Create
        $response = $this->post('/admin/biolink/sections', [
            'profile_id' => $profile->id,
            'title' => 'Seksi Uji Coba',
            'icon' => 'fa-solid fa-star',
            'layout_type' => 'list',
            'sort_order' => 99,
            'is_active' => '1',
        ]);

        $response->assertStatus(302);
        $response->assertSessionHas('success');

        $section = BiolinkSection::where('title', 'Seksi Uji Coba')->first();
        $this->assertNotNull($section);

        // Update
        $updateResponse = $this->put('/admin/biolink/sections/' . $section->id, [
            'title' => 'Seksi Uji Coba Updated',
            'icon' => 'fa-solid fa-star-half',
            'layout_type' => 'grid_2',
            'sort_order' => 98,
            'is_active' => '1',
        ]);

        $updateResponse->assertStatus(302);
        $section->refresh();
        $this->assertEquals('Seksi Uji Coba Updated', $section->title);
        $this->assertEquals('grid_2', $section->layout_type);

        // Delete
        $deleteResponse = $this->delete('/admin/biolink/sections/' . $section->id);
        $deleteResponse->assertStatus(302);
        $this->assertNull(BiolinkSection::where('title', 'Seksi Uji Coba Updated')->first());
    }
}
