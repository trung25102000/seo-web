@props([
    'headline' => 'Nói nhu cầu của bạn để nhận hướng làm phù hợp.',
    'description' => 'Phù hợp với shop nhỏ, cá nhân cần website, khách cần sửa web hoặc SEO, và sinh viên cần hỗ trợ triển khai đề tài.',
    'serviceType' => null,
    'buttonLabel' => 'Gửi yêu cầu tư vấn',
])

<section id="quote-form" class="grid gap-6 rounded-lg border border-rose-100 bg-white p-5 shadow-sm sm:p-6 lg:grid-cols-[1fr_26rem]" data-reveal data-contact-cta data-mobile-funnel>
    <div>
        <p class="text-sm font-semibold text-rose-700">Tư vấn nhanh</p>
        <h2 class="mt-2 text-2xl font-semibold text-zinc-950">{{ $headline }}</h2>
        <p class="mt-3 text-sm leading-6 text-zinc-600">{{ $description }}</p>
        <div class="mt-4 grid gap-3 sm:grid-cols-3" data-contact-proof-grid>
            @foreach ([
                ['15-60 phút', 'thời gian phản hồi khi nhu cầu đã đủ rõ'],
                ['Thống nhất công việc trước khi bắt đầu', 'để tránh làm nhiều nhưng không đúng mục tiêu'],
                ['Có hướng dẫn khi bàn giao', 'phù hợp cả khách kinh doanh lẫn sinh viên cần tự theo dõi'],
            ] as [$title, $copy])
                <article class="rounded-lg border border-white bg-zinc-50 px-4 py-4 shadow-sm">
                    <p class="text-base font-semibold text-zinc-950">{{ $title }}</p>
                    <p class="mt-1 text-xs leading-5 text-zinc-600">{{ $copy }}</p>
                </article>
            @endforeach
        </div>
        <div class="mt-4 rounded-lg border border-sky-100 bg-sky-50 px-4 py-3 text-sm leading-6 text-zinc-700">
            <p><span class="font-semibold text-zinc-950">Để tư vấn nhanh hơn:</span> hãy mô tả mục tiêu, thời gian mong muốn và gửi link website hiện tại nếu có.</p>
        </div>
        <div class="mt-5 grid gap-3 text-sm sm:flex sm:flex-wrap" data-contact-channels>
            <a class="rounded-md bg-emerald-600 px-4 py-3 font-semibold text-white transition hover:-translate-y-0.5 hover:bg-emerald-700 hover:shadow-lg hover:shadow-emerald-100" href="{{ config('contact.zalo_url', '#') }}">Zalo · phản hồi nhanh</a>
            <a class="rounded-md bg-blue-600 px-4 py-3 font-semibold text-white transition hover:-translate-y-0.5 hover:bg-blue-700 hover:shadow-lg hover:shadow-blue-100" href="{{ config('contact.facebook_url', '#') }}">Facebook · trao đổi nhu cầu</a>
            <a class="rounded-md border border-zinc-300 px-4 py-3 font-semibold text-zinc-800 transition hover:-translate-y-0.5 hover:bg-zinc-50 hover:shadow-sm" href="mailto:{{ config('contact.email', 'hello@example.com') }}">Email · gửi yêu cầu chi tiết</a>
        </div>
    </div>
    <form method="POST" action="{{ route('quote-requests.store') }}" class="space-y-3" data-mobile-form>
        @csrf
        <input class="w-full rounded-md border border-zinc-300 px-3 py-2 text-sm" name="customer_name" placeholder="Họ và tên" required>
        <input class="w-full rounded-md border border-zinc-300 px-3 py-2 text-sm" name="customer_phone" placeholder="Số điện thoại/Zalo" required>
        <input class="w-full rounded-md border border-zinc-300 px-3 py-2 text-sm" type="email" name="customer_email" placeholder="Email">
        <select class="w-full rounded-md border border-zinc-300 px-3 py-2 text-sm" name="preferred_contact_channel" required>
            <option value="zalo">Liên hệ ưu tiên: Zalo</option>
            <option value="phone">Liên hệ ưu tiên: Gọi điện</option>
            <option value="email">Liên hệ ưu tiên: Email</option>
            <option value="facebook">Liên hệ ưu tiên: Facebook</option>
        </select>
        <select class="w-full rounded-md border border-zinc-300 px-3 py-2 text-sm" name="customer_group" required>
            <option value="shop_owner">Chủ shop nhỏ/lẻ</option>
            <option value="online_seller">Cá nhân kinh doanh online</option>
            <option value="student">Sinh viên</option>
        </select>
        @if ($serviceType)
            <input name="service_type" type="hidden" value="{{ $serviceType }}">
            <div class="rounded-md border border-rose-200 bg-rose-50 px-3 py-2 text-sm font-semibold text-rose-800">
                Nhu cầu đang chọn: {{ match($serviceType) {
                    'website' => 'Làm website',
                    'landing_page' => 'Làm landing page',
                    'catalog' => 'Làm catalog sản phẩm',
                    'seo' => 'Tối ưu SEO website',
                    'ui_fix' => 'Sửa giao diện website',
                    'coding_task' => 'Hỗ trợ phần việc lập trình',
                    'student_support' => 'Hỗ trợ đồ án sinh viên',
                    'custom' => 'Nhu cầu theo yêu cầu riêng',
                    default => $serviceType,
                } }}
            </div>
        @else
            <select class="w-full rounded-md border border-zinc-300 px-3 py-2 text-sm" name="service_type" required>
                <option value="website">Website giới thiệu/bán hàng</option>
                <option value="landing_page">Landing page chạy quảng cáo</option>
                <option value="catalog">Catalog sản phẩm</option>
                <option value="seo">SEO website</option>
                <option value="ui_fix">Sửa giao diện website</option>
                <option value="coding_task">Hỗ trợ phần việc lập trình</option>
                <option value="student_support">Hỗ trợ đồ án sinh viên</option>
                <option value="custom">Làm web theo yêu cầu riêng</option>
            </select>
        @endif
        <select class="w-full rounded-md border border-zinc-300 px-3 py-2 text-sm" name="budget_range">
            <option value="">Ngân sách tham khảo</option>
            <option value="under_3m">Dưới 3 triệu</option>
            <option value="3m_to_7m">3-7 triệu</option>
            <option value="7m_to_15m">7-15 triệu</option>
            <option value="over_15m">Trên 15 triệu</option>
            <option value="need_consulting">Cần tư vấn thêm</option>
        </select>
        <input class="w-full rounded-md border border-zinc-300 px-3 py-2 text-sm" name="deadline" placeholder="Thời gian bạn muốn hoàn thành, ví dụ: trong 5 ngày">
        <input class="w-full rounded-md border border-zinc-300 px-3 py-2 text-sm" name="technology_stack" placeholder="Website hiện tại đang dùng nền tảng nào? Ví dụ: Laravel, WordPress, React">
        <textarea class="min-h-28 w-full rounded-md border border-zinc-300 px-3 py-2 text-sm" name="requirements" placeholder="Mô tả nhu cầu của bạn: đang gặp vấn đề gì, muốn cải thiện điều gì, có link tham khảo nào không?" required></textarea>
        <div class="rounded-lg border border-emerald-100 bg-emerald-50 px-3 py-3 text-sm leading-6 text-emerald-900">
            <p><span class="font-semibold">Mục tiêu của form này:</span> giúp bạn nhận tư vấn đúng hướng và biết bước tiếp theo cần làm là gì.</p>
        </div>
        <button class="w-full rounded-md bg-rose-600 px-4 py-3 text-sm font-semibold text-white hover:bg-rose-700" type="submit">{{ $buttonLabel }}</button>
    </form>
</section>
