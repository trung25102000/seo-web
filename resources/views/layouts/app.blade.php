<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">
        <meta name="description" content="@yield('meta_description', 'Web Template Studio cung cấp dịch vụ làm website, SEO, sửa website và hỗ trợ lập trình cho shop nhỏ, cá nhân và sinh viên.')">
        <meta name="robots" content="@yield('meta_robots', 'index,follow')">
        <link rel="canonical" href="@yield('canonical', url()->current())">
        <title>@yield('title', config('app.name'))</title>
        @hasSection('structured_data')
            @yield('structured_data')
        @endif
        @vite(['resources/css/app.css', 'resources/js/app.js'])
    </head>
    <body class="site-body min-h-screen text-zinc-950 antialiased" data-visual-system>
        <a class="sr-only focus:not-sr-only focus:absolute focus:left-4 focus:top-4 focus:z-50 focus:rounded-md focus:bg-white focus:px-4 focus:py-2 focus:text-sm focus:font-semibold focus:text-zinc-950" href="#main-content">Bỏ qua tới nội dung chính</a>
        <div class="site-shell min-h-screen">
            <div class="site-particles" aria-hidden="true" data-background-particles>
                <span class="site-particle site-particle--one"></span>
                <span class="site-particle site-particle--two"></span>
                <span class="site-particle site-particle--three"></span>
            </div>
            <div class="border-b border-sky-100 bg-sky-50/90">
                <div class="mx-auto flex max-w-7xl flex-wrap items-center justify-between gap-2 px-4 py-2 text-xs text-zinc-700 sm:px-6 lg:px-8">
                    <p><span class="font-semibold text-zinc-950">Phản hồi nhanh:</span> thường trong 15-60 phút qua Zalo hoặc điện thoại trong giờ làm việc.</p>
                    <p class="font-semibold text-zinc-800">Zalo, Facebook và Email luôn có ở góc phải dưới để liên hệ nhanh.</p>
                </div>
            </div>
            <header class="border-b border-amber-100 bg-white/95">
                <div class="mx-auto flex max-w-7xl flex-col gap-4 px-4 py-4 sm:px-6 lg:flex-row lg:items-center lg:justify-between lg:px-8">
                    <a href="{{ route('home') }}" class="flex items-center gap-3">
                        <span class="grid size-10 place-items-center rounded-lg bg-rose-600 text-sm font-semibold text-white">WEB</span>
                        <span>
                            <span class="block text-sm font-semibold text-zinc-950">{{ config('app.name', 'Web Template Studio') }}</span>
                            <span class="block text-xs text-rose-700">Website, SEO, sửa web và hỗ trợ đồ án</span>
                        </span>
                    </a>

                    <nav class="flex flex-wrap items-center gap-2 text-sm">
                        <a class="rounded-md px-3 py-2 text-zinc-600 hover:bg-amber-50 hover:text-rose-700" href="{{ route('services') }}">Dịch vụ</a>
                        <a class="rounded-md px-3 py-2 text-zinc-600 hover:bg-amber-50 hover:text-rose-700" href="{{ route('templates.index') }}">Mẫu web</a>
                        <a class="rounded-md px-3 py-2 text-zinc-600 hover:bg-amber-50 hover:text-rose-700" href="{{ route('blog.index') }}">Blog</a>
                        @auth
                            @can('access-admin')
                                <a class="rounded-md px-3 py-2 text-zinc-600 hover:bg-amber-50 hover:text-rose-700" href="{{ route('admin.dashboard') }}">Admin</a>
                            @else
                                <a class="rounded-md px-3 py-2 text-zinc-600 hover:bg-amber-50 hover:text-rose-700" href="{{ route('home') }}">Trang chủ</a>
                            @endcan
                            <form method="POST" action="{{ route('logout') }}">
                                @csrf
                                <button class="rounded-md px-3 py-2 text-zinc-600 hover:bg-amber-50 hover:text-rose-700" type="submit">Đăng xuất</button>
                            </form>
                        @else
                            <a class="rounded-md px-3 py-2 text-zinc-600 hover:bg-amber-50 hover:text-rose-700" href="{{ route('login') }}">Đăng nhập</a>
                            <a class="rounded-md bg-rose-600 px-3 py-2 font-medium text-white hover:bg-rose-700" href="#quote-form">Nhận tư vấn miễn phí</a>
                        @endauth
                    </nav>
                </div>
            </header>

            <main id="main-content" class="site-surface mx-auto max-w-7xl px-4 py-8 pb-28 sm:px-6 md:pb-10 lg:px-8">
                @if (session('status'))
                    <div class="mb-6 rounded-lg border border-emerald-200 bg-emerald-50 px-4 py-3 text-sm font-medium text-emerald-800">
                        {{ session('status') }}
                    </div>
                @endif
                @yield('content')
            </main>

            <footer class="site-footer border-t border-white/10 bg-[linear-gradient(135deg,rgba(15,23,42,0.98),rgba(30,41,59,0.96),rgba(37,99,235,0.92))] text-white" data-footer-emphasis>
                <div class="mx-auto grid max-w-7xl gap-6 px-4 py-8 sm:px-6 lg:grid-cols-[minmax(0,1.1fr)_minmax(18rem,0.9fr)] lg:px-8">
                    <div class="space-y-4">
                        <div class="flex items-center gap-3">
                            <span class="grid size-11 place-items-center rounded-xl bg-white/10 text-sm font-semibold text-white">WEB</span>
                            <div>
                                <p class="text-lg font-semibold">{{ config('app.name', 'Web Template Studio') }}</p>
                                <p class="text-sm text-slate-300">Làm website, tối ưu SEO, sửa web và hỗ trợ đồ án với cách làm rõ ràng, dễ theo dõi.</p>
                            </div>
                        </div>
                        <p class="max-w-2xl text-sm leading-7 text-slate-300">Nếu bạn cần làm website, sửa landing page, tối ưu SEO hoặc nhờ xử lý một phần việc khó, bạn có thể liên hệ nhanh qua Zalo, Facebook, email hoặc form tư vấn trên trang.</p>
                        <div class="grid gap-3 sm:grid-cols-3">
                            @foreach ([
                                ['15-60 phút', 'thời gian phản hồi khi nhu cầu đã đủ rõ'],
                                ['3-7 ngày', 'cho website nhỏ hoặc phần việc cần xử lý nhanh'],
                                ['Bàn giao dễ theo dõi', 'có ghi chú và hướng dẫn khi cần'],
                            ] as [$title, $copy])
                                <article class="rounded-[1.15rem] border border-white/10 bg-white/7 px-4 py-4 backdrop-blur-sm">
                                    <p class="text-base font-semibold text-white">{{ $title }}</p>
                                    <p class="mt-1 text-xs leading-5 text-slate-300">{{ $copy }}</p>
                                </article>
                            @endforeach
                        </div>
                    </div>

                    <div class="grid gap-4">
                        <article class="rounded-[1.4rem] border border-white/10 bg-white/7 p-5 backdrop-blur-sm">
                            <p class="text-sm font-semibold text-sky-200">Liên hệ nhanh</p>
                            <div class="mt-4 grid gap-3">
                                <a class="rounded-xl bg-emerald-500/90 px-4 py-3 text-sm font-semibold text-white transition hover:bg-emerald-400" href="{{ config('contact.zalo_url', '#') }}">Nhắn Zalo để trao đổi nhanh</a>
                                <a class="rounded-xl bg-blue-500/90 px-4 py-3 text-sm font-semibold text-white transition hover:bg-blue-400" href="{{ config('contact.facebook_url', '#') }}">Nhắn Facebook để trao đổi nhu cầu</a>
                                <a class="rounded-xl border border-white/14 px-4 py-3 text-sm font-semibold text-white transition hover:bg-white/10" href="mailto:{{ config('contact.email', 'hello@example.com') }}">Gửi yêu cầu chi tiết qua email</a>
                            </div>
                        </article>
                        <article class="rounded-[1.4rem] border border-white/10 bg-white/7 p-5 backdrop-blur-sm">
                            <p class="text-sm font-semibold text-sky-200">Đi tiếp từ đây</p>
                            <div class="mt-4 flex flex-wrap gap-3 text-sm">
                                <a class="rounded-xl bg-white px-4 py-3 font-semibold text-zinc-950" href="{{ route('services') }}">Xem dịch vụ</a>
                                <a class="rounded-xl border border-white/14 px-4 py-3 font-semibold text-white" href="{{ route('portfolio.index') }}">Xem dự án</a>
                                <a class="rounded-xl border border-white/14 px-4 py-3 font-semibold text-white" href="#quote-form">Nhận tư vấn miễn phí</a>
                            </div>
                        </article>
                    </div>
                </div>
            </footer>
        </div>

        <div class="floating-contact-icons" data-floating-contact>
            <a class="floating-contact-icons__item floating-contact-icons__item--zalo" href="{{ config('contact.zalo_url', '#') }}" aria-label="Nhắn Zalo">
                <span class="floating-contact-icons__glyph">Z</span>
            </a>
            <a class="floating-contact-icons__item floating-contact-icons__item--facebook" href="{{ config('contact.facebook_url', '#') }}" aria-label="Liên hệ Facebook">
                <span class="floating-contact-icons__glyph">f</span>
            </a>
            <a class="floating-contact-icons__item floating-contact-icons__item--email" href="mailto:{{ config('contact.email', 'hello@example.com') }}" aria-label="Gửi Email">
                <span class="floating-contact-icons__glyph">@</span>
            </a>
        </div>

        <div class="sticky-cta-mobile" data-sticky-cta data-mobile-sticky-bar>
            <a class="sticky-cta-mobile__item sticky-cta-mobile__item--primary" href="#quote-form">Nhận tư vấn</a>
            <a class="sticky-cta-mobile__item sticky-cta-mobile__item--success" href="{{ config('contact.zalo_url', '#') }}">Nhắn Zalo</a>
            <a class="sticky-cta-mobile__item" href="{{ route('services') }}">Xem dịch vụ</a>
        </div>
    </body>
</html>
