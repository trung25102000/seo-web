<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreContactMessageRequest;
use App\Http\Requests\StoreGraduationProjectRequestRequest;
use App\Http\Requests\StoreOrderRequestRequest;
use App\Http\Requests\StoreQuoteRequestRequest;
use App\Models\BlogPost;
use App\Models\ContactMessage;
use App\Models\DemoProject;
use App\Models\FaqItem;
use App\Models\GraduationProjectRequest;
use App\Models\OrderRequest;
use App\Models\QuoteRequest;
use App\Models\ServiceOffering;
use App\Models\TemplateCategory;
use App\Models\Testimonial;
use App\Models\WebsiteTemplate;
use App\Services\CustomerUpsertService;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Schema;
use Illuminate\View\View;

class MarketplaceController extends Controller
{
    public function home(): View
    {
        return view('marketplace.home', [
            'featuredServices' => Schema::hasTable('service_offerings') ? ServiceOffering::query()->where('status', 'published')->orderBy('sort_order')->limit(5)->get() : collect(),
            'featuredTemplates' => Schema::hasTable('website_templates') ? WebsiteTemplate::query()->where('status', 'active')->latest()->limit(6)->get() : collect(),
            'featuredDemos' => Schema::hasTable('demo_projects') ? DemoProject::query()->where('is_active', true)->where('project_type', '!=', 'source_code')->with('websiteTemplate')->latest()->limit(3)->get() : collect(),
            'posts' => Schema::hasTable('blog_posts') ? BlogPost::query()->where('status', 'published')->latest('published_at')->limit(3)->get() : collect(),
            'faqs' => Schema::hasTable('faq_items') ? FaqItem::query()->where('is_active', true)->orderBy('sort_order')->limit(6)->get() : collect(),
            'testimonials' => Schema::hasTable('testimonials') ? Testimonial::query()->where('status', 'published')->orderBy('sort_order')->limit(6)->get() : collect(),
        ]);
    }

    public function services(): View
    {
        return view('marketplace.services', [
            'serviceOfferings' => ServiceOffering::query()->where('status', 'published')->orderBy('sort_order')->get(),
            'faqs' => FaqItem::query()->where('is_active', true)->orderBy('sort_order')->get(),
        ]);
    }

    public function serviceDetail(ServiceOffering $serviceOffering): View
    {
        abort_unless($serviceOffering->status === 'published', 404);

        $blueprint = $this->serviceBlueprints()[$serviceOffering->service_group] ?? [
            'problems' => [],
            'scope' => [],
            'technologies' => [],
            'timeline' => 'Tùy theo phạm vi cụ thể của từng yêu cầu.',
            'blog_cta' => 'Xem bài chia sẻ liên quan',
        ];

        return view('marketplace.services.show', [
            'service' => $serviceOffering,
            'blueprint' => $blueprint,
            'relatedServices' => ServiceOffering::query()
                ->where('status', 'published')
                ->whereKeyNot($serviceOffering->getKey())
                ->orderBy('sort_order')
                ->limit(3)
                ->get(),
            'posts' => BlogPost::query()->where('status', 'published')->latest('published_at')->limit(3)->get(),
            'testimonials' => Testimonial::query()
                ->where('status', 'published')
                ->where('service_type', $serviceOffering->service_group)
                ->orderBy('sort_order')
                ->limit(3)
                ->get(),
        ]);
    }

    public function templates(Request $request): View
    {
        $validated = $request->validate([
            'category' => ['nullable', 'string', 'max:120'],
            'search' => ['nullable', 'string', 'max:120'],
            'sort' => ['nullable', 'in:newest,price_asc,price_desc'],
        ]);

        $templates = WebsiteTemplate::query()
            ->with('category')
            ->where('status', 'active')
            ->when($validated['category'] ?? null, fn ($query, string $slug) => $query->whereHas('category', fn ($category) => $category->where('slug', $slug)))
            ->when($validated['search'] ?? null, fn ($query, string $search) => $query->where(fn ($inner) => $inner
                ->where('name', 'like', "%{$search}%")
                ->orWhere('summary', 'like', "%{$search}%")
            ))
            ->when(($validated['sort'] ?? 'newest') === 'price_asc', fn ($query) => $query->orderBy('price'))
            ->when(($validated['sort'] ?? 'newest') === 'price_desc', fn ($query) => $query->orderByDesc('price'))
            ->when(($validated['sort'] ?? 'newest') === 'newest', fn ($query) => $query->latest())
            ->paginate(12)
            ->withQueryString();

        return view('marketplace.templates.index', [
            'templates' => $templates,
            'categories' => TemplateCategory::query()->where('is_active', true)->orderBy('sort_order')->get(),
            'filters' => $validated,
        ]);
    }

