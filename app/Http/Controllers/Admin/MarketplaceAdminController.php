<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreDemoProjectRequest;
use App\Http\Requests\StoreServiceOfferingRequest;
use App\Http\Requests\StoreTestimonialRequest;
use App\Http\Requests\UpdateDemoProjectRequest;
use App\Http\Requests\UpdateServiceOfferingRequest;
use App\Http\Requests\UpdateTestimonialRequest;
use App\Models\BlogPost;
use App\Models\ContactMessage;
use App\Models\Customer;
use App\Models\DemoProject;
use App\Models\FaqItem;
use App\Models\GraduationProjectRequest;
use App\Models\OrderRequest;
use App\Models\QuoteRequest;
use App\Models\ServiceOffering;
use App\Models\TemplateCategory;
use App\Models\Testimonial;
use App\Models\User;
use App\Models\WebsiteTemplate;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Validation\Rule;
use Illuminate\View\View;

class MarketplaceAdminController extends Controller
{
    public function dashboard(): View
    {
        $leadStatuses = $this->leadStatuses();
        $leadPriorities = $this->leadPriorities();

        return view('admin.marketplace.dashboard', [
            'stats' => [
                'templates' => WebsiteTemplate::query()->count(),
                'services' => ServiceOffering::query()->count(),
                'orders' => OrderRequest::query()->count(),
                'quotes' => QuoteRequest::query()->count(),
                'graduationRequests' => GraduationProjectRequest::query()->count(),
                'contacts' => ContactMessage::query()->count(),
                'testimonials' => Testimonial::query()->count(),
            ],
            'leadSnapshots' => [
                [
                    'label' => 'Đơn hàng mới',
                    'value' => OrderRequest::query()->where('status', 'new')->count(),
                    'href' => route('admin.marketplace.orders', ['status' => 'new']),
                ],
                [
                    'label' => 'Lead báo giá mới',
                    'value' => QuoteRequest::query()->where('status', 'new')->count(),
                    'href' => route('admin.marketplace.quotes', ['status' => 'new']),
                ],
                [
                    'label' => 'Liên hệ chưa xử lý',
                    'value' => ContactMessage::query()->where('status', 'new')->count(),
                    'href' => route('admin.marketplace.contacts', ['status' => 'new']),
                ],
                [
                    'label' => 'Lead ưu tiên cao',
                    'value' => QuoteRequest::query()->whereIn('priority', ['high', 'urgent'])->count()
                        + OrderRequest::query()->whereIn('priority', ['high', 'urgent'])->count()
                        + GraduationProjectRequest::query()->whereIn('priority', ['high', 'urgent'])->count()
                        + ContactMessage::query()->whereIn('priority', ['high', 'urgent'])->count(),
                    'href' => route('admin.marketplace.quotes', ['priority' => 'high']),
                ],
            ],
            'recentLeads' => $this->recentLeads(),
            'leadStatuses' => $leadStatuses,
            'leadPriorities' => $leadPriorities,
            'users' => User::query()->latest()->limit(10)->get(),
        ]);
    }

    public function categories(): View
    {
        return view('admin.marketplace.categories', [
            'categories' => TemplateCategory::query()->orderBy('sort_order')->paginate(20),
        ]);
    }

    public function storeCategory(Request $request): RedirectResponse
    {
        $data = $request->validate([
            'name' => ['required', 'string', 'max:120'],
            'description' => ['nullable', 'string', 'max:2000'],
            'is_active' => ['nullable', 'boolean'],
        ]);

        TemplateCategory::query()->create($data + [
            'slug' => Str::slug($data['name']).'-'.Str::lower(Str::random(5)),
            'is_active' => $request->boolean('is_active', true),
        ]);

        return back()->with('status', 'Đã tạo danh mục template.');
    }

    public function templates(): View
    {
        return view('admin.marketplace.templates', [
            'templates' => WebsiteTemplate::query()->with('category')->latest()->paginate(20),
            'categories' => TemplateCategory::query()->where('is_active', true)->orderBy('sort_order')->get(),
        ]);
    }

