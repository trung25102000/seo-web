<?php

namespace Tests\Feature;

use App\Models\ContactMessage;
use App\Models\Customer;
use App\Models\GraduationProjectRequest;
use App\Models\OrderRequest;
use App\Models\QuoteRequest;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class MarketplaceRequestTest extends TestCase
{
    use RefreshDatabase;

    public function test_public_forms_store_leads_and_upsert_customers(): void
    {
        $this->post('/quote-requests', [
            'customer_name' => 'Lan Shop',
            'customer_phone' => '0909000001',
            'customer_email' => 'lan@example.com',
            'preferred_contact_channel' => 'zalo',
            'customer_group' => 'shop_owner',
            'service_type' => 'website',
            'budget_range' => '3m_to_7m',
            'deadline' => 'Trong 5 ngày',
            'technology_stack' => 'Laravel',
            'requirements' => 'Cần website giới thiệu và catalog.',
        ])->assertRedirect();

        $this->post('/orders', [
            'customer_name' => 'Lan Shop',
            'customer_phone' => '0909000001',
            'customer_email' => 'lan@example.com',
            'customer_group' => 'shop_owner',
            'need_type' => 'template',
            'customization_request' => 'Đổi màu theo brand.',
        ])->assertRedirect();

        $this->post('/graduation-project-requests', [
            'student_name' => 'Minh',
            'student_phone' => '0909000002',
            'student_email' => 'minh@example.com',
            'topic' => 'Website bán hàng Laravel',
            'need_report' => true,
            'need_database' => true,
            'need_installation_guide' => true,
        ])->assertRedirect();

        $this->post('/contact-messages', [
            'name' => 'Huy',
            'phone' => '0909000003',
            'channel' => 'zalo',
            'service_type' => 'landing_page',
            'preferred_contact_channel' => 'phone',
            'message' => 'Tư vấn landing page.',
        ])->assertRedirect();

        $this->assertDatabaseCount(Customer::class, 2);
        $this->assertDatabaseCount(QuoteRequest::class, 1);
        $this->assertDatabaseCount(OrderRequest::class, 1);
        $this->assertDatabaseCount(GraduationProjectRequest::class, 1);
        $this->assertDatabaseCount(ContactMessage::class, 1);
        $this->assertDatabaseHas(QuoteRequest::class, [
            'customer_name' => 'Lan Shop',
            'preferred_contact_channel' => 'zalo',
            'technology_stack' => 'Laravel',
        ]);
        $this->assertDatabaseHas(ContactMessage::class, [
            'name' => 'Huy',
            'service_type' => 'landing_page',
            'preferred_contact_channel' => 'phone',
        ]);
    }
}
