@extends('layouts.app')

@section('title', $project->name)
@section('meta_description', $project->client_problem)

@section('content')
    @php
        $portfolioVisuals = [
            'landing_page' => ['eyebrow' => 'Landing Page', 'icon' => 'LP', 'gradient' => 'from-[#2563EB] via-[#7C3AED] to-[#06B6D4]'],
            'website' => ['eyebrow' => 'Website', 'icon' => 'WEB', 'gradient' => 'from-[#0F172A] via-[#2563EB] to-[#06B6D4]'],
            'seo' => ['eyebrow' => 'SEO Growth', 'icon' => 'SEO', 'gradient' => 'from-[#10B981] via-[#06B6D4] to-[#2563EB]'],
            'bug_fix' => ['eyebrow' => 'Fix Bug', 'icon' => 'FIX', 'gradient' => 'from-[#F97316] via-[#EF4444] to-[#7C3AED]'],
        ];
        $visual = $portfolioVisuals[$project->project_type] ?? ['eyebrow' => 'Case Study', 'icon' => 'CS', 'gradient' => 'from-[#2563EB] via-[#7C3AED] to-[#06B6D4]'];
    @endphp

    <div class="space-y-8">
        <section class="overflow-hidden rounded-[1.9rem] border border-zinc-200 bg-white shadow-[0_28px_80px_-50px_rgba(15,23,42,0.35)]" data-reveal data-portfolio-show-hero>
            <div class="grid gap-0 lg:grid-cols-[minmax(0,1.02fr)_23rem]">
                <div class="bg-zinc-950 p-6 text-white sm:p-7">
                    <div class="flex flex-wrap gap-2 text-sm">
                        <a class="font-semibold text-sky-200" href="{{ route('portfolio.index') }}">Portfolio</a>
                        <span class="text-white/35">/</span>
                        <span class="text-slate-300">{{ $project->name }}</span>
                    </div>
                    <div class="mt-6 flex items-center justify-between gap-4">
                        <div>
                            <p class="text-xs font-semibold uppercase tracking-[0.24em] text-sky-200">{{ $visual['eyebrow'] }}</p>
                            <h1 class="mt-3 text-3xl font-semibold">{{ $project->name }}</h1>
                        </div>
                        <span class="portfolio-showcase-card__icon bg-white/10 text-sky-100">{{ $visual['icon'] }}</span>
                    </div>
                    <p class="mt-4 max-w-3xl text-sm leading-7 text-slate-300">{{ $project->role_summary }}</p>

                    <div class="portfolio-showcase-card__mockup mt-6 rounded-[1.4rem] bg-gradient-to-br {{ $visual['gradient'] }} p-[1px]" data-portfolio-preview>
                        <div class="rounded-[1.35rem] bg-slate-950 p-4">
                            <div class="grid gap-3 sm:grid-cols-3">
                                <div class="rounded-2xl border border-white/10 bg-white/8 px-4 py-4">
                                    <p class="text-[11px] font-semibold uppercase tracking-[0.2em] text-sky-200">Bài toán</p>
                                    <p class="mt-2 text-xs leading-5 text-white/88">{{ $project->client_problem }}</p>
                                </div>
                                <div class="rounded-2xl border border-white/10 bg-white/8 px-4 py-4">
                                    <p class="text-[11px] font-semibold uppercase tracking-[0.2em] text-sky-200">Giải pháp</p>
                                    <p class="mt-2 text-xs leading-5 text-white/88">{{ $project->implemented_solution }}</p>
                                </div>
                                <div class="rounded-2xl border border-white/10 bg-white/8 px-4 py-4">
                                    <p class="text-[11px] font-semibold uppercase tracking-[0.2em] text-sky-200">Kết quả</p>
                                    <p class="mt-2 text-xs leading-5 text-white/88">{{ $project->outcome_summary }}</p>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="mt-6 flex flex-wrap gap-3">
                        <a class="rounded-xl bg-white px-4 py-2.5 text-sm font-semibold text-zinc-950" href="{{ $project->demo_url }}">Xem demo dự án</a>
                        <a class="rounded-xl border border-white/14 px-4 py-2.5 text-sm font-semibold text-white" href="{{ route('services') }}">Xem dịch vụ liên quan</a>
                        <a class="rounded-xl border border-white/14 px-4 py-2.5 text-sm font-semibold text-white" href="#quote-form">Nhận tư vấn cho dự án tương tự</a>
                    </div>
                </div>

                <div class="grid gap-4 bg-white p-5 sm:p-6">
                    <article class="rounded-[1.25rem] border border-zinc-200 bg-zinc-50 px-4 py-4">
                        <p class="text-xs font-semibold uppercase tracking-[0.22em] text-zinc-500">Công nghệ</p>
                        <div class="mt-3 flex flex-wrap gap-2" data-portfolio-tech-stack>
                            @foreach (($project->tech_stack ?? []) as $tech)
                                <span class="rounded-full bg-white px-3 py-1 text-xs font-semibold text-zinc-700 shadow-sm">{{ $tech }}</span>
                            @endforeach
                        </div>
                    </article>
                    <article class="rounded-[1.25rem] border border-zinc-200 bg-zinc-50 px-4 py-4">
                        <p class="text-xs font-semibold uppercase tracking-[0.22em] text-zinc-500">Phần công việc đã thực hiện</p>
                        <p class="mt-3 text-sm leading-6 text-zinc-700">{{ $project->role_summary }}</p>
                    </article>
                    <article class="rounded-[1.25rem] border border-zinc-200 bg-zinc-50 px-4 py-4">
                        <p class="text-xs font-semibold uppercase tracking-[0.22em] text-zinc-500">Kết quả nhận được</p>
                        <p class="mt-3 text-sm leading-6 text-zinc-700">{{ $project->outcome_summary }}</p>
                    </article>
                </div>
            </div>
        </section>

        <section class="grid gap-4 lg:grid-cols-3" data-reveal data-portfolio-outcome-grid>
            <article class="rounded-lg border border-rose-100 bg-rose-50 p-5">
                <p class="text-sm font-semibold text-rose-700">Bài toán</p>
                <p class="mt-2 text-sm leading-6 text-rose-950">{{ $project->client_problem }}</p>
            </article>
            <article class="rounded-lg border border-emerald-100 bg-emerald-50 p-5">
                <p class="text-sm font-semibold text-emerald-700">Giải pháp</p>
                <p class="mt-2 text-sm leading-6 text-emerald-950">{{ $project->implemented_solution }}</p>
            </article>
            <article class="rounded-lg border border-sky-100 bg-sky-50 p-5">
                <p class="text-sm font-semibold text-sky-700">Kết quả</p>
                <p class="mt-2 text-sm leading-6 text-sky-950">{{ $project->outcome_summary }}</p>
            </article>
        </section>

        <section class="grid gap-4 lg:grid-cols-[1fr_18rem]" data-reveal>
            <article class="rounded-[1.5rem] border border-zinc-200 bg-white p-5 shadow-sm">
                <p class="text-sm font-semibold text-rose-700">Nền tảng sử dụng và phần việc đã làm</p>
                <div class="mt-4 flex flex-wrap gap-2">
                    @foreach (($project->tech_stack ?? []) as $tech)
                        <span class="rounded-full bg-zinc-100 px-3 py-1 text-sm font-semibold text-zinc-700">{{ $tech }}</span>
                    @endforeach
                </div>
                <p class="mt-4 text-sm leading-6 text-zinc-600">{{ $project->role_summary }}</p>
            </article>
            <article class="rounded-[1.5rem] border border-zinc-200 bg-white p-5 shadow-sm">
                <p class="text-sm font-semibold text-rose-700">Dự án tương tự</p>
                <div class="mt-4 space-y-3 text-sm">
                    @foreach ($relatedProjects as $relatedProject)
                        <a class="block rounded-[1.1rem] border border-zinc-100 p-3 transition hover:border-rose-200 hover:bg-rose-50" href="{{ route('portfolio.show', $relatedProject) }}">
                            <span class="font-semibold text-zinc-950">{{ $relatedProject->name }}</span>
                        </a>
                    @endforeach
                </div>
            </article>
        </section>

        <x-contact-cta
            headline="Muốn làm một dự án tương tự?"
            description="Mô tả mục tiêu của bạn để nhận hướng làm, thời gian dự kiến và gợi ý triển khai gần với dự án này."
            serviceType="custom"
            buttonLabel="Nhận tư vấn cho dự án tương tự"
        />
    </div>
@endsection