    public function services(): View
    {
        return view('admin.marketplace.services', [
            'services' => ServiceOffering::query()->orderBy('sort_order')->orderBy('name')->paginate(30),
        ]);
    }

    public function storeService(StoreServiceOfferingRequest $request): RedirectResponse
    {
        $data = $request->validated();

        ServiceOffering::query()->create([
            'name' => $data['name'],
            'slug' => Str::slug($data['name']).'-'.Str::lower(Str::random(5)),
            'service_group' => $data['service_group'],
            'short_description' => $data['short_description'],
            'detail_description' => $data['detail_description'],
            'target_audiences' => $this->splitTextareaLines($data['target_audiences'] ?? null),
            'key_benefits' => $this->splitTextareaLines($data['key_benefits'] ?? null),
            'process_steps' => $this->splitTextareaLines($data['process_steps'] ?? null),
            'pricing_note' => $data['pricing_note'] ?? null,
            'status' => $data['status'],
            'sort_order' => $data['sort_order'] ?? 0,
        ]);

        return back()->with('status', 'Đã tạo dịch vụ.');
    }

    public function updateService(UpdateServiceOfferingRequest $request, ServiceOffering $serviceOffering): RedirectResponse
    {
        $serviceOffering->update($request->validated());

        return back()->with('status', 'Đã cập nhật trạng thái dịch vụ.');
    }

    public function storeTemplate(Request $request): RedirectResponse
    {
        $data = $request->validate([
            'template_category_id' => ['nullable', 'exists:template_categories,id'],
            'name' => ['required', 'string', 'max:160'],
            'audience_type' => ['required', Rule::in(['shop_owner', 'online_seller', 'student'])],
            'template_type' => ['required', 'string', 'max:80'],
            'summary' => ['nullable', 'string', 'max:1000'],
            'description' => ['nullable', 'string', 'max:8000'],
            'price' => ['nullable', 'integer', 'min:0'],
            'preview_image_path' => ['nullable', 'string', 'max:255'],
            'demo_url' => ['nullable', 'url', 'max:255'],
            'status' => ['required', Rule::in(['active', 'inactive'])],
        ]);

        WebsiteTemplate::query()->create($data + ['slug' => Str::slug($data['name']).'-'.Str::lower(Str::random(5))]);

        return back()->with('status', 'Đã tạo template.');
    }

    public function orders(Request $request): View
    {
        $filters = $this->extractLeadFilters($request, ['status', 'priority', 'lead_source', 'customer_group']);

        return view('admin.marketplace.orders', [
            'orders' => OrderRequest::query()->with(['customer', 'websiteTemplate'])
                ->when($filters['status'], fn ($query, $value) => $query->where('status', $value))
                ->when($filters['priority'], fn ($query, $value) => $query->where('priority', $value))
                ->when($filters['lead_source'], fn ($query, $value) => $query->where('lead_source', $value))
                ->when($filters['customer_group'], fn ($query, $value) => $query->where('customer_group', $value))
                ->latest()
                ->paginate(20)
                ->withQueryString(),
            'filters' => $filters,
            'leadStatuses' => $this->leadStatuses(),
            'leadPriorities' => $this->leadPriorities(),
            'leadSources' => $this->leadSources(),
            'customerGroups' => $this->customerGroups(),
        ]);
    }

    public function updateOrder(Request $request, OrderRequest $orderRequest): RedirectResponse
    {
        $data = $request->validate([
            'status' => ['required', Rule::in(array_keys($this->leadStatuses()))],
            'priority' => ['required', Rule::in(array_keys($this->leadPriorities()))],
            'lead_source' => ['required', Rule::in(array_keys($this->leadSources()))],
            'internal_note' => ['nullable', 'string', 'max:3000'],
        ]);

        $orderRequest->update($data);

        return back()->with('status', 'Đã cập nhật đơn hàng.');
    }

    public function customers(): View
    {
        return view('admin.marketplace.customers', [
            'customers' => Customer::query()
                ->withCount(['orderRequests', 'quoteRequests', 'graduationProjectRequests'])
                ->latest()
                ->paginate(30),
        ]);
    }

