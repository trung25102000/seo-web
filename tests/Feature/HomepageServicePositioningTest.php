<?php

namespace Tests\Feature;

use App\Models\ServiceOffering;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class HomepageServicePositioningTest extends TestCase
{
    use RefreshDatabase;

    public function test_homepage_positions_services_as_primary_offer(): void
    {
        $this->withoutVite();

        ServiceOffering::query()->create([
            'name' => 'Nhận làm task lập trình nhanh',
            'slug' => 'nhan-lam-task-lap-trinh-nhanh',
            'service_group' => 'coding_task',
            'short_description' => 'Fix bug, API, UI và database theo scope nhỏ.',
            'detail_description' => 'Chi tiết dịch vụ task code.',
            'status' => 'published',
            'sort_order' => 1,
        ]);

        $response = $this->get('/');

        $response->assertOk();
        $response->assertSee('data-hero-section', false);
        $response->assertSee('data-hero-visuals', false);
        $response->assertSee('data-landing-section="services"', false);
        $response->assertSee('data-service-visual-grid', false);
        $response->assertSee('data-service-visual-card', false);
        $response->assertDontSee('data-tech-marquee', false);
        $response->assertDontSee('data-conversion-strip', false);
        $response->assertDontSee('data-conversion-proof-strip', false);
        $response->assertSee('data-footer-emphasis', false);
        $response->assertSee('data-floating-contact', false);
        $response->assertSee('Bạn cần làm website, sửa website hoặc nhờ xử lý một phần việc khó?');
        $response->assertSee('Nhận làm task lập trình nhanh');
        $response->assertSee('Xem dự án tiêu biểu');
        $response->assertSee('Hỗ trợ lập trình');
        $response->assertSee('Tổng quan dịch vụ');
        $response->assertSee('Nhận hướng tư vấn phù hợp');
        $response->assertSee('data-contact-cta', false);
        $response->assertDontSee('Công nghệ sử dụng');
    }
}
