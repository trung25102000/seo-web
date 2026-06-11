@extends('layouts.app')

@section('title', $template->name)

@section('content')
    <div class="grid gap-8 lg:grid-cols-[1fr_24rem]">
        <section class="space-y-6">
            <div class="rounded-lg bg-gradient-to-br from-rose-100 via-amber-100 to-sky-100 p-8">
                <p class="text-sm font-semibold text-rose-700">{{ $template->category?->name ?? 'Mẫu website' }}</p>
                <h1 class="mt-3 text-3xl font-semibold">{{ $template->name }}</h1>
                <p class="mt-3 max-w-2xl text-sm leading-6 text-zinc-700">{{ $template->description ?: $template->summary }}</p>
            </div>
            <div class="rounded-lg border border-zinc-200 bg-white p-6">
                <h2 class="text-xl font-semibold">Xem bản demo trước khi chọn</h2>
                <p class="mt-2 text-sm text-zinc-600">Demo: @if($template->demo_url)<a class="font-semibold text-rose-700" href="{{ $template->demo_url }}">{{ $template->demo_url }}</a>@else Đang cập nhật @endif</p>
            </div>
        </section>
        <aside class="rounded-lg border border-zinc-200 bg-white p-5 shadow-sm">
            <p class="text-sm text-zinc-500">Giá từ</p>
            <p class="mt-1 text-2xl font-semibold">{{ number_format($template->price) }}đ</p>
            <form class="mt-5 space-y-3" method="POST" action="{{ route('orders.store') }}">
                @csrf
                <input type="hidden" name="website_template_id" value="{{ $template->id }}">
                <input type="hidden" name="need_type" value="template">
                <input class="w-full rounded-md border border-zinc-300 px-3 py-2 text-sm" name="customer_name" placeholder="Họ và tên" required>
                <input class="w-full rounded-md border border-zinc-300 px-3 py-2 text-sm" name="customer_phone" placeholder="Số điện thoại/Zalo" required>
                <input class="w-full rounded-md border border-zinc-300 px-3 py-2 text-sm" type="email" name="customer_email" placeholder="Email">
                <select class="w-full rounded-md border border-zinc-300 px-3 py-2 text-sm" name="customer_group" required>
                    <option value="shop_owner">Chủ shop nhỏ/lẻ</option>
                    <option value="online_seller">Kinh doanh online</option>
                    <option value="student">Sinh viên</option>
                </select>
                <textarea class="w-full rounded-md border border-zinc-300 px-3 py-2 text-sm" name="customization_request" placeholder="Bạn muốn chỉnh sửa gì thêm cho mẫu này?"></textarea>
                <button class="w-full rounded-md bg-rose-600 px-4 py-2.5 text-sm font-semibold text-white">Đặt mua mẫu này</button>
            </form>
        </aside>
    </div>
@endsection