    public function updateCustomer(Request $request, Customer $customer): RedirectResponse
    {
        $data = $request->validate([
            'note' => ['nullable', 'string', 'max:3000'],
        ]);

        $customer->update($data);

        return back()->with('status', 'Đã cập nhật ghi chú khách hàng.');
    }

    public function contacts(Request $request): View
    {
        $filters = $this->extractLeadFilters($request, ['status', 'priority', 'service_type', 'preferred_contact_channel', 'channel']);

        return view('admin.marketplace.contacts', [
            'messages' => ContactMessage::query()
                ->when($filters['status'], fn ($query, $value) => $query->where('status', $value))
                ->when($filters['priority'], fn ($query, $value) => $query->where('priority', $value))
                ->when($filters['service_type'], fn ($query, $value) => $query->where('service_type', $value))
                ->when($filters['preferred_contact_channel'], fn ($query, $value) => $query->where('preferred_contact_channel', $value))
                ->when($filters['channel'], fn ($query, $value) => $query->where('channel', $value))
                ->latest()
                ->paginate(30)
                ->withQueryString(),
            'filters' => $filters,
            'leadStatuses' => $this->leadStatuses(),
            'leadPriorities' => $this->leadPriorities(),
            'serviceTypes' => $this->serviceTypes(),
            'contactChannels' => $this->contactChannels(),
        ]);
    }

    public function updateContact(Request $request, ContactMessage $contactMessage): RedirectResponse
    {
        $data = $request->validate([
            'status' => ['required', Rule::in(array_keys($this->leadStatuses()))],
            'priority' => ['required', Rule::in(array_keys($this->leadPriorities()))],
            'admin_note' => ['nullable', 'string', 'max:3000'],
        ]);

        $contactMessage->update($data);

        return back()->with('status', 'Đã cập nhật tin nhắn liên hệ.');
    }

    public function quotes(Request $request): View
    {
        $filters = $this->extractLeadFilters($request, ['status', 'priority', 'service_type', 'preferred_contact_channel', 'lead_source']);

        return view('admin.marketplace.quotes', [
            'quotes' => QuoteRequest::query()->with('customer')
                ->when($filters['status'], fn ($query, $value) => $query->where('status', $value))
                ->when($filters['priority'], fn ($query, $value) => $query->where('priority', $value))
                ->when($filters['service_type'], fn ($query, $value) => $query->where('service_type', $value))
                ->when($filters['preferred_contact_channel'], fn ($query, $value) => $query->where('preferred_contact_channel', $value))
                ->when($filters['lead_source'], fn ($query, $value) => $query->where('lead_source', $value))
                ->latest()
                ->paginate(30)
                ->withQueryString(),
            'filters' => $filters,
            'leadStatuses' => $this->leadStatuses(),
            'leadPriorities' => $this->leadPriorities(),
            'serviceTypes' => $this->serviceTypes(),
            'preferredContactChannels' => $this->preferredContactChannels(),
            'leadSources' => $this->leadSources(),
        ]);
    }

    public function updateQuote(Request $request, QuoteRequest $quoteRequest): RedirectResponse
    {
        $data = $request->validate([
            'status' => ['required', Rule::in(array_keys($this->leadStatuses()))],
            'priority' => ['required', Rule::in(array_keys($this->leadPriorities()))],
            'lead_source' => ['required', Rule::in(array_keys($this->leadSources()))],
            'admin_note' => ['nullable', 'string', 'max:3000'],
        ]);

        $quoteRequest->update($data);

        return back()->with('status', 'Đã cập nhật lead báo giá.');
    }

    public function graduationRequests(Request $request): View
    {
        $filters = $this->extractLeadFilters($request, ['status', 'priority', 'lead_source']);

        return view('admin.marketplace.graduation-requests', [
            'requests' => GraduationProjectRequest::query()->with('customer')
                ->when($filters['status'], fn ($query, $value) => $query->where('status', $value))
                ->when($filters['priority'], fn ($query, $value) => $query->where('priority', $value))
                ->when($filters['lead_source'], fn ($query, $value) => $query->where('lead_source', $value))
                ->latest()
                ->paginate(30)
                ->withQueryString(),
            'filters' => $filters,
            'leadStatuses' => $this->leadStatuses(),
            'leadPriorities' => $this->leadPriorities(),
            'leadSources' => $this->leadSources(),
        ]);
    }

