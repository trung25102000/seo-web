@extends('layouts.app')

@section('title', 'Admin khách hàng')

@section('content')
    <section class="mb-6">
        <h1 class="text-2xl font-semibold">Khách hàng</h1>
        <p class="mt-2 text-sm text-zinc-600">Theo dõi tần suất liên hệ theo từng khách và lưu ghi chú nội bộ ngắn để tái chăm sóc.</p>
    </section>

    <section class="space-y-4">
        @foreach ($customers as $customer)
            <article class="rounded-lg border border-zinc-200 bg-white p-5 shadow-sm">
                <div class="flex flex-wrap items-start justify-between gap-4">
                    <div>
                        <h2 class="text-lg font-semibold text-zinc-950">{{ $customer->name }}</h2>
                        <p class="mt-2 text-sm text-zinc-600">{{ $customer->phone ?: 'Chưa có số điện thoại' }} · {{ $customer->email ?: 'Chưa có email' }}</p>
                        <p class="mt-1 text-sm text-zinc-600">Nhóm khách: {{ $customer->customer_group }}</p>
                        <div class="mt-3 flex flex-wrap gap-2 text-xs font-semibold">
                            <span class="rounded-full bg-zinc-100 px-3 py-1 text-zinc-700">Đơn hàng: {{ $customer->order_requests_count }}</span>
                            <span class="rounded-full bg-zinc-100 px-3 py-1 text-zinc-700">Báo giá: {{ $customer->quote_requests_count }}</span>
                            <span class="rounded-full bg-zinc-100 px-3 py-1 text-zinc-700">Đồ án: {{ $customer->graduation_project_requests_count }}</span>
                        </div>
                    </div>

                    <form class="grid w-full gap-2 md:max-w-sm" method="POST" action="{{ route('admin.marketplace.customers.update', $customer) }}">
                        @csrf
                        @method('PATCH')
                        <textarea class="min-h-24 rounded-md border px-3 py-2 text-sm" name="note" placeholder="Ghi chú nội bộ về khách hàng">{{ $customer->note }}</textarea>
                        <button class="rounded-md bg-rose-600 px-3 py-2 text-sm font-semibold text-white" type="submit">Lưu ghi chú</button>
                    </form>
                </div>
            </article>
        @endforeach

        {{ $customers->links() }}
    </section>
@endsection
