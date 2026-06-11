<?php

namespace Tests\Feature;

use App\Models\BlogPost;
use App\Models\ServiceOffering;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class TechnicalSeoTest extends TestCase
{
    use RefreshDatabase;

    public function test_public_pages_render_canonical_meta_and_schema_markup(): void
    {
        $this->withoutVite();

        $service = ServiceOffering::query()->create([
            'name' => 'SEO website tổng thể',
            'slug' => 'seo-website-tong-the',
            'service_group' => 'seo',
            'short_description' => 'Tối ưu SEO on-page và cấu trúc trang.',
            'detail_description' => 'Chi tiết dịch vụ SEO.',
            'status' => 'published',
            'sort_order' => 1,
        ]);

        $post = BlogPost::query()->create([
            'title' => 'Checklist SEO cho website dịch vụ',
            'slug' => 'checklist-seo-cho-website-dich-vu',
            'content_pillar' => 'seo',
            'service_group' => 'seo',
            'excerpt' => 'Các bước tối ưu title, meta và internal link.',
            'content' => 'Nội dung SEO thực chiến.',
            'status' => 'published',
            'published_at' => now(),
        ]);

        $this->get('/')
            ->assertOk()
            ->assertSee('<meta name="robots" content="index,follow">', false)
            ->assertSee('<link rel="canonical" href="'.route('home').'">', false)
            ->assertSee('application/ld+json', false)
            ->assertSee('ProfessionalService', false);

        $this->get('/services')
            ->assertOk()
            ->assertSee('<link rel="canonical" href="'.route('services').'">', false)
            ->assertSee('ItemList', false);

        $this->get("/services/{$service->slug}")
            ->assertOk()
            ->assertSee('<link rel="canonical" href="'.route('services.show', $service).'">', false)
            ->assertSee('Service', false);

        $this->get("/blog/{$post->slug}")
            ->assertOk()
            ->assertSee('<link rel="canonical" href="'.route('blog.show', $post).'">', false)
            ->assertSee('Article', false);
    }

    public function test_robots_and_sitemap_stay_publicly_accessible(): void
    {
        $this->withoutVite();

        $this->get('/robots.txt')
            ->assertOk()
            ->assertSee('User-agent', false)
            ->assertSee('Sitemap:', false);

        $this->get('/sitemap.xml')
            ->assertOk()
            ->assertSee('<?xml version="1.0" encoding="UTF-8"?>', false);
    }
}