    public function updateGraduationRequest(Request $request, GraduationProjectRequest $graduationProjectRequest): RedirectResponse
    {
        $data = $request->validate([
            'status' => ['required', Rule::in(array_keys($this->leadStatuses()))],
            'priority' => ['required', Rule::in(array_keys($this->leadPriorities()))],
            'lead_source' => ['required', Rule::in(array_keys($this->leadSources()))],
            'admin_note' => ['nullable', 'string', 'max:3000'],
        ]);

        $graduationProjectRequest->update($data);

        return back()->with('status', 'Đã cập nhật yêu cầu đồ án.');
    }

    public function blogPosts(): View
    {
        return view('admin.marketplace.blog-posts', [
            'posts' => BlogPost::query()->latest()->paginate(30),
        ]);
    }

    public function storeBlogPost(Request $request): RedirectResponse
    {
        $data = $request->validate([
            'title' => ['required', 'string', 'max:180'],
            'audience_type' => ['nullable', Rule::in(['shop_owner', 'online_seller', 'student'])],
            'content_pillar' => ['required', Rule::in(array_keys(BlogPost::pillarOptions()))],
            'service_group' => ['required', Rule::in(array_keys(BlogPost::serviceGroupOptions()))],
            'excerpt' => ['nullable', 'string', 'max:1000'],
            'content' => ['required', 'string'],
            'meta_title' => ['nullable', 'string', 'max:180'],
            'meta_description' => ['nullable', 'string', 'max:255'],
            'status' => ['required', Rule::in(['draft', 'published'])],
        ]);

        BlogPost::query()->create($data + [
            'slug' => Str::slug($data['title']).'-'.Str::lower(Str::random(5)),
            'published_at' => $data['status'] === 'published' ? now() : null,
        ]);

        return back()->with('status', 'Đã tạo bài SEO.');
    }

    public function demoProjects(): View
    {
        return view('admin.marketplace.demo-projects', [
            'demos' => DemoProject::query()->with('websiteTemplate')->latest()->paginate(30),
            'templates' => WebsiteTemplate::query()->where('status', 'active')->orderBy('name')->get(),
        ]);
    }

    public function storeDemoProject(StoreDemoProjectRequest $request): RedirectResponse
    {
        $data = $request->validated();

        DemoProject::query()->create([
            ...$data,
            'slug' => Str::slug($data['name']).'-'.Str::lower(Str::random(5)),
            'tech_stack' => $this->splitTextareaLines($data['tech_stack'] ?? null),
            'is_active' => $request->boolean('is_active', true),
        ]);

        return back()->with('status', 'Đã tạo case study / portfolio project.');
    }

    public function updateDemoProject(UpdateDemoProjectRequest $request, DemoProject $demoProject): RedirectResponse
    {
        $demoProject->update([
            'status' => $request->validated()['status'],
            'is_active' => $request->boolean('is_active'),
        ]);

        return back()->with('status', 'Đã cập nhật trạng thái portfolio project.');
    }

    public function faqs(): View
    {
        return view('admin.marketplace.faqs', [
            'faqs' => FaqItem::query()->orderBy('audience_type')->orderBy('sort_order')->paginate(30),
        ]);
    }

    public function testimonials(): View
    {
        return view('admin.marketplace.testimonials', [
            'testimonials' => Testimonial::query()->orderBy('sort_order')->latest()->paginate(30),
        ]);
    }

    public function storeTestimonial(StoreTestimonialRequest $request): RedirectResponse
    {
        Testimonial::query()->create($request->validated() + [
            'avatar_label' => $request->validated()['avatar_label'] ?: Str::upper(Str::substr($request->validated()['name'], 0, 2)),
            'sort_order' => $request->validated()['sort_order'] ?? 0,
        ]);

        return back()->with('status', 'Đã tạo feedback khách hàng.');
    }

