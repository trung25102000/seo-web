<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class LandingPageExperienceTest extends TestCase
{
    use RefreshDatabase;

    public function test_homepage_reads_like_a_customer_product_landing_page(): void
    {
        $this->withoutVite();

        $response = $this->get('/');

        $response->assertOk();
        $response->assertSee('data-landing-section="hero"', false);
        $response->assertSee('data-landing-section="services"', false);
        $response->assertSee('data-hero-cta-group', false);
        $response->assertSee('data-hero-trust-strip', false);
        $response->assertSee('data-contact-cta', false);
    }

    public function test_homepage_explains_customer_problems_and_service_value(): void
    {
        $this->withoutVite();

        $response = $this->get('/');

        $response->assertOk();
        $response->assertSee('Bạn cần làm website, sửa website hoặc nhờ xử lý một phần việc khó?');
        $response->assertSee('Trang này dành cho shop nhỏ, cá nhân, sinh viên và khách cần người hỗ trợ làm web, tối ưu SEO, sửa giao diện hoặc xử lý phần việc lập trình rõ ràng, dễ theo dõi.');
        $response->assertSee('Khách mới cần thấy ngay bạn đang cung cấp dịch vụ gì và nên liên hệ thế nào.');
        $response->assertSee('Rõ dịch vụ, rõ cách liên hệ, rõ kết quả');
        $response->assertSee('Nếu bạn cần website mới, sửa web, tối ưu SEO, hỗ trợ đồ án hoặc nhờ xử lý một phần việc khó, đây là cách bắt đầu nhanh và rõ ràng nhất.');
    }

    public function test_homepage_has_reveal_animation_markers_without_admin_dashboard_copy(): void
    {
        $this->withoutVite();

        $response = $this->get('/');

        $response->assertOk();
        $response->assertSee('data-reveal', false);
        $response->assertDontSee('Admin Dashboard');
        $response->assertDontSee('trang quản trị');
        $response->assertDontSee('Laravel News');
        $response->assertDontSee('Laracasts');
        $response->assertDontSee('Documentation');
    }
}
