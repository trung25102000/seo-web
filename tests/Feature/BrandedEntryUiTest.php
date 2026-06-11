<?php

namespace Tests\Feature;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class BrandedEntryUiTest extends TestCase
{
    use RefreshDatabase;

    public function test_guest_can_view_branded_landing_page(): void
    {
        $this->withoutVite();

        $response = $this->get('/');

        $response->assertOk();
        $response->assertSee('Bạn cần làm website, sửa website hoặc nhờ xử lý một phần việc khó?');
        $response->assertSee('Website mới hoặc landing page chốt lead');
        $response->assertSee('Sửa website, tối ưu SEO, cải thiện trải nghiệm liên hệ');
        $response->assertSee('Khách mới cần thấy ngay bạn đang cung cấp dịch vụ gì và nên liên hệ thế nào.');
        $response->assertSee('Dịch vụ chính');
        $response->assertSee('Tổng quan dịch vụ');
        $response->assertSee('Nhận tư vấn miễn phí');
        $response->assertSee('Xem dự án tiêu biểu');
        $response->assertSee('Mô tả ngắn nhu cầu để nhận hướng làm và mốc thời gian phù hợp.');
        $response->assertDontSee('Documentation');
        $response->assertDontSee('Laracasts');
        $response->assertDontSee('Laravel News');
    }

    public function test_authenticated_user_gets_workspace_cta_on_landing_page(): void
    {
        $this->withoutVite();

        $user = User::factory()->create();

        $response = $this->actingAs($user)->get('/');

        $response->assertOk();
        $response->assertSee('Trang chủ');
    }

    public function test_guest_can_view_branded_login_page(): void
    {
        $this->withoutVite();

        $response = $this->get('/login');

        $response->assertOk();
        $response->assertSee('Đăng nhập để tiếp tục vào khu vực quản trị.');
        $response->assertSee('Email');
        $response->assertSee('Mật khẩu');
        $response->assertSee('Ghi nhớ thiết bị này');
        $response->assertSee('Đăng nhập');
        $response->assertDontSee('AI video workspace');
        $response->assertDontSee('Sign in');
    }

    public function test_login_validation_errors_render_in_branded_form(): void
    {
        $this->withoutVite();

        $response = $this->followingRedirects()->from('/login')->post('/login', [
            'email' => 'missing@example.com',
            'password' => 'wrong-password',
        ]);

        $response->assertOk();
        $response->assertSee('Đăng nhập để tiếp tục vào khu vực quản trị.');
        $response->assertSee('Email hoặc mật khẩu chưa đúng.');
    }

    public function test_guest_can_view_branded_register_page(): void
    {
        $this->withoutVite();

        $response = $this->get('/register');

        $response->assertOk();
        $response->assertSee('Tạo tài khoản để theo dõi yêu cầu khi cần.');
        $response->assertSee('Web Template Studio');
        $response->assertSee('Tạo tài khoản');
        $response->assertSee('Đã có tài khoản?');
    }
}
