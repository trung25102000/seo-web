@extends('layouts.app')

@section('title', 'Dự án đã thực hiện')
@section('meta_description', 'Xem các dự án website, landing page, SEO và hỗ trợ lập trình đã triển khai để đánh giá cách làm và kết quả thực tế.')

@section('content')
    @php
        $portfolioVisuals = [
            'landing_page' => ['eyebrow' => 'Landing Page', 'icon' => 'LP', 'gradient' => 'from-[#2563EB] via-[#7C3AED] to-[#06B6D4]'],
            'website' => ['eyebrow' => 'Website', 'icon' => 'WEB', 'gradient' => 'from-[#0F172A] via-[#2563EB] to-[#06B6D4]'],
            'seo' => ['eyebrow' => 'SEO Growth', 'icon' => 'SEO', 'gradient' => 'from-[#10B981] via-[#06B6D4] to-[#2563EB]'],
            'bug_fix' => ['eyebrow' => 'Fix Bug', 'icon' => 'FIX', 'gradient' => 'from-[#F97316] via-[#EF4444] to-[#7C3AED]'],
        ];
    @endphp

    <div class="space-y-8">
        <section class="overflow-hidden rounded-[1.9rem] border border-zinc-200 bg-[radial-gradient(circle_at_top_left,_rgba(37,99,235,0.14),_transparent_26%),radial-gradient(circle_at_80%_18%,_rgba(124,58,237,0.14),_transparent_20%),linear-gradient(135deg,_rgba(255,255,255,0.98),_rgba(244,244,245,0.96))] p-6 shadow-[0_24px_70px_-48px_rgba(15,23,42,0.35)]" data-reveal data-portfolio-index-hero>
            <div class="grid gap-6 lg:grid-cols-[minmax(0,1.05fr)_20rem] lg:items-end">
                <div>
                    <p class="text-sm font-semibold text-rose-700">Portfolio</p>
                    <h1 class="mt-2 text-3xl font-semibold text-zinc-950">Dự án đã thực hiện để bạn xem cách làm thực tế.</h1>
                    <p class="mt-3 max-w-3xl text-sm leading-7 text-zinc-600">Mỗi dự án cho thấy khách đang gặp vấn đề gì, đã được xử lý ra sao và kết quả nhận được để bạn dễ đánh giá trước khi liên hệ.</p>
                </div>
                <div class="grid gap-3 sm:grid-cols-3 lg:grid-cols-1">
                    <article class="rounded-[1.2rem] border border-white/80 bg-white/90 px-4 py-4 shadow-sm">
                        <p class="text-xs font-semibold uppercase tracking-[0.22em] text-zinc-500">Case study</p>
                        <p class="mt-2 text-2xl font-semibold text-zinc-950">{{ $projects->total() }}</p>
                    </article>
                    <article class="rounded-[1.2rem] border border-white/80 bg-white/90 px-4 py-4 shadow-sm">
                        <p class="text-xs font-semibold uppercase tracking-[0.22em] text-zinc-500">Điểm đáng xem</p>
                        <p class="mt-2 text-sm font-semibold text-zinc-950">Cách làm, kết quả và bản demo</p>
                    </article>
                    <article class="rounded-[1.2rem] border border-white/80 bg-white/90 px-4 py-4 shadow-sm">
                        <p class="text-xs font-semibold uppercase tracking-[0.22em] text-zinc-500">CTA</p>
                        <a class="mt-2 inline-flex text-sm font-semibold text-rose-700" href="#quote-form">Nhận tư vấn dự án tương tự</a>
                    </article>
                </div>
            </div>
        </section>

        <section class="grid gap-5 xl:grid-cols-2" data-reveal data-portfolio-showcase-grid>
            @foreach ($projects as $project)
                @php
                    $visual = $portfolioVisuals[$project->project_type] ?? ['eyebrow' => 'Case Study', 'icon' => 'CS', 'gradient' => 'from-[#2563EB] via-[#7C3AED] to-[#06B6D4]'];
                    $projectLabel = $project->websiteTemplate?->name ?: ($project->sourceCodeProduct?->name ?: 'Dự án triển khai theo yêu cầu');
                @endphp
                <article class="portfolio-showcase-card overflow-hidden rounded-[1.8rem] border border-zinc-200 bg-white shadow-[0_24px_70px_-48px_rgba(15,23,42,0.35)]" data-portfolio-card>
                    <div class="bg-zinc-950 p-5 text-white">
                        <div class="rounded-[1.3rem] bg-gradient-to-br {{ $visual['gradient'] }} p-[1px]">
                            <div class="portfolio-showcase-card__mockup rounded-[1.25rem] bg-slate-950 p-4" data-portfolio-preview>
                                <div class="flex items-center justify-between text-xs text-slate-300">
                                    <p class="font-semibold uppercase tracking-[0.22em] text-sky-200">{{ $visual['eyebrow'] }}</p>
                                    <span class="portfolio-showcase-card__icon bg-white/10 text-sky-100">{{ $visual['icon'] }}</span>
                                </div>
                                <h2 class="mt-4 text-xl font-semibold">{{ $project->name }}</h2>
                                <p class="mt-2 text-sm text-slate-300">{{ $projectLabel }}</p>
                                <div class="mt-4 grid gap-3 sm:grid-cols-3">
                                    <div class="rounded-2xl border border-white/10 bg-white/8 px-3 py-3">
                                        <p class="text-[11px] font-semibold uppercase tracking-[0.2em] text-sky-200">Bài toán</p>
                                        <p class="mt-2 text-xs leading-5 text-white/88">{{ $project->client_problem }}</p>
                                    </div>
                                    <div class="rounded-2xl border border-white/10 bg-white/8 px-3 py-3">
                                        <p class="text-[11px] font-semibold uppercase tracking-[0.2em] text-sky-200">Vai trò</p>
                                        <p class="mt-2 text-xs leading-5 text-white/88">{{ $project->role_summary }}</p>
                                    </div>
                                    <div class="rounded-2xl border border-white/10 bg-white/8 px-3 py-3">
                                        <p class="text-[11px] font-semibold uppercase tracking-[0.2em] text-sky-200">Kết quả</p>
                                        <p class="mt-2 text-xs leading-5 text-white/88">{{ $project->outcome_summary }}</p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="portfolio-showcase-card__body space-y-4 p-5">
                        <div class="flex flex-wrap gap-2" data-portfolio-tech-stack>
                            @foreach (($project->tech_stack ?? []) as $tech)
                                <span class="rounded-full bg-zinc-100 px-3 py-1 text-xs font-semibold text-zinc-700">{{ $tech }}</span>
                            @endforeach
                        </div>
                        <div class="grid gap-3 sm:grid-cols-2">
                            <div class="rounded-[1.2rem] border border-zinc-200 bg-zinc-50 px-4 py-4">
                                <p class="text-xs font-semibold uppercase tracking-[0.2em] text-zinc-500">Cách xử lý</p>
                                <p class="mt-2 text-sm leading-6 text-zinc-700">{{ $project->implemented_solution }}</p>
                            </div>
                            <div class="rounded-[1.2rem] border border-zinc-200 bg-zinc-50 px-4 py-4">
                                <p class="text-xs font-semibold uppercase tracking-[0.2em] text-zinc-500">Kết quả nhận được</p>
                                <p class="mt-2 text-sm leading-6 text-zinc-700">{{ $project->outcome_summary }}</p>
                            </div>
                        </div>
                        <div class="portfolio-showcase-card__actions flex flex-wrap gap-3">
                            <a class="rounded-xl bg-zinc-950 px-4 py-2.5 text-sm font-semibold text-white" href="{{ route('portfolio.show', $project) }}">Xem chi tiết</a>
                            <a class="rounded-xl border border-zinc-300 px-4 py-2.5 text-sm font-semibold text-zinc-800" href="{{ $project->demo_url }}">Xem demo</a>
                        </div>
                    </div>
                </article>
            @endforeach
        </section>

        {{ $projects->links() }}
    </div>
@endsection
