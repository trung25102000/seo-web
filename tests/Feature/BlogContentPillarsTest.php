<?php

namespace Tests\Feature;

use App\Models\BlogPost;
use App\Models\ServiceOffering;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class BlogContentPillarsTest extends TestCase
{
    use RefreshDatabase;

    public function test_blog_index_groups_content_by_pillar_and_links_to_services(): void
    {
        $this->withoutVite();

        ServiceOffering::query()->create([
            'name' => 'SEO website tổng thể',
            'slug' => 'seo-website-tong-the',
            'service_group' => 'seo',
            'short_description' => 'Tối ưu on-page và cấu trúc website.',
            'detail_description' => 'Chi tiết dịch vụ SEO.',
            'status' => 'published',
            'sort_order' => 1,
        ]);

        BlogPost::query()->create([
            'title' => 'Checklist SEO on-page cho website dịch vụ',
            'slug' => 'checklist-seo-on-page-cho-website-dich-vu',
            'content_pillar' => 'seo',
            'service_group' => 'seo',
            'excerpt' => 'Các bước tối ưu title, meta, heading và internal link.',
            'content' => 'Nội dung bài viết SEO.',
            'status' => 'published',
            'published_at' => now(),
        ]);

        $this->get('/blog?pillar=seo')
            ->assertOk()
            ->assertSee('SEO website')
            ->assertSee('Checklist SEO on-page cho website dịch vụ')
            ->assertSee('Xem dịch vụ liên quan');
    }

    public function test_blog_detail_renders_related_posts_and_consultation_cta(): void
    {
        $this->withoutVite();

        ServiceOffering::query()->create([
            'name' => 'Fix giao diện và tối ưu chuyển đổi',
            'slug' => 'fix-giao-dien-va-toi-uu-chuyen-doi',
            'service_group' => 'ui_fix',
            'short_description' => 'Sửa responsive, CTA và trust block.',
            'detail_description' => 'Chi tiết dịch vụ fix UI.',
            'status' => 'published',
            'sort_order' => 1,
        ]);

        BlogPost::query()->create([
            'title' => '5 lỗi UI làm landing page rớt chuyển đổi',
            'slug' => '5-loi-ui-lam-landing-page-rot-chuyen-doi',
            'content_pillar' => 'ui_fix',
            'service_group' => 'ui_fix',
            'excerpt' => 'Những lỗi UI/UX phổ biến cần xử lý.',
            'content' => 'Nội dung chính của bài viết.',
            'status' => 'published',
            'published_at' => now(),
        ]);

        BlogPost::query()->create([
            'title' => 'Checklist sửa responsive cho mobile',
            'slug' => 'checklist-sua-responsive-cho-mobile',
            'content_pillar' => 'ui_fix',
            'service_group' => 'ui_fix',
            'excerpt' => 'Cách rà soát layout mobile.',
            'content' => 'Nội dung liên quan.',
            'status' => 'published',
            'published_at' => now()->subDay(),
        ]);

        $this->get('/blog/5-loi-ui-lam-landing-page-rot-chuyen-doi')
            ->assertOk()
            ->assertSee('Dịch vụ liên quan')
            ->assertSee('Checklist sửa responsive cho mobile')
            ->assertSee('Nhận tư vấn từ bài viết này')
            ->assertSee('Xem dự án đã thực hiện');
    }
}
