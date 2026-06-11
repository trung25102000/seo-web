<?php

namespace Database\Seeders;

use App\Models\BlogPost;
use App\Models\DemoProject;
use App\Models\FaqItem;
use App\Models\ServiceOffering;
use App\Models\TemplateCategory;
use App\Models\Testimonial;
use App\Models\WebsiteTemplate;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class MarketplaceSeeder extends Seeder
{
    public function run(): void
    {
        foreach ([
            [
                'name' => 'SEO website cho web đã triển khai',
                'service_group' => 'seo',
                'short_description' => 'Tối ưu title, meta, nội dung, cấu trúc trang và trải nghiệm tải trang cho website đang hoạt động.',
                'detail_description' => 'Phù hợp khi website đã có sẵn nhưng cần được tối ưu nội dung, heading, liên kết nội bộ, tốc độ tải trang và điểm chạm chuyển đổi để thân thiện hơn với công cụ tìm kiếm và người dùng.',
                'target_audiences' => ['Chủ website nhỏ', 'Doanh nghiệp nhỏ', 'Khách đã có web cần tối ưu'],
                'key_benefits' => ['Audit nhanh lỗi SEO on-page', 'Tối ưu cấu trúc nội dung và CTA', 'Rà soát tốc độ tải trang và trải nghiệm mobile'],
                'process_steps' => ['Nhận link website và mục tiêu', 'Audit nhanh các vấn đề SEO chính', 'Tối ưu và bàn giao checklist tiếp tục'],
                'pricing_note' => 'Báo giá theo số lượng trang, mức độ tối ưu cần làm và tình trạng hiện tại của website.',
            ],
            [
                'name' => 'Fix và chỉnh sửa giao diện website',
                'service_group' => 'ui_fix',
                'short_description' => 'Sửa lỗi layout, làm đẹp lại UI, tối ưu responsive và cải thiện trải nghiệm người dùng trên website hiện có.',
                'detail_description' => 'Phù hợp cho khách đã có website nhưng giao diện cũ, vỡ mobile, CTA khó bấm, section rối hoặc cần chỉnh nhanh một số block quan trọng để tăng độ tin cậy.',
                'target_audiences' => ['Cá nhân có website cũ', 'Shop nhỏ', 'Doanh nghiệp nhỏ'],
                'key_benefits' => ['Sửa lỗi giao diện nhanh', 'Cải thiện UI/UX theo use case thật', 'Tối ưu mobile, tablet và desktop'],
                'process_steps' => ['Xem website và vấn đề hiện tại', 'Chốt phạm vi block cần sửa', 'Triển khai và nghiệm thu theo màn hình thực tế'],
                'pricing_note' => 'Có thể nhận theo block nhỏ, theo trang hoặc theo scope redesign rõ ràng.',
            ],
            [
                'name' => 'Thiết kế website và landing page theo yêu cầu',
                'service_group' => 'website',
                'short_description' => 'Xây dựng website giới thiệu, website bán hàng cơ bản hoặc landing page chốt lead cho cá nhân và shop nhỏ.',
                'detail_description' => 'Dịch vụ tập trung vào website dễ hiểu, dễ vận hành, có CTA rõ ràng, có demo trước khi bàn giao và phù hợp cho nhu cầu triển khai nhanh hoặc làm mới thương hiệu online.',
                'target_audiences' => ['Cá nhân cần website giới thiệu', 'Shop nhỏ cần landing page', 'Doanh nghiệp nhỏ cần web cơ bản'],
                'key_benefits' => ['Thiết kế modern, mobile-first', 'Có form lead và nút liên hệ nhanh', 'Hỗ trợ deploy hoặc bàn giao source sau khi hoàn tất'],
                'process_steps' => ['Nhận nhu cầu và tham khảo mẫu', 'Chốt scope/gói phù hợp', 'Triển khai demo rồi chỉnh sửa trước khi bàn giao'],
                'pricing_note' => 'Có gói tham khảo cho website cơ bản, landing page và website theo yêu cầu riêng.',
            ],
            [
                'name' => 'Hỗ trợ đồ án sinh viên về web, app và database',
                'service_group' => 'student_support',
                'short_description' => 'Hỗ trợ sinh viên lên ý tưởng, xây source, API, database, báo cáo và hướng dẫn cài đặt cho đồ án.',
                'detail_description' => 'Phù hợp cho sinh viên cần hoàn thiện đồ án web/app, bổ sung tài liệu, chỉnh lỗi source, làm rõ flow chức năng và có demo để bảo vệ tốt hơn.',
                'target_audiences' => ['Sinh viên CNTT', 'Sinh viên cần hỗ trợ Laravel/API/database'],
                'key_benefits' => ['Có source, database và tài liệu', 'Hỗ trợ sửa bug và hoàn thiện flow', 'Giải thích chức năng để dễ trình bày khi bảo vệ'],
                'process_steps' => ['Trao đổi đề tài và deadline', 'Rà scope cần hỗ trợ', 'Triển khai source/tài liệu/demo theo gói phù hợp'],
                'pricing_note' => 'Báo giá theo mức độ hoàn thiện hiện tại, số module cần hỗ trợ và deadline.',
            ],
            [
                'name' => 'Nhận làm task lập trình nhanh',
                'service_group' => 'coding_task',
                'short_description' => 'Nhận fix bug, viết API, làm giao diện, chỉnh database hoặc phát triển chức năng nhỏ cho dự án web/app.',
                'detail_description' => 'Dành cho khách cần xử lý nhanh task lập trình cụ thể trên PHP, Laravel, React, Next.js, JavaScript, MySQL và các công nghệ web phổ biến.',
                'target_audiences' => ['Khách cần fix bug gấp', 'Team nhỏ thiếu bandwidth', 'Sinh viên cần hỗ trợ task code'],
                'key_benefits' => ['Scope rõ, xử lý nhanh', 'Có thể nhận task nhỏ độc lập', 'Tập trung vào kết quả chạy được và dễ maintain'],
                'process_steps' => ['Nhận mô tả bug hoặc task', 'Xác nhận scope và công nghệ', 'Triển khai, test và bàn giao hướng dẫn ngắn'],
                'pricing_note' => 'Có thể báo theo task nhỏ, theo giờ hoặc theo scope tính năng.',
            ],
        ] as $index => $service) {
            ServiceOffering::query()->updateOrCreate(
                ['slug' => Str::slug($service['name'])],
                $service + ['status' => 'published', 'sort_order' => $index + 1]
            );
        }

        $categories = collect(['Shop thời trang', 'Mỹ phẩm', 'Quán ăn', 'Landing page', 'Đồ án Laravel'])
            ->mapWithKeys(fn ($name) => [$name => TemplateCategory::query()->firstOrCreate(
                ['slug' => Str::slug($name)],
                ['name' => $name, 'description' => "Mẫu web cho {$name}", 'is_active' => true]
            )]);

        foreach ([
            ['Web shop thời trang mini', 'shop_owner', 'website', 'Shop thời trang', 2500000],
            ['Landing page mỹ phẩm chốt lead', 'online_seller', 'landing_page', 'Landing page', 1800000],
            ['Catalog quán ăn đặt món Zalo', 'shop_owner', 'catalog', 'Quán ăn', 2200000],
        ] as [$name, $audience, $type, $category, $price]) {
            WebsiteTemplate::query()->firstOrCreate(
                ['slug' => Str::slug($name)],
                [
                    'template_category_id' => $categories[$category]->id,
                    'name' => $name,
                    'audience_type' => $audience,
                    'template_type' => $type,
                    'summary' => 'Giao diện trẻ trung, dễ chỉnh sửa, tối ưu mobile và CTA rõ.',
                    'description' => 'Mẫu phù hợp triển khai nhanh cho shop nhỏ và cá nhân kinh doanh online.',
                    'price' => $price,
                    'demo_url' => 'https://example.com/demo',
                    'status' => 'active',
                ]
            );
        }

        $fashionTemplate = WebsiteTemplate::query()->where('slug', Str::slug('Web shop thời trang mini'))->first();
        $landingTemplate = WebsiteTemplate::query()->where('slug', Str::slug('Landing page mỹ phẩm chốt lead'))->first();

        foreach ([
            [
                'slug' => 'portfolio-shop-thoi-trang-mini',
                'name' => 'Portfolio website shop thời trang mini',
                'project_type' => 'website',
                'website_template_id' => $fashionTemplate?->id,
                'client_problem' => 'Shop nhỏ chưa có website riêng, khách chỉ xem sản phẩm qua bài đăng rời rạc và khó tin tưởng thương hiệu.',
                'implemented_solution' => 'Triển khai website giới thiệu/catalog với CTA Zalo rõ ràng, bố cục mobile-first và luồng xem sản phẩm nhanh.',
                'tech_stack' => ['Laravel', 'Blade', 'TailwindCSS', 'SQLite'],
                'role_summary' => 'Thiết kế giao diện, dựng cấu trúc nội dung, tối ưu CTA và chuẩn bị luồng bàn giao dễ vận hành.',
                'outcome_summary' => 'Khách có một điểm chạm chuyên nghiệp để gửi ads, chốt Zalo và giới thiệu thương hiệu ổn định hơn.',
                'demo_url' => 'https://example.com/demo-shop',
            ],
            [
                'slug' => 'portfolio-landing-page-my-pham',
                'name' => 'Portfolio landing page mỹ phẩm chốt lead',
                'project_type' => 'landing_page',
                'website_template_id' => $landingTemplate?->id,
                'client_problem' => 'Landing page quảng cáo cũ thiếu trust block và form lead chưa đủ rõ để khách để lại thông tin.',
                'implemented_solution' => 'Thiết kế lại hero, problem-solution, proof blocks và form tư vấn với CTA nổi bật cho mobile.',
                'tech_stack' => ['Laravel', 'Blade', 'TailwindCSS', 'Form funnel'],
                'role_summary' => 'Phân tích điểm nghẽn chuyển đổi, thiết kế landing page mới và tối ưu flow nhận lead.',
                'outcome_summary' => 'Tăng khả năng khách hiểu offer ngay và dễ bấm để lại nhu cầu tư vấn hơn trên mobile.',
                'demo_url' => 'https://example.com/demo-landing',
            ],
        ] as $demo) {
            DemoProject::query()->updateOrCreate(
                ['slug' => $demo['slug']],
                $demo + ['status' => 'published', 'is_active' => true]
            );
        }

        foreach ([
            ['shop_owner', 'Website shop nhỏ có cần thanh toán online không?', 'MVP có thể chốt qua Zalo trước, thanh toán online có thể thêm ở phase sau.'],
            ['online_seller', 'Landing page có dùng để chạy quảng cáo ngay không?', 'Có, form lead và CTA được đặt rõ để dùng cho chiến dịch quảng cáo.'],
            ['student', 'Source đồ án có kèm database và báo cáo không?', 'Có thể chọn kèm database mẫu, báo cáo hướng dẫn và tài liệu chạy project.'],
        ] as [$audience, $question, $answer]) {
            FaqItem::query()->firstOrCreate(
                ['question' => $question],
                ['audience_type' => $audience, 'answer' => $answer, 'is_active' => true]
            );
        }

        BlogPost::query()->firstOrCreate(
            ['slug' => 'chon-website-cho-shop-nho'],
            [
                'title' => 'Cách chọn website cho shop nhỏ',
                'audience_type' => 'shop_owner',
                'excerpt' => 'Các phần cần có để shop nhỏ bán hàng rõ ràng hơn.',
                'content' => 'Một website shop nhỏ nên có catalog, thông tin liên hệ, CTA Zalo và nội dung dễ cập nhật.',
                'status' => 'published',
                'published_at' => now(),
            ]
        );

        foreach ([
            ['Lan Shop', 'LS', 'shop_owner', 'website', 'Website nhìn chuyên nghiệp hơn hẳn, khách xem catalog dễ và nhắn Zalo nhanh hơn trước.', 5, 'Bàn giao rõ ràng'],
            ['Minh IT', 'MI', 'student', 'student_support', 'Mình nhận được source, database và hướng dẫn chạy nên bảo vệ đồ án tự tin hơn nhiều.', 5, 'Có source + tài liệu'],
            ['Huy Ads', 'HA', 'online_seller', 'landing_page', 'Landing page mới rõ offer hơn và khách dễ để lại thông tin tư vấn hơn trên mobile.', 5, 'CTA rõ và dễ chốt lead'],
        ] as $index => [$name, $avatar, $audience, $service, $content, $rating, $tag]) {
            Testimonial::query()->updateOrCreate(
                ['name' => $name],
                [
                    'avatar_label' => $avatar,
                    'audience_type' => $audience,
                    'service_type' => $service,
                    'content' => $content,
                    'rating' => $rating,
                    'trust_tag' => $tag,
                    'status' => 'published',
                    'sort_order' => $index + 1,
                ]
            );
        }
    }
}
