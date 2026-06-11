<?php

namespace Tests\Feature;

use App\Models\ServiceOffering;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class ServiceCatalogTest extends TestCase
{
    use RefreshDatabase;

    public function test_admin_can_manage_service_catalog(): void
    {
        $this->withoutVite();

        $admin = User::factory()->create(['is_admin' => true]);

        $this->actingAs($admin)
            ->get('/admin/marketplace/services')
            ->assertOk()
            ->assertSee('Danh mục dịch vụ');

        $this->actingAs($admin)
            ->post('/admin/marketplace/services', [
                'name' => 'SEO tổng quan cho website shop',
                'service_group' => 'seo',
                'short_description' => 'Tối ưu title, nội dung và tốc độ tải trang.',
                'detail_description' => 'Audit, tối ưu on-page và cải thiện CTA.',
                'target_audiences' => "Shop nhỏ\nDoanh nghiệp nhỏ",
                'key_benefits' => "Audit nhanh\nTối ưu heading",
                'process_steps' => "Nhận link\nAudit\nBàn giao",
                'pricing_note' => 'Báo giá theo số trang.',
                'status' => 'published',
                'sort_order' => 3,
            ])
            ->assertRedirect();

        $service = ServiceOffering::query()->where('name', 'SEO tổng quan cho website shop')->firstOrFail();

        $this->assertDatabaseHas('service_offerings', [
            'id' => $service->id,
            'service_group' => 'seo',
            'status' => 'published',
        ]);

        $this->actingAs($admin)
            ->patch("/admin/marketplace/services/{$service->id}", [
                'status' => 'draft',
                'sort_order' => 9,
            ])
            ->assertRedirect();

        $this->assertDatabaseHas('service_offerings', [
            'id' => $service->id,
            'status' => 'draft',
            'sort_order' => 9,
        ]);
    }

    public function test_services_page_renders_published_service_offerings(): void
    {
        $this->withoutVite();

        ServiceOffering::query()->create([
            'name' => 'Fix giao diện landing page',
            'slug' => 'fix-giao-dien-landing-page',
            'service_group' => 'ui_fix',
            'short_description' => 'Sửa responsive và CTA.',
            'detail_description' => 'Chi tiết xử lý UI.',
            'target_audiences' => ['Shop nhỏ'],
            'key_benefits' => ['Sửa layout', 'Tối ưu mobile'],
            'process_steps' => ['Audit', 'Fix'],
            'pricing_note' => 'Theo block.',
            'status' => 'published',
            'sort_order' => 1,
        ]);

        ServiceOffering::query()->create([
            'name' => 'Draft service',
            'slug' => 'draft-service',
            'service_group' => 'website',
            'short_description' => 'Draft',
            'detail_description' => 'Draft',
            'status' => 'draft',
            'sort_order' => 2,
        ]);

        $this->get('/services')
            ->assertOk()
            ->assertSee('data-service-visual-grid', false)
            ->assertSee('data-service-visual-card', false)
            ->assertSee('Fix giao diện landing page')
            ->assertSee('Sửa Website')
            ->assertDontSee('Draft service');
    }

    public function test_non_admin_cannot_access_service_catalog_admin(): void
    {
        $user = User::factory()->create(['is_admin' => false]);

        $this->actingAs($user)->get('/admin/marketplace/services')->assertForbidden();
    }
}