    public function templateDetail(WebsiteTemplate $websiteTemplate): View
    {
        abort_unless($websiteTemplate->status === 'active', 404);

        return view('marketplace.templates.show', [
            'template' => $websiteTemplate->load(['category', 'demoProjects', 'attachments']),
        ]);
    }

    public function portfolio(): View
    {
        return view('marketplace.portfolio.index', [
            'projects' => DemoProject::query()
                ->where('status', 'published')
                ->where('is_active', true)
                ->where('project_type', '!=', 'source_code')
                ->with('websiteTemplate')
                ->latest()
                ->paginate(9),
        ]);
    }

    public function portfolioDetail(DemoProject $demoProject): View
    {
        abort_unless($demoProject->status === 'published' && $demoProject->is_active && $demoProject->project_type !== 'source_code', 404);

        return view('marketplace.portfolio.show', [
            'project' => $demoProject->load('websiteTemplate'),
            'relatedProjects' => DemoProject::query()
                ->where('status', 'published')
                ->where('is_active', true)
                ->where('project_type', '!=', 'source_code')
                ->whereKeyNot($demoProject->getKey())
                ->with('websiteTemplate')
                ->latest()
                ->limit(3)
                ->get(),
        ]);
    }

    public function blog(): View
    {
        $selectedPillar = request()->string('pillar')->toString();

        $query = BlogPost::query()
            ->published()
            ->when($selectedPillar, fn ($builder, $value) => $builder->where('content_pillar', $value))
            ->latest('published_at');

        return view('marketplace.blog.index', [
            'posts' => $query->paginate(9)->withQueryString(),
            'selectedPillar' => $selectedPillar,
            'pillars' => collect(BlogPost::pillarOptions())->map(function (array $meta, string $key) {
                return [
                    'key' => $key,
                    ...$meta,
                    'count' => BlogPost::query()->published()->where('content_pillar', $key)->count(),
                    'href' => route('blog.index', ['pillar' => $key]),
                ];
            })->values(),
            'serviceLinks' => ServiceOffering::query()
                ->where('status', 'published')
                ->orderBy('sort_order')
                ->limit(5)
                ->get(),
        ]);
    }

    public function blogDetail(BlogPost $blogPost): View
    {
        abort_unless($blogPost->status === 'published', 404);

        return view('marketplace.blog.show', [
            'post' => $blogPost,
            'relatedPosts' => BlogPost::query()
                ->published()
                ->whereKeyNot($blogPost->getKey())
                ->when($blogPost->content_pillar, fn ($query, $value) => $query->where('content_pillar', $value))
                ->latest('published_at')
                ->limit(3)
                ->get(),
            'relatedServices' => ServiceOffering::query()
                ->where('status', 'published')
                ->when(
                    $blogPost->service_group,
                    fn ($query, $value) => $query->where('service_group', $value),
                    fn ($query) => $query->whereIn('service_group', ['website', 'seo', 'coding_task'])
                )
                ->orderBy('sort_order')
                ->limit(3)
                ->get(),
            'softLinks' => $this->blogSoftLinks($blogPost),
        ]);
    }

    public function storeOrder(StoreOrderRequestRequest $request, CustomerUpsertService $customers): RedirectResponse
    {
        $validated = $request->validated();
        $customer = $customers->upsert([
            'name' => $validated['customer_name'],
            'email' => $validated['customer_email'] ?? null,
            'phone' => $validated['customer_phone'] ?? null,
            'customer_group' => $validated['customer_group'],
        ]);

        OrderRequest::query()->create($validated + ['customer_id' => $customer->id]);

        return back()->with('status', 'Yêu cầu của bạn đã được ghi nhận. Chúng tôi sẽ liên hệ lại sớm để xác nhận thông tin.');
    }

