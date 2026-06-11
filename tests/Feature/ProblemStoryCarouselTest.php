<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class ProblemStoryCarouselTest extends TestCase
{
    use RefreshDatabase;

    public function test_homepage_uses_compact_landing_flow_without_separate_problem_grid(): void
    {
        $this->withoutVite();

        $response = $this->get('/');

        $response->assertOk();
        $response->assertSee('data-landing-section="hero"', false);
        $response->assertSee('data-landing-section="services"', false);
        $response->assertSee('data-contact-cta', false);
        $response->assertDontSee('data-landing-section="problems"', false);
        $response->assertDontSee('data-landing-section="trust"', false);
    }

    public function test_homepage_still_surfaces_core_customer_messages_in_hero_and_cta(): void
    {
        $this->withoutVite();

        $response = $this->get('/');

        $response->assertOk();
        $response->assertSee('Trang này dành cho shop nhỏ, cá nhân, sinh viên và khách cần người hỗ trợ làm web, tối ưu SEO, sửa giao diện hoặc xử lý phần việc lập trình rõ ràng, dễ theo dõi.');
        $response->assertSee('Khách mới cần thấy ngay bạn đang cung cấp dịch vụ gì và nên liên hệ thế nào.');
        $response->assertSee('Rõ dịch vụ, rõ cách liên hệ, rõ kết quả');
        $response->assertSee('Nếu bạn cần website mới, sửa web, tối ưu SEO, hỗ trợ đồ án hoặc nhờ xử lý một phần việc khó, đây là cách bắt đầu nhanh và rõ ràng nhất.');
    }

    public function test_frontend_assets_keep_reveal_and_reduced_motion_support(): void
    {
        $css = file_get_contents(resource_path('css/app.css'));
        $js = file_get_contents(resource_path('js/app.js'));

        $this->assertStringContainsString('IntersectionObserver', $js);
        $this->assertStringContainsString('[data-reveal]', $css);
        $this->assertStringContainsString('prefers-reduced-motion', $css);
    }
}
