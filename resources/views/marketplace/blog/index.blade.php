@extends('layouts.app')

@section('title', 'Blog về website, SEO và kinh nghiệm triển khai')
@section('meta_description', 'Blog chia sẻ kinh nghiệm làm website, tối ưu SEO, sửa giao diện và hỗ trợ đồ án theo góc nhìn dễ hiểu cho khách hàng.')
@section('canonical', $selectedPillar ? route('blog.index', ['pillar' => $selectedPillar]) : route('blog.index'))

@section('content')
    <div class="space-y-8">
        <section class="grid gap-6 rounded-3xl border border-zinc-200 bg-white p-6 shadow-sm lg:grid-cols-[1.3fr_0.7fr]">
            <div>
                <p class="text-sm font-semibold uppercase tracking-[0.24em] text-rose-700">Blog dễ hiểu cho khách mới</p>
                <h1 class="mt-3 text-3xl font-semibold text-zinc-950">Bài viết về website, SEO và cách xử lý những nhu cầu thường gặp.</h1>
                <p class="mt-3 text-sm leading-7 text-zinc-600">Nội dung được chia theo các nhóm nhu cầu thực tế như làm website, tối ưu SEO, sửa giao diện, hỗ trợ đồ án và xử lý phần việc lập trình.</p>
            </div>
            <div class="rounded-2xl border border-sky-100 bg-sky-50 p-5">
                <p class="text-sm font-semibold text-zinc-950">Đi nhanh tới nhu cầu của bạn</p>
                <div class="mt-4 space-y-2">
                    @foreach ($serviceLinks as $service)
                        <a class="block rounded-xl border border-white/70 bg-white px-4 py-3 text-sm font-semibold text-zinc-800 transition hover:-translate-y-0.5 hover:border-sky-200 hover:bg-sky-100" href="{{ route('services.show', $service) }}">{{ $service->name }}</a>
                    @endforeach
                </div>
            </div>
        </section>

        <section class="grid gap-4 lg:grid-cols-5">
            @foreach ($pillars as $pillar)
                <a href="{{ $pillar['href'] }}" class="rounded-2xl border p-4 shadow-sm transition hover:-translate-y-0.5 hover:shadow-md {{ $selectedPillar === $pillar['key'] ? 'border-rose-200 bg-rose-50' : 'border-zinc-200 bg-white' }}">
                    <p class="text-sm font-semibold text-zinc-950">{{ $pillar['label'] }}</p>
                    <p class="mt-2 text-sm leading-6 text-zinc-600">{{ $pillar['summary'] }}</p>
                    <p class="mt-3 text-xs font-semibold uppercase tracking-[0.18em] text-rose-700">{{ $pillar['count'] }} bài viết</p>
                </a>
            @endforeach
        </section>

        <section class="grid gap-4 md:grid-cols-2 xl:grid-cols-3">
            @foreach ($posts as $post)
                <article class="rounded-2xl border border-zinc-200 bg-white p-5 shadow-sm">
                    <div class="flex flex-wrap items-center gap-2 text-xs font-semibold uppercase tracking-[0.18em] text-rose-700">
                        <span>{{ $post->pillarMeta()['label'] }}</span>
                        <span class="rounded-full bg-zinc-100 px-2.5 py-1 tracking-normal text-zinc-600">{{ \App\Models\BlogPost::serviceGroupOptions()[$post->service_group] ?? 'Dịch vụ web' }}</span>
                    </div>
                    <h2 class="mt-3 text-xl font-semibold text-zinc-950">{{ $post->title }}</h2>
                    <p class="mt-3 text-sm leading-6 text-zinc-600">{{ $post->excerpt ?: \Illuminate\Support\Str::limit($post->content, 140) }}</p>
                    <div class="mt-5 flex flex-wrap gap-3 text-sm">
                        <a class="font-semibold text-rose-700" href="{{ route('blog.show', $post) }}">Đọc chi tiết</a>
                        <a class="font-semibold text-sky-700" href="{{ route('services') }}">Xem dịch vụ liên quan</a>
                    </div>
                </article>
            @endforeach
        </section>

        {{ $posts->links() }}
    </div>
@endsection
