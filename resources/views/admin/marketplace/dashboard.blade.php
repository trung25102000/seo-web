@extends('layouts.app')

@section('title', 'Admin marketplace')

@section('content')
    <div class="space-y-6">
        <section>
            <p class="text-sm font-semibold text-rose-700">Admin</p>
            <h1 class="mt-2 text-3xl font-semibold">Lead operations dashboard</h1>
            <p class="mt-2 text-sm text-zinc-600">Ưu tiên phản hồi lead mới, theo dõi nhóm lead khẩn và mở nhanh các module tư vấn chính.</p>
        </section>

        <section class="grid gap-4 md:grid-cols-4 xl:grid-cols-7">
            @foreach ($stats as $label => $value)
                <div class="rounded-lg border border-zinc-200 bg-white p-4 shadow-sm">
                    <p class="text-xs uppercase text-zinc-500">{{ $label }}</p>
                    <p class="mt-2 text-2xl font-semibold">{{ $value }}</p>
                </div>
            @endforeach
        </section>

        <section class="grid gap-4 md:grid-cols-2 xl:grid-cols-4">
            @foreach ($leadSnapshots as $item)
                <a href="{{ $item['href'] }}" class="rounded-lg border border-sky-100 bg-sky-50 p-4 shadow-sm transition hover:-translate-y-0.5 hover:shadow-md">
                    <p class="text-xs font-semibold uppercase text-sky-700">{{ $item['label'] }}</p>
                    <p class="mt-2 text-3xl font-semibold text-zinc-950">{{ $item['value'] }}</p>
                    <p class="mt-1 text-sm text-zinc-600">Mở danh sách xử lý</p>
                </a>
            @endforeach
        </section>

        <nav class="flex flex-wrap gap-2 text-sm">
            @foreach ([
                'categories' => 'Danh mục',
                'templates' => 'Template',
                'services' => 'Dịch vụ',
                'orders' => 'Đơn hàng',
                'quotes' => 'Lead báo giá',
                'graduation-requests' => 'Yêu cầu đồ án',
                'customers' => 'Khách hàng',
                'contacts' => 'Liên hệ',
                'blog-posts' => 'Blog',
                'demo-projects' => 'Portfolio',
                'testimonials' => 'Feedback',
                'faqs' => 'FAQ',
            ] as $route => $label)
                <a class="rounded-md border border-zinc-200 bg-white px-3 py-2 font-semibold text-zinc-700" href="{{ route('admin.marketplace.'.$route) }}">{{ $label }}</a>
            @endforeach
        </nav>

        <section class="grid gap-6 lg:grid-cols-[18rem_1fr]">
            <div class="rounded-lg border border-zinc-200 bg-white p-5 shadow-sm">
                <h2 class="font-semibold text-zinc-950">Admin users</h2>
                <div class="mt-3 space-y-3 text-sm">
                    @foreach ($users as $user)
                        <p><span class="font-semibold">{{ $user->name }}</span><br><span class="text-zinc-500">{{ $user->email }}</span></p>
                    @endforeach
                </div>
            </div>

            <div class="rounded-lg border border-zinc-200 bg-white p-5 shadow-sm">
                <div class="flex flex-wrap items-center justify-between gap-3">
                    <div>
                        <h2 class="font-semibold text-zinc-950">Lead mới cần phản hồi</h2>
                        <p class="mt-1 text-sm text-zinc-500">Các bản ghi mới nhất từ đơn hàng, báo giá và liên hệ.</p>
                    </div>
                    <div class="flex flex-wrap gap-2 text-xs">
                        @foreach ($leadStatuses as $value => $label)
                            <span class="rounded-full bg-zinc-100 px-3 py-1 font-semibold text-zinc-600">{{ $label }}</span>
                        @endforeach
                    </div>
                </div>

                <div class="mt-4 space-y-3 text-sm">
                    @foreach ($recentLeads as $lead)
                        <a href="{{ $lead['href'] }}" class="block rounded-md border border-zinc-100 p-3 transition hover:border-rose-200 hover:bg-rose-50/40">
                            <div class="flex flex-wrap items-center justify-between gap-2">
                                <p class="font-semibold text-zinc-950">{{ $lead['name'] }}</p>
                                <span class="rounded-full bg-zinc-100 px-2.5 py-1 text-xs font-semibold text-zinc-700">{{ $leadStatuses[$lead['status']] ?? $lead['status'] }}</span>
                            </div>
                            <p class="mt-1 text-xs font-semibold uppercase text-rose-700">{{ $lead['label'] }}</p>
                            <p class="mt-1 text-zinc-600">{{ $lead['context'] }}</p>
                        </a>
                    @endforeach
                </div>
            </div>
        </section>
    </div>
@endsection
