<?php

namespace Tests\Feature;

use App\Models\ServiceOffering;
use App\Models\Testimonial;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class FeedbackSocialProofTest extends TestCase
{
    use RefreshDatabase;

    public function test_public_pages_show_only_published_feedback(): void
    {
        $this->withoutVite();

        ServiceOffering::query()->create([
            'name' => 'SEO website cho web đã triển khai',
            'slug' => 'seo-website-cho-web-da-trien-khai',
            'service_group' => 'seo',
            'short_description' => 'SEO website',
            'detail_description' => 'Chi tiết',
            'status' => 'published',
            'sort_order' => 1,
        ]);

        Testimonial::query()->create([
            'name' => 'Lan Shop',
            'avatar_label' => 'LS',
            'audience_type' => 'shop_owner',
            'service_type' => 'seo',
            'content' => 'SEO và CTA đã rõ hơn nhiều.',
            'rating' => 5,
            'trust_tag' => 'Lead tốt hơn',
            'status' => 'published',
            'sort_order' => 1,
        ]);

        Testimonial::query()->create([
            'name' => 'Draft testimonial',
            'avatar_label' => 'DT',
            'audience_type' => 'shop_owner',
            'service_type' => 'seo',
            'content' => 'Draft',
            'rating' => 4,
            'status' => 'draft',
            'sort_order' => 2,
        ]);

        $this->get('/')
            ->assertOk()
            ->assertDontSee('Draft testimonial')
            ->assertDontSee('data-tech-marquee', false)
            ->assertSee('data-floating-contact', false);

        $this->get('/services/seo-website-cho-web-da-trien-khai')
            ->assertOk()
            ->assertSee('Lan Shop')
            ->assertDontSee('Draft testimonial');
    }

    public function test_admin_can_manage_feedback_module(): void
    {
        $this->withoutVite();

        $admin = User::factory()->create(['is_admin' => true]);

        $this->actingAs($admin)->get('/admin/marketplace/testimonials')
            ->assertOk()
            ->assertSee('Feedback khách hàng');

        $this->actingAs($admin)->post('/admin/marketplace/testimonials', [
            'name' => 'Khách SEO',
            'avatar_label' => 'KS',
            'audience_type' => 'shop_owner',
            'service_type' => 'seo',
            'content' => 'Rõ phạm vi và hỗ trợ tốt.',
            'rating' => 5,
            'trust_tag' => 'Rõ phạm vi',
            'status' => 'published',
            'sort_order' => 1,
        ])->assertRedirect();

        $testimonial = Testimonial::query()->where('name', 'Khách SEO')->firstOrFail();

        $this->actingAs($admin)->patch("/admin/marketplace/testimonials/{$testimonial->id}", [
            'status' => 'draft',
            'sort_order' => 9,
        ])->assertRedirect();

        $this->assertDatabaseHas('testimonials', [
            'id' => $testimonial->id,
            'status' => 'draft',
            'sort_order' => 9,
        ]);
    }
}
