@extends('layouts.app')

@section('title', 'Web Template Studio - Làm website, SEO và sửa website theo yêu cầu')
@section('meta_description', 'Web Template Studio cung cấp dịch vụ làm website, tối ưu SEO, sửa website và hỗ trợ lập trình cho shop nhỏ, cá nhân, sinh viên và khách cần xử lý nhanh.')
@section('canonical', route('home'))
@section('structured_data')
    <script type="application/ld+json">
        {!! json_encode([
            '@'.'context' => 'https://schema.org',
            '@'.'type' => 'ProfessionalService',
            'name' => config('app.name', 'Web Template Studio'),
            'url' => route('home'),
            'description' => 'Dịch vụ làm website, tối ưu SEO, sửa website và hỗ trợ đồ án cho cá nhân, shop nhỏ và doanh nghiệp nhỏ.',
            'areaServed' => 'VN',
            'serviceType' => ['Website Development', 'Landing Page', 'SEO Website', 'UI Fix', 'Technical Support'],
        ], JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES) !!}
    </script>
@endsection

@section('content')
    @php
        $serviceVisuals = [
            'seo' => [
                'eyebrow' => 'SEO Website',
                'icon' => 'SEO',
                'gradient' => 'from-[#2563EB] via-[#06B6D4] to-[#10B981]',
                'surface' => 'bg-sky-50',
            ],
            'website' => [
                'eyebrow' => 'Website Development',
                'icon' => 'WEB',
                'gradient' => 'from-[#2563EB] via-[#7C3AED] to-[#0F172A]',
                'surface' => 'bg-indigo-50',
            ],
            'ui_fix' => [
                'eyebrow' => 'Fix Bug / UI',
                'icon' => 'FIX',
                'gradient' => 'from-[#F97316] via-[#EF4444] to-[#7C3AED]',
                'surface' => 'bg-rose-50',
            ],
            'student_support' => [
                'eyebrow' => 'Student Project Support',
                'icon' => 'LAB',
                'gradient' => 'from-[#0F172A] via-[#2563EB] to-[#06B6D4]',
                'surface' => 'bg-cyan-50',
            ],
            'coding_task' => [
                'eyebrow' => 'Hỗ trợ lập trình',
                'icon' => 'DEV',
                'gradient' => 'from-[#10B981] via-[#06B6D4] to-[#2563EB]',
                'surface' => 'bg-emerald-50',
            ],
        ];

        $painPoints = [
            [
                'title' => 'Shop cần web nhưng chưa biết bắt đầu từ đâu',
                'copy' => 'Thiếu một website nhìn đáng tin, có CTA rõ và đủ thông tin để khách nhắn hỏi hoặc để lại lead.',
                'icon' => '01',
            ],
            [
                'title' => 'Website cũ nhìn thiếu tin cậy hoặc khó dùng trên mobile',
                'copy' => 'Layout rối, CTA mờ, tốc độ chậm hoặc responsive lỗi làm khách thoát trước khi liên hệ.',
                'icon' => '02',
            ],
            [
                'title' => 'Cần SEO, sửa web hoặc hỗ trợ xử lý phần việc khó',
                'copy' => 'Khách cần người nhìn đúng vấn đề, báo rõ phần việc và xử lý gọn những hạng mục đang làm chậm việc kinh doanh.',
                'icon' => '03',
            ],
            [
                'title' => 'Sinh viên cần source, báo cáo và hỗ trợ bảo vệ nhanh',
                'copy' => 'Không chỉ cần code chạy được mà còn cần tài liệu, database và giải thích flow để demo chắc hơn.',
                'icon' => '04',
            ],
        ];

        $whyChooseUs = [
            [
                'title' => 'Nhìn nhu cầu là biết nên làm gì tiếp',
                'copy' => 'Website mới, sửa giao diện, SEO hay phần việc lập trình đều được tách rõ từng hạng mục trước khi bắt đầu.',
            ],
            [
                'title' => 'Có case thật và cách bàn giao rõ',
                'copy' => 'Khách có thể xem dự án đã làm, cách triển khai và những gì sẽ nhận được sau khi bàn giao.',
            ],
            [
                'title' => 'Hợp với nhu cầu nhỏ và vừa',
                'copy' => 'Phù hợp shop nhỏ, cá nhân, sinh viên hoặc khách cần xử lý nhanh một phần việc cụ thể.',
            ],
            [
                'title' => 'Liên hệ nhanh nhưng không làm việc mơ hồ',
                'copy' => 'Có Zalo, Facebook, email và form mô tả nhu cầu ngắn để trao đổi nhanh mà không bị mơ hồ.',
            ],
        ];

        $processSteps = [
            ['label' => 'Bước 1', 'title' => 'Nhận nhu cầu', 'copy' => 'Làm rõ mục tiêu, thời gian mong muốn và tình trạng hiện tại để xác định đúng vấn đề.'],
            ['label' => 'Bước 2', 'title' => 'Thống nhất công việc', 'copy' => 'Tách rõ từng hạng mục, đầu ra và mức ưu tiên để tránh làm lan man.'],
            ['label' => 'Bước 3', 'title' => 'Triển khai', 'copy' => 'Tiến hành làm website, sửa web, tối ưu SEO hoặc xử lý phần việc cần thiết theo kế hoạch đã thống nhất.'],
            ['label' => 'Bước 4', 'title' => 'Bàn giao dễ theo dõi', 'copy' => 'Gửi kết quả, hướng dẫn cần thiết và hỗ trợ chỉnh sửa nhỏ sau khi nghiệm thu.'],
        ];

        $feedbackItems = $testimonials->isNotEmpty()
            ? $testimonials->take(3)
            : collect([
                (object) ['name' => 'Chủ shop mỹ phẩm', 'avatar_label' => 'SM', 'trust_tag' => 'CTA rõ hơn', 'content' => 'Khách vào là hiểu ngay shop bán gì và nhắn Zalo nhiều hơn trước.'],
                (object) ['name' => 'Khách sửa web', 'avatar_label' => 'FX', 'trust_tag' => 'Fix nhanh', 'content' => 'Phần giao diện và responsive được xử lý gọn, có note rõ chứ không sửa mơ hồ.'],
                (object) ['name' => 'Sinh viên Laravel', 'avatar_label' => 'SV', 'trust_tag' => 'Bàn giao dễ hiểu', 'content' => 'Có source, database và giải thích flow nên demo đồ án nhẹ đầu hơn nhiều.'],
            ]);
    @endphp

    <div class="space-y-16">
        <section class="hero-agency relative overflow-hidden rounded-[2rem] border border-sky-100/70 bg-[radial-gradient(circle_at_top_left,_rgba(37,99,235,0.22),_transparent_32%),radial-gradient(circle_at_85%_15%,_rgba(124,58,237,0.18),_transparent_28%),linear-gradient(135deg,_rgba(15,23,42,0.98),_rgba(15,23,42,0.88)_38%,_rgba(30,41,59,0.94)_100%)] shadow-[0_32px_80px_-42px_rgba(15,23,42,0.85)]" data-reveal data-landing-section="hero" data-hero-section>
            <div class="hero-agency__blur hero-agency__blur--primary"></div>
            <div class="hero-agency__blur hero-agency__blur--secondary"></div>
            <div class="grid gap-10 px-5 py-6 sm:px-7 sm:py-8 lg:grid-cols-[minmax(0,1fr)_minmax(20rem,0.92fr)] lg:items-center lg:px-10 lg:py-10">
                <div class="relative z-10">
                    <p class="inline-flex rounded-full border border-white/10 bg-white/8 px-4 py-2 text-xs font-semibold uppercase tracking-[0.24em] text-sky-200">Dịch vụ website, SEO và sửa web cho khách cần triển khai nhanh</p>
                    <h1 class="mt-6 max-w-4xl text-4xl font-semibold leading-[1.04] text-white sm:text-5xl lg:text-6xl">Bạn cần làm website, sửa website hoặc nhờ xử lý một phần việc khó?</h1>
                    <p class="mt-5 max-w-2xl text-base leading-7 text-slate-300 sm:text-lg">Trang này dành cho shop nhỏ, cá nhân, sinh viên và khách cần người hỗ trợ làm web, tối ưu SEO, sửa giao diện hoặc xử lý phần việc lập trình rõ ràng, dễ theo dõi.</p>

                    <div class="mt-7 flex flex-wrap gap-3 text-sm text-white/90" data-hero-service-bullets>
                        @foreach ([
                            'Website mới hoặc landing page chốt lead',
                            'Sửa website, tối ưu SEO, cải thiện trải nghiệm liên hệ',
                            'Xử lý phần việc lập trình đang làm bạn chậm tiến độ',
                            'Hỗ trợ đồ án và dự án cần bàn giao dễ hiểu',
                        ] as $bullet)
                            <span class="rounded-full border border-white/10 bg-white/7 px-4 py-2 font-semibold backdrop-blur-sm">{{ $bullet }}</span>
                        @endforeach
                    </div>

                    <div class="mt-8 flex flex-col gap-3 sm:flex-row" data-hero-cta-group>
                        <a class="inline-flex justify-center rounded-xl bg-[#2563EB] px-5 py-3.5 text-sm font-semibold text-white shadow-[0_18px_38px_-20px_rgba(37,99,235,0.9)] transition hover:-translate-y-0.5 hover:bg-[#1D4ED8]" href="#quote-form">Nhận tư vấn miễn phí</a>
                        <a class="inline-flex justify-center rounded-xl border border-white/14 bg-white/8 px-5 py-3.5 text-sm font-semibold text-white transition hover:-translate-y-0.5 hover:bg-white/14" href="{{ route('portfolio.index') }}">Xem dự án tiêu biểu</a>
                    </div>

                    <div class="mt-8 grid gap-3 text-sm sm:grid-cols-3" data-hero-trust-strip>
                        @foreach ([
                            ['Phản hồi trong 15-60 phút', 'khi nhu cầu đã đủ rõ và có đầu bài cụ thể'],
                            ['Thống nhất công việc trước khi làm', 'để tránh sửa nhiều nhưng không đúng vấn đề chính'],
                            ['Bàn giao có hướng dẫn', 'phù hợp cả khách kinh doanh lẫn sinh viên cần tự vận hành'],
                        ] as [$title, $copy])
                            <article class="rounded-2xl border border-white/10 bg-white/7 px-4 py-4 text-slate-100 backdrop-blur-sm">
                                <p class="font-semibold">{{ $title }}</p>
                                <p class="mt-1 text-xs leading-6 text-slate-300">{{ $copy }}</p>
                            </article>
                        @endforeach
                    </div>
                </div>

                <div class="hero-visual relative z-10" aria-label="Visual giới thiệu dịch vụ website và SEO" data-hero-visuals>
                    <div class="hero-visual__backdrop rounded-[2rem] border border-white/10 bg-white/7 p-3 backdrop-blur-sm">
                        <div class="hero-visual__surface relative overflow-hidden rounded-[1.5rem] border border-white/10 bg-slate-950/96 shadow-[0_30px_70px_-38px_rgba(15,23,42,0.9)]">
                            <div class="hero-visual__frame flex items-center justify-between border-b border-white/10 px-4 py-3 text-xs text-slate-300">
                                <div class="flex items-center gap-2">
                                    <span class="size-2.5 rounded-full bg-rose-400"></span>
                                    <span class="size-2.5 rounded-full bg-amber-400"></span>
                                    <span class="size-2.5 rounded-full bg-emerald-400"></span>
                                </div>
                                <span class="rounded-full bg-white/8 px-3 py-1 font-semibold text-sky-200">Tổng quan dịch vụ</span>
                            </div>
                            <div class="grid gap-4 p-4 sm:p-5">
                                <div class="rounded-[1.3rem] border border-white/10 bg-[radial-gradient(circle_at_top_left,_rgba(255,255,255,0.08),_transparent_28%),linear-gradient(160deg,_rgba(15,23,42,0.96),_rgba(30,41,59,0.92))] p-4 text-white">
                                    <p class="text-[0.72rem] font-semibold uppercase tracking-[0.22em] text-sky-200">Nhìn là hiểu ngay</p>
                                    <h2 class="mt-2 text-2xl font-semibold leading-tight">Khách mới cần thấy ngay bạn đang cung cấp dịch vụ gì và nên liên hệ thế nào.</h2>
                                    <p class="mt-3 text-sm leading-6 text-slate-300">Tập trung vào website, SEO, sửa web và điểm liên hệ rõ ràng để người xem quyết định nhanh hơn.</p>
                                </div>
                                <div class="grid gap-4 lg:grid-cols-[1.05fr_0.95fr]">
                                    <div class="rounded-[1.2rem] border border-white/10 bg-white/7 p-4 backdrop-blur-sm">
                                        <p class="text-[0.68rem] font-semibold uppercase tracking-[0.22em] text-slate-400">Bố cục dễ theo dõi</p>
                                        <div class="mt-4 space-y-3">
                                            <div class="h-3 w-28 rounded-full bg-sky-300/35"></div>
                                            <div class="rounded-[1rem] border border-white/8 bg-slate-900/80 p-4">
                                                <div class="grid gap-3 sm:grid-cols-3">
                                                    <span class="h-14 rounded-2xl border border-white/8 bg-white/9"></span>
                                                    <span class="h-14 rounded-2xl border border-white/8 bg-white/9"></span>
                                                    <span class="h-14 rounded-2xl border border-white/8 bg-white/9"></span>
                                                </div>
                                                <div class="mt-4 rounded-[1rem] border border-white/8 bg-gradient-to-r from-white/10 to-transparent p-4">
                                                    <div class="h-3 w-4/5 rounded-full bg-white/12"></div>
                                                    <div class="mt-3 h-2.5 w-11/12 rounded-full bg-white/10"></div>
                                                    <div class="mt-2 h-2.5 w-2/3 rounded-full bg-white/10"></div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="space-y-3">
                                        <div class="rounded-[1.2rem] border border-white/10 bg-white/7 p-4 backdrop-blur-sm">
                                            <p class="text-[0.68rem] font-semibold uppercase tracking-[0.22em] text-slate-400">Dịch vụ nổi bật</p>
                                            <div class="hero-code mt-3 rounded-[1rem] bg-slate-950/90 px-4 py-3 text-[0.8rem] leading-6 text-emerald-300">
                                                <span class="block">Website giới thiệu, landing page, catalog sản phẩm</span>
                                                <span class="block">Sửa giao diện, form liên hệ, phiên bản mobile</span>
                                                <span class="block">SEO website, hỗ trợ đồ án, xử lý phần việc lập trình</span>
                                            </div>
                                        </div>
                                        <div class="rounded-[1.2rem] border border-white/10 bg-white/7 p-4 backdrop-blur-sm">
                                            <div class="flex items-end justify-between gap-3">
                                                <div>
                                                    <p class="text-[0.68rem] font-semibold uppercase tracking-[0.22em] text-slate-400">Điều khách cần thấy</p>
                                                    <p class="mt-1 text-lg font-semibold text-white">Rõ dịch vụ, rõ cách liên hệ, rõ kết quả</p>
                                                </div>
                                                <span class="rounded-full bg-emerald-400/12 px-2.5 py-1 text-xs font-semibold text-emerald-200">đã tinh gọn</span>
                                            </div>
                                            <div class="mt-4 flex h-24 items-end gap-2">
                                                @foreach ([36, 52, 68, 84] as $height)
                                                    <span class="hero-chart__bar rounded-t-full bg-gradient-to-t from-cyan-400 to-emerald-300" style="height: {{ $height }}%"></span>
                                                @endforeach
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>

        <section class="space-y-4" data-reveal data-landing-section="services">
            <div class="flex items-end justify-between gap-4">
                <div class="max-w-3xl">
                    <p class="text-sm font-semibold text-rose-700">Dịch vụ chính</p>
                </div>
                <a class="text-sm font-semibold text-rose-700" href="{{ route('services') }}">Xem catalog đầy đủ</a>
            </div>

            <div class="grid gap-5 md:grid-cols-2" data-service-visual-grid>
                @foreach ($featuredServices->take(4) as $service)
                    @php
                        $visual = $serviceVisuals[$service->service_group] ?? $serviceVisuals['website'];
                    @endphp
                    <article class="service-visual-card motion-card overflow-hidden rounded-[1.65rem] border border-zinc-200 bg-white shadow-sm" data-reveal data-service-visual-card style="--reveal-delay: {{ $loop->index * 70 }}ms">
                        <div class="service-visual-card__top bg-gradient-to-br {{ $visual['gradient'] }} p-5 text-white">
                            <div class="flex items-start justify-between gap-3">
                                <div>
                                    <p class="text-[0.72rem] font-semibold uppercase tracking-[0.2em] text-white/75">{{ $visual['eyebrow'] }}</p>
                                    <h3 class="mt-3 text-xl font-semibold">{{ $service->name }}</h3>
                                </div>
                                <span class="service-visual-card__icon">{{ $visual['icon'] }}</span>
                            </div>
                            <div class="service-visual-card__mockup mt-5 rounded-[1.25rem] border border-white/10 bg-white/10 p-4 backdrop-blur-sm">
                                <div class="flex items-center gap-2">
                                    <span class="size-2 rounded-full bg-white/70"></span>
                                    <span class="size-2 rounded-full bg-white/35"></span>
                                    <span class="size-2 rounded-full bg-white/25"></span>
                                </div>
                                <div class="mt-4 h-3 w-28 rounded-full bg-white/30"></div>
                                <div class="mt-3 grid grid-cols-3 gap-2">
                                    <span class="h-14 rounded-2xl bg-white/14"></span>
                                    <span class="h-14 rounded-2xl bg-white/12"></span>
                                    <span class="h-14 rounded-2xl bg-white/10"></span>
                                </div>
                            </div>
                        </div>
                        <div class="service-visual-card__body p-5">
                            <p class="text-sm leading-6 text-zinc-600">{{ $service->short_description }}</p>
                            @if ($service->key_benefits)
                                <div class="mt-4 flex flex-wrap gap-2 text-xs font-semibold">
                                    @foreach (array_slice($service->key_benefits, 0, 2) as $benefit)
                                        <span class="rounded-full px-3 py-1 {{ $visual['surface'] }} text-zinc-800">{{ $benefit }}</span>
                                    @endforeach
                                </div>
                            @endif
                            <div class="service-visual-card__actions mt-5 flex flex-col gap-2 sm:flex-row">
                                <a class="rounded-xl bg-zinc-950 px-4 py-2.5 text-sm font-semibold text-white" href="{{ route('services.show', $service) }}">Xem chi tiết</a>
                                <a class="rounded-xl border border-zinc-300 px-4 py-2.5 text-sm font-semibold text-zinc-800" href="#quote-form">Nhận tư vấn</a>
                            </div>
                        </div>
                    </article>
                @endforeach
            </div>
        </section>
        <x-contact-cta
            headline="Mô tả ngắn nhu cầu để nhận hướng làm và mốc thời gian phù hợp."
            description="Nếu bạn cần website mới, sửa web, tối ưu SEO, hỗ trợ đồ án hoặc nhờ xử lý một phần việc khó, đây là cách bắt đầu nhanh và rõ ràng nhất."
            buttonLabel="Nhận hướng tư vấn phù hợp"
        />
    </div>
@endsection
