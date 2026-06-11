<?php

namespace Tests\Feature;

use App\Models\OrderRequest;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class MarketplaceAdminTest extends TestCase
{
    use RefreshDatabase;

    public function test_admin_can_manage_marketplace_modules(): void
    {
        $this->withoutVite();

        $admin = User::factory()->create(['is_admin' => true]);

        $this->actingAs($admin)->get('/admin')->assertOk()->assertSee('Lead operations dashboard');
        $this->actingAs($admin)->post('/admin/marketplace/categories', [
            'name' => 'Landing page',
            'description' => 'Danh mục landing page',
            'is_active' => true,
        ])->assertRedirect();

        $this->assertDatabaseHas('template_categories', ['name' => 'Landing page']);

        $order = OrderRequest::query()->create([
            'customer_name' => 'Lan',
            'customer_phone' => '0909',
            'customer_group' => 'shop_owner',
            'need_type' => 'template',
        ]);

        $this->actingAs($admin)->patch("/admin/marketplace/orders/{$order->id}", [
            'status' => 'contacted',
            'priority' => 'normal',
            'lead_source' => 'website',
            'internal_note' => 'Đã gọi Zalo',
        ])->assertRedirect();

        $this->assertDatabaseHas('order_requests', [
            'id' => $order->id,
            'status' => 'contacted',
            'priority' => 'normal',
            'lead_source' => 'website',
            'internal_note' => 'Đã gọi Zalo',
        ]);
    }

    public function test_non_admin_cannot_access_marketplace_admin(): void
    {
        $user = User::factory()->create(['is_admin' => false]);

        $this->actingAs($user)->get('/admin/marketplace/templates')->assertForbidden();
    }
}