    public function storeQuote(StoreQuoteRequestRequest $request, CustomerUpsertService $customers): RedirectResponse
    {
        $validated = $request->validated();
        $customer = $customers->upsert([
            'name' => $validated['customer_name'],
            'email' => $validated['customer_email'] ?? null,
            'phone' => $validated['customer_phone'] ?? null,
            'customer_group' => $validated['customer_group'],
        ]);

        QuoteRequest::query()->create($validated + ['customer_id' => $customer->id]);

        return back()->with('status', 'Yêu cầu tư vấn đã được gửi. Chúng tôi sẽ phản hồi sớm với hướng xử lý phù hợp.');
    }

    public function storeGraduationRequest(StoreGraduationProjectRequestRequest $request, CustomerUpsertService $customers): RedirectResponse
    {
        $validated = $request->validated();
        $customer = $customers->upsert([
            'name' => $validated['student_name'],
            'email' => $validated['student_email'] ?? null,
            'phone' => $validated['student_phone'] ?? null,
            'customer_group' => 'student',
        ]);

        GraduationProjectRequest::query()->create($validated + [
            'customer_id' => $customer->id,
            'need_report' => $request->boolean('need_report'),
            'need_database' => $request->boolean('need_database'),
            'need_installation_guide' => $request->boolean('need_installation_guide'),
        ]);

        return back()->with('status', 'Yêu cầu hỗ trợ đề tài đã được gửi. Chúng tôi sẽ phản hồi sớm với hướng làm phù hợp.');
    }

    public function storeContact(StoreContactMessageRequest $request): RedirectResponse
    {
        ContactMessage::query()->create($request->validated());

        return back()->with('status', 'Tin nhắn của bạn đã được gửi. Cảm ơn bạn đã liên hệ.');
    }

    public function sitemap(): Response
    {
        $urls = collect([
            url('/'),
            route('services'),
            route('templates.index'),
            route('portfolio.index'),
            route('blog.index'),
        ])
            ->merge(WebsiteTemplate::query()->where('status', 'active')->pluck('slug')->map(fn ($slug) => route('templates.show', $slug)))
            ->merge(BlogPost::query()->where('status', 'published')->pluck('slug')->map(fn ($slug) => route('blog.show', $slug)))
            ->map(fn ($url) => '<url><loc>'.e($url).'</loc></url>')
            ->implode('');

        return response('<?xml version="1.0" encoding="UTF-8"?><urlset xmlns="http://www.sitemaps.org/schemas/sitemap/0.9">'.$urls.'</urlset>', 200)
            ->header('Content-Type', 'application/xml');
    }

    public function robots(): Response
    {
        return response("User-agent: *\nAllow: /\nSitemap: ".url('/sitemap.xml')."\n", 200)
            ->header('Content-Type', 'text/plain');
    }

