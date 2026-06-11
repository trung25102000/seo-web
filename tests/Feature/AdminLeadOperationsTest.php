<?php

namespace Tests\Feature;

use App\Models\ContactMessage;
use App\Models\Customer;
use App\Models\GraduationProjectRequest;
use App\Models\OrderRequest;
use App\Models\QuoteRequest;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class AdminLeadOperationsTest extends TestCase
{
    use RefreshDatabase;

    public function test_admin_can_filter_and_update_lead_modules(): void
    {
        $this->withoutVite();

        $admin = User::factory()->create(['is_admin' => true]);
        $customer = Customer::query()->create([
            'name' => 'Khach test',
            'email' => 'lead@example.com',
            'phone' => '0909000000',
            'customer_group' => 'shop_owner',
        ]);

        $order = OrderRequest::query()->create([
            'customer_id' => $customer->id,
            'customer_name' => 'Order Lead',
            'customer_email' => 'order@example.com',
            'customer_phone' => '0909111111',
            'customer_group' => 'shop_owner',
            'need_type' => 'landing_page',
            'lead_source' => 'website',
            'priority' => 'normal',
            'status' => 'new',
        ]);

        $quote = QuoteRequest::query()->create([
            'customer_id' => $customer->id,
            'customer_name' => 'Quote Lead',
            'customer_email' => 'quote@example.com',
            'customer_phone' => '0909222222',
            'preferred_contact_channel' => 'zalo',
            'customer_group' => 'shop_owner',
            'service_type' => 'seo',
            'lead_source' => 'website',
            'budget_range' => '3m_to_7m',
            'deadline' => '3 ngày',
            'technology_stack' => 'Laravel',
            'requirements' => 'Can toi uu SEO tong the',
            'priority' => 'normal',
            'status' => 'new',
        ]);

        $graduation = GraduationProjectRequest::query()->create([
            'customer_id' => $customer->id,
            'student_name' => 'Sinh vien A',
            'student_email' => 'student@example.com',
            'student_phone' => '0909333333',
            'school' => 'Dai hoc CNTT',
            'major' => 'KTPM',
            'topic' => 'Website quan ly',
            'lead_source' => 'website',
            'priority' => 'normal',
            'status' => 'new',
        ]);

        $contact = ContactMessage::query()->create([
            'name' => 'Contact Lead',
            'email' => 'contact@example.com',
            'phone' => '0909444444',
            'channel' => 'website',
            'service_type' => 'coding_task',
            'preferred_contact_channel' => 'email',
            'message' => 'Can fix bug gap',
            'priority' => 'normal',
            'status' => 'new',
        ]);

        $this->actingAs($admin)
            ->get('/admin/marketplace/quotes?status=new&service_type=seo')
            ->assertOk()
            ->assertSee('Quote Lead')
            ->assertDontSee('Order Lead');

        $this->actingAs($admin)
            ->patch("/admin/marketplace/orders/{$order->id}", [
                'status' => 'contacted',
                'priority' => 'high',
                'lead_source' => 'zalo',
                'internal_note' => 'Da goi Zalo va hen bao gia',
            ])->assertRedirect();

        $this->actingAs($admin)
            ->patch("/admin/marketplace/quotes/{$quote->id}", [
                'status' => 'in_progress',
                'priority' => 'urgent',
                'lead_source' => 'facebook',
                'admin_note' => 'Can chot scope SEO audit',
            ])->assertRedirect();

        $this->actingAs($admin)
            ->patch("/admin/marketplace/graduation-requests/{$graduation->id}", [
                'status' => 'contacted',
                'priority' => 'high',
                'lead_source' => 'referral',
                'admin_note' => 'Hen demo database toi nay',
            ])->assertRedirect();

        $this->actingAs($admin)
            ->patch("/admin/marketplace/contacts/{$contact->id}", [
                'status' => 'completed',
                'priority' => 'low',
                'admin_note' => 'Da tra loi qua email',
            ])->assertRedirect();

        $this->actingAs($admin)
            ->patch("/admin/marketplace/customers/{$customer->id}", [
                'note' => 'Khach tiem nang cho SEO va task code ngan',
            ])->assertRedirect();

        $this->assertDatabaseHas('order_requests', [
            'id' => $order->id,
            'status' => 'contacted',
            'priority' => 'high',
            'lead_source' => 'zalo',
            'internal_note' => 'Da goi Zalo va hen bao gia',
        ]);

        $this->assertDatabaseHas('quote_requests', [
            'id' => $quote->id,
            'status' => 'in_progress',
            'priority' => 'urgent',
            'lead_source' => 'facebook',
            'admin_note' => 'Can chot scope SEO audit',
        ]);

        $this->assertDatabaseHas('graduation_project_requests', [
            'id' => $graduation->id,
            'status' => 'contacted',
            'priority' => 'high',
            'lead_source' => 'referral',
            'admin_note' => 'Hen demo database toi nay',
        ]);

        $this->assertDatabaseHas('contact_messages', [
            'id' => $contact->id,
            'status' => 'completed',
            'priority' => 'low',
            'admin_note' => 'Da tra loi qua email',
        ]);

        $this->assertDatabaseHas('customers', [
            'id' => $customer->id,
            'note' => 'Khach tiem nang cho SEO va task code ngan',
        ]);
    }

    public function test_non_admin_cannot_update_lead_operations(): void
    {
        $customer = Customer::query()->create([
            'name' => 'Khach test',
        ]);
        $quote = QuoteRequest::query()->create([
            'customer_id' => $customer->id,
            'customer_name' => 'Quote Lead',
            'customer_phone' => '0909222222',
            'preferred_contact_channel' => 'zalo',
            'customer_group' => 'shop_owner',
            'service_type' => 'seo',
            'requirements' => 'Can toi uu SEO tong the',
        ]);
        $user = User::factory()->create(['is_admin' => false]);

        $this->actingAs($user)
            ->patch("/admin/marketplace/quotes/{$quote->id}", [
                'status' => 'completed',
                'priority' => 'high',
                'lead_source' => 'zalo',
            ])
            ->assertForbidden();
    }
}
