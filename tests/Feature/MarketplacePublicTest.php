<?php

namespace Tests\Feature;

use App\Models\BlogPost;
use App\Models\FaqItem;
use App\Models\ServiceOffering;
use App\Models\TemplateCategory;
use App\Models\WebsiteTemplate;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class MarketplacePublicTest extends TestCase
{
    use RefreshDatabase;

    public function test_public_marketplace_pages_are_rendered(): void
    {
        $this->withoutVite();

        $category = TemplateCategory::query()->create(['name' => 'Shop nhỏ', 'slug' => 'shop-nho']);
        WebsiteTemplate::query()->create([
            'template_category_id' => $category->id,
            'name' => 'Mẫu shop mỹ phẩm',
            'slug' => 'mau-shop-my-pham',
            'summary' => 'Mẫu đẹp cho shop nhỏ',
            'price' => 2000000,
            'status' => 'active',
        ]);
        ServiceOffering::query()->create([
            'name' => 'Fix giao diện website',
            'slug' => 'fix-giao-dien-website',
            'service_group' => 'ui_fix',
            'short_description' => 'Sửa giao diện và tối ưu responsive.',
            'detail_description' => 'Chi tiết sửa giao diện.',
            'key_benefits' => ['Sửa layout', 'Tối ưu mobile'],
            'status' => 'published',
            'sort_order' => 1,
        ]);
        BlogPost::query()->create([
            'title' => 'SEO cho shop nhỏ',
            'slug' => 'seo-cho-shop-nho',
            'content' => 'Nội dung SEO',
            'status' => 'published',
            'published_at' => now(),
        ]);
        FaqItem::query()->create([
            'audience_type' => 'shop_owner',
            'question' => 'Có demo không?',
            'answer' => 'Có demo rõ ràng.',
        ]);

        $this->get('/')->assertOk()->assertSee('Bạn cần làm website, sửa website hoặc nhờ xử lý một phần việc khó?');
        $this->get('/services')->assertOk()->assertSee('Chọn đúng dịch vụ bạn đang cần để bắt đầu nhanh hơn.')->assertSee('Fix giao diện website');
        $this->get('/templates')->assertOk()->assertSee('Mẫu shop mỹ phẩm');
        $this->get('/templates/mau-shop-my-pham')->assertOk()->assertSee('Đặt mua mẫu này');
        $this->get('/pricing/shop')->assertNotFound();
        $this->get('/source-code')->assertNotFound();
        $this->get('/blog')->assertOk()->assertSee('SEO cho shop nhỏ');
        $this->get('/sitemap.xml')->assertOk()->assertSee('/templates/mau-shop-my-pham');
        $this->get('/robots.txt')->assertOk()->assertSee('Sitemap:');
    }
}
