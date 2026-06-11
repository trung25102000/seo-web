<?php

namespace Tests\Feature;

use App\Models\BlogPost;
use App\Models\ServiceOffering;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class ServiceDetailPagesTest extends TestCase
{
    use RefreshDatabase;

    public function test_services_pages_render_published_service_details(): void
    {
        $this->withoutVite();

        $service = ServiceOffering::query()->create([
            'name' => 'Thiết kế website và landing page theo yêu cầu',
            'slug' => 'thiet-ke-website-va-landing-page-theo-yeu-cau',
            'service_group' => 'website',
            'short_description' => 'Làm website giới thiệu, bán hàng cơ bản và landing page chốt lead.',
            'detail_description' => 'Dịch vụ phù hợp cho cá nhân, shop nhỏ và doanh nghiệp nhỏ cần một điểm chạm online chuyên nghiệp.',
            'target_audiences' => ['Cá nhân', 'Shop nhỏ'],
            'key_benefits' => ['Có demo trước', 'Tối ưu mobile'],
            'process_steps' => ['Nhận nhu cầu', 'Chốt scope', 'Bàn giao'],
            'pricing_note' => 'Báo giá theo số trang và mức độ custom.',
            'status' => 'published',
            'sort_order' => 1,
        ]);

        BlogPost::query()->create([
            'title' => 'Checklist landing page chốt lead',
            'slug' => 'checklist-landing-page-chot-lead',
            'excerpt' => 'Các block quan trọng cho landing page.',
            'content' => 'Nội dung chi tiết.',
            'status' => 'published',
            'published_at' => now(),
        ]);

        $this->get('/services')
            ->assertOk()
            ->assertSee($service->name)
            ->assertSee(route('services.show', $service), false);

        $this->get("/services/{$service->slug}")
            ->assertOk()
            ->assertSee('Vấn đề khách thường gặp')
            ->assertSee('Bạn sẽ được hỗ trợ những gì')
            ->assertSee('Nền tảng hoặc công cụ liên quan')
            ->assertSee('Checklist landing page chốt lead')
            ->assertSee('Nhận tư vấn cho dịch vụ này')
            ->assertDontSee('Xem giá tham khảo');
    }

    public function test_unpublished_service_detail_is_not_public(): void
    {
        $this->withoutVite();

        $service = ServiceOffering::query()->create([
            'name' => 'Draft coding support',
            'slug' => 'draft-coding-support',
            'service_group' => 'coding_task',
            'short_description' => 'Draft',
            'detail_description' => 'Draft detail',
            'status' => 'draft',
            'sort_order' => 1,
        ]);

        $this->get("/services/{$service->slug}")->assertNotFound();
    }
}