    public function updateTestimonial(UpdateTestimonialRequest $request, Testimonial $testimonial): RedirectResponse
    {
        $testimonial->update($request->validated());

        return back()->with('status', 'Đã cập nhật trạng thái feedback.');
    }

    private function splitTextareaLines(?string $value): array
    {
        return collect(explode("\n", $value ?? ''))
            ->map(fn (string $line) => trim($line))
            ->filter()
            ->values()
            ->all();
    }

    private function extractLeadFilters(Request $request, array $keys): array
    {
        return collect($keys)
            ->mapWithKeys(fn (string $key) => [$key => $request->string($key)->toString()])
            ->all();
    }

    private function recentLeads(): array
    {
        return [
            ...OrderRequest::query()->latest()->limit(4)->get()->map(fn (OrderRequest $lead) => [
                'label' => 'Đơn hàng',
                'name' => $lead->customer_name,
                'context' => trim(implode(' · ', array_filter([$lead->need_type, $lead->customer_phone, $this->leadPriorities()[$lead->priority] ?? $lead->priority]))),
                'status' => $lead->status,
                'href' => route('admin.marketplace.orders'),
            ])->all(),
            ...QuoteRequest::query()->latest()->limit(4)->get()->map(fn (QuoteRequest $lead) => [
                'label' => 'Báo giá',
                'name' => $lead->customer_name,
                'context' => trim(implode(' · ', array_filter([$this->serviceTypes()[$lead->service_type] ?? $lead->service_type, $lead->preferred_contact_channel, $lead->budget_range]))),
                'status' => $lead->status,
                'href' => route('admin.marketplace.quotes'),
            ])->all(),
            ...ContactMessage::query()->latest()->limit(4)->get()->map(fn (ContactMessage $lead) => [
                'label' => 'Liên hệ',
                'name' => $lead->name,
                'context' => trim(implode(' · ', array_filter([$lead->channel, $lead->preferred_contact_channel, $lead->phone]))),
                'status' => $lead->status,
                'href' => route('admin.marketplace.contacts'),
            ])->all(),
        ];
    }

    private function leadStatuses(): array
    {
        return [
            'new' => 'Mới',
            'contacted' => 'Đã liên hệ',
            'in_progress' => 'Đang xử lý',
            'completed' => 'Đã chốt',
            'cancelled' => 'Đã hủy',
        ];
    }

    private function leadPriorities(): array
    {
        return [
            'low' => 'Thấp',
            'normal' => 'Bình thường',
            'high' => 'Cao',
            'urgent' => 'Khẩn',
        ];
    }

    private function leadSources(): array
    {
        return [
            'website' => 'Website',
            'zalo' => 'Zalo',
            'facebook' => 'Facebook',
            'email' => 'Email',
            'phone' => 'Điện thoại',
            'referral' => 'Giới thiệu',
            'returning_customer' => 'Khách cũ',
        ];
    }

    private function preferredContactChannels(): array
    {
        return [
            'zalo' => 'Zalo',
            'phone' => 'Gọi điện',
            'email' => 'Email',
            'facebook' => 'Facebook',
        ];
    }

    private function contactChannels(): array
    {
        return [
            'website' => 'Website',
            'zalo' => 'Zalo',
            'facebook' => 'Facebook',
            'email' => 'Email',
            'phone' => 'Điện thoại',
        ];
    }

    private function serviceTypes(): array
    {
        return [
            'website' => 'Website',
            'landing_page' => 'Landing page',
            'catalog' => 'Catalog',
            'seo' => 'SEO website',
            'ui_fix' => 'Fix giao diện',
            'coding_task' => 'Task code',
            'student_support' => 'Hỗ trợ đồ án',
            'custom' => 'Yêu cầu riêng',
        ];
    }

    private function customerGroups(): array
    {
        return [
            'shop_owner' => 'Chủ shop',
            'online_seller' => 'Kinh doanh online',
            'student' => 'Sinh viên',
        ];
    }
}
