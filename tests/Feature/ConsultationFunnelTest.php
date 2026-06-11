<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class ConsultationFunnelTest extends TestCase
{
    use RefreshDatabase;

    public function test_quote_request_requires_core_consultation_fields(): void
    {
        $response = $this->from('/')->post('/quote-requests', [
            'customer_name' => 'Lan',
            'customer_phone' => '0909000001',
            'customer_group' => 'shop_owner',
            'service_type' => 'seo',
            'requirements' => 'Cần tối ưu SEO.',
        ]);

        $response->assertRedirect('/');
        $response->assertSessionHasErrors(['preferred_contact_channel']);
    }

    public function test_contact_message_accepts_service_context(): void
    {
        $response = $this->post('/contact-messages', [
            'name' => 'Khách hỏi nhanh',
            'email' => 'quick@example.com',
            'channel' => 'website',
            'service_type' => 'coding_task',
            'preferred_contact_channel' => 'email',
            'message' => 'Cần fix nhanh một API Laravel.',
        ]);

        $response->assertRedirect();
        $response->assertSessionHas('status', 'Tin nhắn của bạn đã được gửi. Cảm ơn bạn đã liên hệ.');
    }

    public function test_homepage_contact_cta_explains_response_timing_and_scope(): void
    {
        $this->withoutVite();

        $this->get('/')
            ->assertOk()
            ->assertSee('data-contact-proof-grid', false)
            ->assertSee('15-60 phút')
            ->assertSee('Nhận hướng tư vấn phù hợp');
    }
}