    private function serviceBlueprints(): array
    {
        return [
            'seo' => [
                'problems' => [
                    'Website đã có nhưng title, mô tả và heading chưa tối ưu.',
                    'Nội dung ít chuyển đổi, thiếu internal link và CTA rõ.',
                    'Trang tải chậm hoặc trải nghiệm mobile làm giảm hiệu quả SEO.',
                ],
                'scope' => [
                    'Audit nhanh lỗi SEO on-page và cấu trúc trang.',
                    'Tối ưu title, meta description, heading, nội dung và internal link.',
                    'Rà soát tốc độ tải trang, image, CTA và trải nghiệm mobile.',
                ],
                'technologies' => ['HTML semantic', 'Core Web Vitals cơ bản', 'Laravel Blade', 'Meta/heading structure'],
                'timeline' => 'Thường 2-5 ngày cho audit nhanh và tối ưu các trang chính.',
                'blog_cta' => 'Xem thêm bài blog về SEO website',
            ],
            'ui_fix' => [
                'problems' => [
                    'Website bị vỡ giao diện ở mobile hoặc tablet.',
                    'CTA chìm, section rối và khách khó đọc nội dung chính.',
                    'UI cũ làm giảm độ tin cậy khi chạy quảng cáo hoặc gửi khách xem.',
                ],
                'scope' => [
                    'Sửa layout, spacing, typography và responsive.',
                    'Làm rõ CTA, form, trust block và các section cần chuyển đổi.',
                    'Tối ưu lại trải nghiệm desktop, tablet và mobile theo scope đã chốt.',
                ],
                'technologies' => ['Tailwind CSS', 'Blade', 'Responsive layout', 'UI/UX content blocks'],
                'timeline' => 'Task nhỏ có thể xử lý trong 1-3 ngày; redesign block lớn cần audit riêng.',
                'blog_cta' => 'Đọc thêm nội dung về sửa UI và landing page',
            ],
            'website' => [
                'problems' => [
                    'Chưa có website chính thức để khách kiểm tra thông tin và liên hệ.',
                    'Landing page chạy quảng cáo chưa đủ thuyết phục để chốt lead.',
                    'Website hiện tại khó cập nhật và không có luồng demo/bàn giao rõ ràng.',
                ],
                'scope' => [
                    'Thiết kế website giới thiệu, website bán hàng cơ bản hoặc landing page.',
                    'Cấu trúc hero, problem, solution, trust, pricing và CTA rõ ràng.',
                    'Hỗ trợ demo trước, chỉnh sửa theo feedback và bàn giao/deploy.',
                ],
                'technologies' => ['Laravel', 'Blade', 'TailwindCSS', 'Lead forms', 'Responsive UI'],
                'timeline' => 'Gói cơ bản thường từ 3-7 ngày tùy số trang và mức độ custom.',
                'blog_cta' => 'Xem bài chia sẻ về website và landing page',
            ],
            'student_support' => [
                'problems' => [
                    'Đồ án có source nhưng thiếu database, báo cáo hoặc hướng dẫn chạy.',
                    'Deadline sát và chưa rõ flow chức năng hoặc kiến trúc dữ liệu.',
                    'Khó sửa bug hoặc hoàn thiện demo để bảo vệ.',
                ],
                'scope' => [
                    'Hỗ trợ ý tưởng, source code, API, database và tài liệu.',
                    'Rà soát lỗi, hoàn thiện chức năng và chuẩn bị demo/báo cáo.',
                    'Giải thích luồng xử lý để sinh viên dễ trình bày khi bảo vệ.',
                ],
                'technologies' => ['Laravel', 'PHP', 'MySQL', 'REST API', 'Database design'],
                'timeline' => 'Thường 2-7 ngày tùy mức hoàn thiện hiện tại và deadline.',
                'blog_cta' => 'Xem nội dung hỗ trợ đồ án và source Laravel',
            ],
            'coding_task' => [
                'problems' => [
                    'Cần fix bug hoặc làm nhanh một task nhỏ nhưng không đủ bandwidth.',
                    'Cần thêm API, database hoặc UI block trong thời gian ngắn.',
                    'Muốn giao việc theo scope rõ và nhận lại kết quả chạy được.',
                ],
                'scope' => [
                    'Fix bug, viết API, chỉnh database, làm UI hoặc chức năng nhỏ.',
                    'Nhận task theo mô tả issue, backlog item hoặc scope ngắn.',
                    'Bàn giao kèm hướng dẫn ngắn để team hoặc khách tiếp tục vận hành.',
                ],
                'technologies' => ['PHP', 'Laravel', 'React', 'Next.js', 'JavaScript', 'MySQL'],
                'timeline' => 'Task nhỏ có thể xử lý trong ngày hoặc theo lịch 1-3 ngày.',
                'blog_cta' => 'Đọc thêm bài chia sẻ về task lập trình và xử lý nhanh',
            ],
        ];
    }

    private function blogSoftLinks(BlogPost $post): array
    {
        $serviceGroup = $post->service_group ?: match ($post->content_pillar) {
            'seo' => 'seo',
            'landing_page' => 'website',
            'ui_fix' => 'ui_fix',
            'student_support' => 'student_support',
            default => 'coding_task',
        };

        return [
            [
                'label' => 'Xem dịch vụ liên quan',
                'href' => route('services'),
                'description' => BlogPost::serviceGroupOptions()[$serviceGroup] ?? 'Dịch vụ phù hợp',
            ],
            [
                'label' => 'Xem dự án đã thực hiện',
                'href' => route('portfolio.index'),
                'description' => 'Xem cách triển khai thực tế trước khi gửi yêu cầu.',
            ],
            [
                'label' => 'Gửi nhu cầu để được tư vấn',
                'href' => route('services'),
                'description' => 'Đi tiếp sang funnel tư vấn hoặc liên hệ nhanh qua Zalo.',
            ],
        ];
    }
}
