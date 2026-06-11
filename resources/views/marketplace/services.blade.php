@extends('layouts.app')

@section('title', 'Dịch vụ làm website, SEO và sửa website')
@section('meta_description', 'Danh sách dịch vụ làm website, landing page, tối ưu SEO, sửa giao diện và hỗ trợ đồ án cho khách cần triển khai rõ ràng.')
@section('canonical', route('services'))
@section('structured_data')
    <script type="application/ld+json">
        {!! json_encode([
            '@'.'context' => 'https://schema.org',
            '@'.'type' => 'ItemList',
            'name' => 'Danh sách dịch vụ Web Template Studio',
            'url' => route('services'),
            'numberOfItems' => $serviceOfferings->count(),
        ], JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES) !!}
    </script>
@endsection

@section('content')
    @php
        $serviceVisuals = [
            'seo' => ['eyebrow' => 'SEO Website', 'icon' => 'SEO', 'gradient' => 'from-[#2563EB] via-[#06B6D4] to-[#10B981]', 'surface' => 'bg-sky-50', 'line' => 'Giúp website dễ được tìm thấy và có nhiều khách liên hệ hơn'],
            'website' => ['eyebrow' => 'Làm Website', 'icon' => 'WEB', 'gradient' => 'from-[#2563EB] via-[#7C3AED] to-[#0F172A]', 'surface' => 'bg-indigo-50', 'line' => 'Website giới thiệu, landing page và trang bán hàng dễ dùng'],
            'ui_fix' => ['eyebrow' => 'Sửa Website', 'icon' => 'FIX', 'gradient' => 'from-[#F97316] via-[#EF4444] to-[#7C3AED]', 'surface' => 'bg-rose-50', 'line' => 'Sửa giao diện, form liên hệ và trải nghiệm trên điện thoại'],
            'student_support' => ['eyebrow' => 'Hỗ trợ đồ án', 'icon' => 'LAB', 'gradient' => 'from-[#0F172A] via-[#2563EB] to-[#06B6D4]', 'surface' => 'bg-cyan-50', 'line' => 'Có tài liệu, database mẫu và hướng dẫn để demo dễ hơn'],
            'coding_task' => ['eyebrow' => 'Hỗ trợ lập trình', 'icon' => 'DEV', 'gradient' => 'from-[#10B981] via-[#06B6D4] to-[#2563EB]', 'surface' => 'bg-emerald-50', 'line' => 'Xử lý phần việc khó để bạn không bị kẹt tiến độ'],
        ];
    @endphp

    <div class="space-y-10">
        <section data-reveal>
            <p class="text-sm font-semibold text-rose-700">Dịch vụ</p>
            <h1 class="mt-2 text-3xl font-semibold text-zinc-950">Chọn đúng dịch vụ bạn đang cần để bắt đầu nhanh hơn.</h1>
            <p class="mt-3 max-w-3xl text-sm leading-6 text-zinc-600">Bạn có thể bắt đầu từ nhu cầu thực tế: làm website mới, sửa website hiện tại, tối ưu SEO, hỗ trợ đồ án hoặc nhờ xử lý một phần việc lập trình.</p>
        </section>
        <section class="grid gap-5 md:grid-cols-2 xl:grid-cols-3" data-reveal data-mobile-card-grid data-service-visual-grid>
            @foreach ($serviceOfferings as $service)
                @php
                    $visual = $serviceVisuals[$service->service_group] ?? $serviceVisuals['website'];
                @endphp
                <article class="service-visual-card motion-card overflow-hidden rounded-[1.65rem] border border-zinc-200 bg-white shadow-sm" data-service-visual-card>
                    <div class="service-visual-card__top bg-gradient-to-br {{ $visual['gradient'] }} p-5 text-white">
                        <div class="flex items-start justify-between gap-3">
                            <div>
                                <p class="text-[0.72rem] font-semibold uppercase tracking-[0.2em] text-white/75">{{ $visual['eyebrow'] }}</p>
                                <h2 class="mt-3 text-xl font-semibold">{{ $service->name }}</h2>
                            </div>
                            <span class="service-visual-card__icon">{{ $visual['icon'] }}</span>
                        </div>
                        <div class="service-visual-card__mockup mt-5 rounded-[1.25rem] border border-white/10 bg-white/10 p-4 backdrop-blur-sm">
                            <div class="flex items-center gap-2">
                                <span class="size-2 rounded-full bg-white/70"></span>
                                <span class="size-2 rounded-full bg-white/35"></span>
                                <span class="size-2 rounded-full bg-white/25"></span>
                            </div>
                            <div class="mt-4 h-3 w-24 rounded-full bg-white/30"></div>
                            <div class="mt-3 grid grid-cols-3 gap-2">
                                <span class="h-12 rounded-2xl bg-white/14"></span>
                                <span class="h-12 rounded-2xl bg-white/12"></span>
                                <span class="h-12 rounded-2xl bg-white/10"></span>
                            </div>
                        </div>
                    </div>
                    <div class="service-visual-card__body p-5">
                        <p class="text-sm leading-6 text-zinc-600">{{ $service->short_description }}</p>
                        @if ($service->key_benefits)
                            <div class="mt-4 flex flex-wrap gap-2 text-xs font-semibold">
                                @foreach (array_slice($service->key_benefits, 0, 3) as $benefit)
                                    <span class="rounded-full px-3 py-1 {{ $visual['surface'] }} text-zinc-800">{{ $benefit }}</span>
                                @endforeach
                            </div>
                        @endif
                        <p class="mt-4 text-sm font-semibold text-zinc-950">{{ $visual['line'] }}</p>
                        <div class="service-visual-card__actions mt-5 flex flex-col gap-2 sm:flex-row sm:flex-wrap">
                            <a class="rounded-xl bg-zinc-950 px-4 py-2.5 text-sm font-semibold text-white" href="{{ route('services.show', $service) }}">Xem chi tiết</a>
                            <a class="rounded-xl border border-zinc-300 px-4 py-2.5 text-sm font-semibold text-zinc-800" href="#quote-form">Nhận tư vấn miễn phí</a>
                        </div>
                    </div>
                </article>
            @endforeach
        </section>
        <section class="grid gap-4 rounded-lg border border-zinc-200 bg-white p-5 shadow-sm lg:grid-cols-3" data-reveal>
            <div>
                <p class="text-sm font-semibold text-rose-700">Đi tiếp từ đây</p>
                <h2 class="mt-2 text-2xl font-semibold text-zinc-950">Chưa chắc mình cần gói nào?</h2>
                <p class="mt-3 text-sm leading-6 text-zinc-600">Bạn có thể xem giá tham khảo, đọc bài hướng dẫn hoặc gửi nhu cầu để được tư vấn cách làm phù hợp.</p>
            </div>
            <a class="rounded-lg border border-zinc-200 bg-amber-50 p-4 text-sm font-semibold text-zinc-900" href="{{ route('portfolio.index') }}">Xem dự án đã thực hiện</a>
            <a class="rounded-lg border border-zinc-200 bg-sky-50 p-4 text-sm font-semibold text-zinc-900" href="{{ route('blog.index') }}">Đọc bài về website, SEO và kinh nghiệm triển khai</a>
        </section>
        <x-contact-cta />
        <x-faq-list :faqs="$faqs" />
    </div>
@endsection
