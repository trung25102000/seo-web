<?php

namespace Tests\Feature;

use App\Models\BlogPost;
use App\Models\ServiceOffering;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class MobileConversionUiTest extends TestCase
{
    use RefreshDatabase;

    public function test_public_funnel_pages_render_mobile_conversion_markers(): void
    {
        $this->withoutVite();

        $service = ServiceOffering::query()->create([
            'name' => 'Thiết kế website theo yêu cầu',
            'slug' => 'thiet-ke-website-theo-yeu-cau',
            'service_group' => 'website',
            'short_description' => 'Làm website và landing page theo scope.',
            'detail_description' => 'Chi tiết dịch vụ website.',
            'status' => 'published',
            'sort_order' => 1,
        ]);

        BlogPost::query()->create([
            'title' => 'Checklist landing page mobile-first',
            'slug' => 'checklist-landing-page-mobile-first',
            'content_pillar' => 'landing_page',
            'service_group' => 'website',
            'content' => 'Nội dung bài viết.',
            'status' => 'published',
            'published_at' => now(),
        ]);

        $this->get('/')
            ->assertOk()
            ->assertSee('data-mobile-sticky-bar', false)
            ->assertSee('pb-28', false);

        $this->get('/services')
            ->assertOk()
            ->assertSee('data-mobile-card-grid', false)
            ->assertSee('data-mobile-funnel', false)
            ->assertSee('data-mobile-form', false);

        $this->get("/services/{$service->slug}")
            ->assertOk()
            ->assertSee('data-mobile-hero-cta', false)
            ->assertSee('data-mobile-funnel', false);

        $this->get('/blog')
            ->assertOk()
            ->assertSee('Xem dịch vụ liên quan');
    }
}
