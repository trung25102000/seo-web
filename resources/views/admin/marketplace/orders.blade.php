@extends('layouts.app')

@section('title', 'Admin đơn hàng')

@section('content')
    <section class="mb-6">
        <h1 class="text-2xl font-semibold">Đơn hàng và yêu cầu mua</h1>
        <p class="mt-2 text-sm text-zinc-600">Lọc theo trạng thái, độ ưu tiên, nguồn lead và cập nhật ghi chú tư vấn nội bộ.</p>
    </section>

    <form method="GET" class="mb-6 grid gap-3 rounded-lg border border-zinc-200 bg-white p-4 shadow-sm md:grid-cols-4">
        <select class="rounded-md border px-3 py-2 text-sm" name="status">
            <option value="">Tất cả trạng thái</option>
            @foreach ($leadStatuses as $value => $label)
                <option value="{{ $value }}" @selected($filters['status'] === $value)>{{ $label }}</option>
            @endforeach
        </select>
        <select class="rounded-md border px-3 py-2 text-sm" name="priority">
            <option value="">Tất cả ưu tiên</option>
            @foreach ($leadPriorities as $value => $label)
                <option value="{{ $value }}" @selected($filters['priority'] === $value)>{{ $label }}</option>
            @endforeach
        </select>
        <select class="rounded-md border px-3 py-2 text-sm" name="lead_source">
            <option value="">Tất cả nguồn lead</option>
            @foreach ($leadSources as $value => $label)
                <option value="{{ $value }}" @selected($filters['lead_source'] === $value)>{{ $label }}</option>
            @endforeach
        </select>
        <select class="rounded-md border px-3 py-2 text-sm" name="customer_group">
            <option value="">Tất cả nhóm khách</option>
            @foreach ($customerGroups as $value => $label)
                <option value="{{ $value }}" @selected($filters['customer_group'] === $value)>{{ $label }}</option>
            @endforeach
        </select>
        <button class="rounded-md bg-rose-600 px-4 py-2 text-sm font-semibold text-white md:col-span-4 md:w-fit" type="submit">Lọc danh sách</button>
    </form>

    <section class="space-y-4">
        @foreach ($orders as $order)
            <article class="rounded-lg border border-zinc-200 bg-white p-5 shadow-sm">
                <div class="flex flex-wrap items-start justify-between gap-4">
                    <div class="max-w-2xl">
                        <div class="flex flex-wrap items-center gap-2">
                            <h2 class="text-lg font-semibold text-zinc-950">{{ $order->customer_name }}</h2>
                            <span class="rounded-full bg-zinc-100 px-2.5 py-1 text-xs font-semibold text-zinc-700">{{ $leadStatuses[$order->status] ?? $order->status }}</span>
                            <span class="rounded-full bg-amber-100 px-2.5 py-1 text-xs font-semibold text-amber-800">{{ $leadPriorities[$order->priority] ?? $order->priority }}</span>
                        </div>
                        <p class="mt-2 text-sm text-zinc-600">{{ $order->customer_phone }} · {{ $order->customer_email ?: 'Chưa có email' }}</p>
                        <p class="mt-1 text-sm text-zinc-600">Nhóm khách: {{ $customerGroups[$order->customer_group] ?? $order->customer_group }} · Nguồn: {{ $leadSources[$order->lead_source] ?? $order->lead_source }} · Nhu cầu: {{ $order->need_type }}</p>
                        <p class="mt-3 text-sm leading-6 text-zinc-700">{{ $order->customization_request ?: 'Không có mô tả thêm.' }}</p>
                        <div class="mt-3 flex flex-wrap gap-2 text-xs font-semibold">
                            @if ($order->customer_phone)
                                <a class="rounded-md bg-emerald-50 px-3 py-2 text-emerald-700" href="https://zalo.me/{{ preg_replace('/\D+/', '', $order->customer_phone) }}">Nhắn Zalo</a>
                                <a class="rounded-md bg-sky-50 px-3 py-2 text-sky-700" href="tel:{{ $order->customer_phone }}">Gọi nhanh</a>
                            @endif
                            @if ($order->customer_email)
                                <a class="rounded-md bg-zinc-100 px-3 py-2 text-zinc-700" href="mailto:{{ $order->customer_email }}">Email</a>
                            @endif
                        </div>
                    </div>

                    <form class="grid w-full gap-2 md:max-w-sm" method="POST" action="{{ route('admin.marketplace.orders.update', $order) }}">
                        @csrf
                        @method('PATCH')
                        <select class="rounded-md border px-3 py-2 text-sm" name="status">
                            @foreach ($leadStatuses as $value => $label)
                                <option value="{{ $value }}" @selected($order->status === $value)>{{ $label }}</option>
                            @endforeach
                        </select>
                        <select class="rounded-md border px-3 py-2 text-sm" name="priority">
                            @foreach ($leadPriorities as $value => $label)
                                <option value="{{ $value }}" @selected($order->priority === $value)>{{ $label }}</option>
                            @endforeach
                        </select>
                        <select class="rounded-md border px-3 py-2 text-sm" name="lead_source">
                            @foreach ($leadSources as $value => $label)
                                <option value="{{ $value }}" @selected($order->lead_source === $value)>{{ $label }}</option>
                            @endforeach
                        </select>
                        <textarea class="min-h-24 rounded-md border px-3 py-2 text-sm" name="internal_note" placeholder="Ghi chú tư vấn nội bộ">{{ $order->internal_note }}</textarea>
                        <button class="rounded-md bg-rose-600 px-3 py-2 text-sm font-semibold text-white" type="submit">Cập nhật</button>
                    </form>
                </div>
            </article>
        @endforeach

        {{ $orders->links() }}
    </section>
@endsection
