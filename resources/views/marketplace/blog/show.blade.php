@extends('layouts.app')

@section('title', $post->meta_title ?: $post->title.' | Blog website và SEO')
@section('meta_description', $post->meta_description ?: ($post->excerpt ?: \Illuminate\Support\Str::limit($post->content, 150)))
@section('canonical', route('blog.show', $post))
@section('structured_data')
    <script type="application/ld+json">
        {!! json_encode([
            '@'.'context' => 'https://schema.org',
            '@'.'type' => 'Article',
            'headline' => $post->title,
            'description' => $post->meta_description ?: ($post->excerpt ?: \Illuminate\Support\Str::limit($post->content, 150)),
            'datePublished' => optional($post->published_at)->toIso8601String(),
            'mainEntityOfPage' => route('blog.show', $post),
            'author' => [
                '@'.'type' => 'Organization',
                'name' => config('app.name', 'Web Template Studio'),
            ],
        ], JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES) !!}
    </script>
@endsection

@section('content')
    <div class="grid gap-6 xl:grid-cols-[1fr_22rem]">
        <article class="rounded-2xl border border-zinc-200 bg-white p-6 shadow-sm">
            <div class="flex flex-wrap items-center gap-2 text-xs font-semibold uppercase tracking-[0.18em] text-rose-700">
                <span>{{ $post->pillarMeta()['label'] }}</span>
                <span class="rounded-full bg-zinc-100 px-2.5 py-1 tracking-normal text-zinc-600">{{ \App\Models\BlogPost::serviceGroupOptions()[$post->service_group] ?? 'Dịch vụ web' }}</span>
            </div>
            <h1 class="mt-3 text-3xl font-semibold text-zinc-950">{{ $post->title }}</h1>
            <p class="mt-3 text-sm leading-7 text-zinc-600">{{ $post->excerpt ?: $post->pillarMeta()['summary'] }}</p>

            <div class="mt-6 whitespace-pre-line text-sm leading-7 text-zinc-700">{{ $post->content }}</div>

            <section class="mt-8 rounded-2xl border border-rose-100 bg-rose-50 p-5">
                <p class="text-sm font-semibold text-zinc-950">Đi tiếp từ bài viết này</p>
                <div class="mt-4 grid gap-3 md:grid-cols-3">
                    @foreach ($softLinks as $link)
                        <a class="rounded-xl border border-white/70 bg-white px-4 py-4 text-sm transition hover:-translate-y-0.5 hover:border-rose-200 hover:bg-rose-100" href="{{ $link['href'] }}">
                            <span class="block font-semibold text-zinc-950">{{ $link['label'] }}</span>
                            <span class="mt-1 block leading-6 text-zinc-600">{{ $link['description'] }}</span>
                        </a>
                    @endforeach
                </div>
            </section>

            @if ($relatedServices->isNotEmpty())
                <section class="mt-8">
                    <div class="flex items-center justify-between gap-3">
                        <h2 class="text-xl font-semibold text-zinc-950">Dịch vụ liên quan</h2>
                        <a class="text-sm font-semibold text-rose-700" href="{{ route('services') }}">Xem tất cả dịch vụ</a>
                    </div>
                    <div class="mt-4 grid gap-4 md:grid-cols-2">
                        @foreach ($relatedServices as $service)
                            <a class="rounded-2xl border border-zinc-200 bg-white p-4 transition hover:-translate-y-0.5 hover:border-sky-200 hover:bg-sky-50" href="{{ route('services.show', $service) }}">
                                <p class="text-sm font-semibold text-zinc-950">{{ $service->name }}</p>
                                <p class="mt-2 text-sm leading-6 text-zinc-600">{{ $service->short_description }}</p>
                            </a>
                        @endforeach
                    </div>
                </section>
            @endif
        </article>

        <aside class="space-y-6">
            @if ($relatedPosts->isNotEmpty())
                <section class="rounded-2xl border border-zinc-200 bg-white p-5 shadow-sm">
                    <h2 class="text-lg font-semibold text-zinc-950">Bài liên quan</h2>
                    <div class="mt-4 space-y-3">
                        @foreach ($relatedPosts as $related)
                            <a class="block rounded-xl border border-zinc-100 p-4 transition hover:border-rose-200 hover:bg-rose-50/50" href="{{ route('blog.show', $related) }}">
                                <p class="text-sm font-semibold text-zinc-950">{{ $related->title }}</p>
                                <p class="mt-2 text-sm leading-6 text-zinc-600">{{ $related->excerpt ?: \Illuminate\Support\Str::limit($related->content, 90) }}</p>
                            </a>
                        @endforeach
                    </div>
                </section>
            @endif

            <x-contact-cta
                :headline="'Bạn muốn áp dụng nội dung này vào website của mình?'"
                :description="'Gửi link website hoặc mô tả nhu cầu hiện tại. Bạn sẽ nhận được gợi ý cách xử lý phù hợp với tình trạng đang gặp.'"
                :service-type="$post->service_group === 'student_support' ? 'student_support' : ($post->service_group === 'ui_fix' ? 'ui_fix' : ($post->service_group === 'coding_task' ? 'coding_task' : ($post->service_group === 'seo' ? 'seo' : 'website')))"
                :button-label="'Nhận tư vấn từ bài viết này'"
            />
        </aside>
    </div>
@endsection
