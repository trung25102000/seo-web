<?php

namespace Tests\Feature;

use App\Models\BlogPost;
use App\Models\ServiceOffering;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class PerformanceUiSmokeTest extends TestCase
{
    use RefreshDatabase;

    public function test_core_public_pages_keep_expected_ui_markers_without_extra_noise(): void
    {
        $this->withoutVite();

        ServiceOffering::query()->create([
            'name' => 'Fix giao diện website',
            'slug' => 'fix-giao-dien-website',
            'service_group' => 'ui_fix',
            'short_description' => 'Sửa responsive và CTA.',
            'detail_description' => 'Chi tiết dịch vụ.',
            'status' => 'published',
            'sort_order' => 1,
        ]);

        BlogPost::query()->create([
            'title' => 'Checklist sửa responsive cho mobile',
            'slug' => 'checklist-sua-responsive-cho-mobile',
            'content_pillar' => 'ui_fix',
            'service_group' => 'ui_fix',
            'content' => 'Nội dung bài viết.',
            'status' => 'published',
            'published_at' => now(),
        ]);

        $this->get('/')
            ->assertOk()
            ->assertSee('data-landing-section="hero"', false)
            ->assertSee('data-sticky-cta', false)
            ->assertSee('id="main-content"', false);

        $this->get('/services')
            ->assertOk()
            ->assertDontSee('data-landing-section="problems"', false)
            ->assertSee('data-contact-cta', false);

        $this->get('/blog')
            ->assertOk()
            ->assertDontSee('data-landing-section="problems"', false)
            ->assertSee('Xem dịch vụ liên quan');
    }
}
