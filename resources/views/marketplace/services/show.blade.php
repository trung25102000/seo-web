@extends('layouts.app')

@section('title', $service->name)
@section('meta_description', $service->short_description)
@section('canonical', route('services.show', $service))
@section('structured_data')
    <script type="application/ld+json">
        {!! json_encode([
            '@'.'context' => 'https://schema.org',
            '@'.'type' => 'Service',
            'name' => $service->name,
            'description' => $service->short_description,
            'serviceType' => $service->service_group,
            'provider' => [
                '@'.'type' => 'ProfessionalService',
                'name' => config('app.name', 'Web Template Studio'),
                'url' => route('home'),
            ],
            'url' => route('services.show', $service),
        ], JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES) !!}
    </script>
@endsection

@section('content')
    <div class="space-y-8">
        <section class="rounded-lg border border-zinc-200 bg-white p-6 shadow-sm" data-reveal>
            <div class="flex flex-wrap gap-2 text-sm">
                <a class="font-semibold text-rose-700" href="{{ route('home') }}">Trang chủ</a>
                <span class="text-zinc-400">/</span>
                <a class="font-semibold text-rose-700" href="{{ route('services') }}">Dịch vụ</a>
                <span class="text-zinc-400">/</span>
                <span class="text-zinc-600">{{ $service->name }}</span>
            </div>
                <p class="mt-4 text-sm font-semibold uppercase text-rose-700">{{ str_replace('_', ' ', $service->service_group) }}</p>
                <h1 class="mt-2 text-3xl font-semibold text-zinc-950">{{ $service->name }}</h1>
                <p class="mt-3 max-w-3xl text-sm leading-7 text-zinc-600">{{ $service->detail_description }}</p>
            <div class="mt-5 flex flex-col gap-3 sm:flex-row sm:flex-wrap" data-mobile-hero-cta>
                <a class="rounded-md bg-rose-600 px-4 py-2 text-sm font-semibold text-white" href="#quote-form">Nhận báo giá cho dịch vụ này</a>
                <a class="rounded-md border border-zinc-300 px-4 py-2 text-sm font-semibold text-zinc-800" href="{{ route('portfolio.index') }}">Xem dự án đã thực hiện</a>
                <a class="rounded-md border border-zinc-300 px-4 py-2 text-sm font-semibold text-zinc-800" href="{{ route('blog.index') }}">{{ $blueprint['blog_cta'] }}</a>
            </div>
        </section>

        <section class="grid gap-4 lg:grid-cols-3" data-reveal>
            <article class="rounded-lg border border-rose-100 bg-rose-50 p-5">
                <p class="text-sm font-semibold text-rose-700">Vấn đề khách thường gặp</p>
                <ul class="mt-3 space-y-2 text-sm leading-6 text-rose-950">
                    @foreach ($blueprint['problems'] as $problem)
                        <li>• {{ $problem }}</li>
                    @endforeach
                </ul>
            </article>
            <article class="rounded-lg border border-emerald-100 bg-emerald-50 p-5">
                <p class="text-sm font-semibold text-emerald-700">Giải pháp cung cấp</p>
                <ul class="mt-3 space-y-2 text-sm leading-6 text-emerald-950">
                    @foreach ($service->key_benefits ?? [] as $benefit)
                        <li>• {{ $benefit }}</li>
                    @endforeach
                </ul>
            </article>
            <article class="rounded-lg border border-sky-100 bg-sky-50 p-5">
                <p class="text-sm font-semibold text-sky-700">Đối tượng phù hợp</p>
                <ul class="mt-3 space-y-2 text-sm leading-6 text-sky-950">
                    @foreach ($service->target_audiences ?? [] as $audience)
                        <li>• {{ $audience }}</li>
                    @endforeach
                </ul>
            </article>
        </section>

        <section class="grid gap-4 lg:grid-cols-2" data-reveal>
            <article class="rounded-lg border border-zinc-200 bg-white p-5 shadow-sm">
                <p class="text-sm font-semibold text-rose-700">Bạn sẽ được hỗ trợ những gì</p>
                <ul class="mt-3 space-y-2 text-sm leading-6 text-zinc-700">
                    @foreach ($blueprint['scope'] as $item)
                        <li>• {{ $item }}</li>
                    @endforeach
                </ul>
            </article>
            <article class="rounded-lg border border-zinc-200 bg-white p-5 shadow-sm">
                <p class="text-sm font-semibold text-rose-700">Nền tảng hoặc công cụ liên quan</p>
                <div class="mt-3 flex flex-wrap gap-2">
                    @foreach ($blueprint['technologies'] as $tech)
                        <span class="rounded-full bg-zinc-100 px-3 py-1 text-sm font-semibold text-zinc-700">{{ $tech }}</span>
                    @endforeach
                </div>
                <p class="mt-5 text-sm font-semibold text-zinc-950">Thời gian tham khảo</p>
                <p class="mt-2 text-sm leading-6 text-zinc-600">{{ $blueprint['timeline'] }}</p>
                <p class="mt-4 text-sm font-semibold text-zinc-950">Lưu ý về chi phí</p>
                <p class="mt-2 text-sm leading-6 text-zinc-600">{{ $service->pricing_note }}</p>
            </article>
        </section>

        <section class="rounded-lg border border-zinc-200 bg-white p-5 shadow-sm" data-reveal>
            <p class="text-sm font-semibold text-rose-700">Quy trình làm việc</p>
            <div class="mt-4 grid gap-3 md:grid-cols-3">
                @foreach ($service->process_steps ?? [] as $step)
                    <article class="rounded-lg border border-zinc-100 bg-zinc-50 p-4">
                        <p class="text-sm font-semibold text-zinc-950">{{ $loop->iteration }}. {{ $step }}</p>
                    </article>
                @endforeach
            </div>
        </section>

        <section class="grid gap-4 lg:grid-cols-2" data-reveal>
            <article class="rounded-lg border border-zinc-200 bg-white p-5 shadow-sm">
                <p class="text-sm font-semibold text-rose-700">Dịch vụ liên quan</p>
                <div class="mt-4 space-y-3">
                    @foreach ($relatedServices as $relatedService)
                        <a class="block rounded-lg border border-zinc-100 p-4 transition hover:border-rose-200 hover:bg-rose-50" href="{{ route('services.show', $relatedService) }}">
                            <p class="font-semibold text-zinc-950">{{ $relatedService->name }}</p>
                            <p class="mt-1 text-sm text-zinc-600">{{ $relatedService->short_description }}</p>
                        </a>
                    @endforeach
                </div>
            </article>
            <article class="rounded-lg border border-zinc-200 bg-white p-5 shadow-sm">
                <p class="text-sm font-semibold text-rose-700">Bài viết liên quan</p>
                <div class="mt-4 space-y-3">
                    @foreach ($posts as $post)
                        <a class="block rounded-lg border border-zinc-100 p-4 transition hover:border-sky-200 hover:bg-sky-50" href="{{ route('blog.show', $post) }}">
                            <p class="font-semibold text-zinc-950">{{ $post->title }}</p>
                            <p class="mt-1 text-sm text-zinc-600">{{ $post->excerpt }}</p>
                        </a>
                    @endforeach
                </div>
            </article>
        </section>

        @if ($testimonials->isNotEmpty())
            <section class="space-y-4" data-reveal>
                <div>
                    <p class="text-sm font-semibold text-rose-700">Feedback từ khách hàng tương tự</p>
                    <h2 class="mt-2 text-2xl font-semibold text-zinc-950">Những gì khách đã nhận được sau khi triển khai dịch vụ này.</h2>
                </div>
                <div class="grid gap-4 md:grid-cols-3">
                    @foreach ($testimonials as $testimonial)
                        <article class="rounded-lg border border-zinc-200 bg-white p-5 shadow-sm">
                            <div class="flex items-center gap-3">
                                <span class="grid size-10 place-items-center rounded-full bg-rose-100 text-sm font-semibold text-rose-700">{{ $testimonial->avatar_label }}</span>
                                <div>
                                    <p class="font-semibold text-zinc-950">{{ $testimonial->name }}</p>
                                    <p class="text-xs uppercase text-zinc-500">{{ $testimonial->audience_type }}</p>
                                </div>
                            </div>
                            <p class="mt-3 text-sm leading-6 text-zinc-700">“{{ $testimonial->content }}”</p>
                            <div class="mt-4 flex items-center justify-between">
                                <p class="text-sm font-semibold text-zinc-950">{{ $testimonial->trust_tag }}</p>
                                <p class="text-sm text-amber-500">{{ str_repeat('★', $testimonial->rating) }}</p>
                            </div>
                        </article>
                    @endforeach
                </div>
            </section>
        @endif

        <x-contact-cta
            :headline="'Mô tả nhu cầu cho dịch vụ: '.$service->name"
            :description="$service->short_description"
            :service-type="$service->service_group === 'student_support' ? 'student_support' : 'custom'"
            button-label="Nhận tư vấn cho dịch vụ này"
        />
    </div>
@endsection
