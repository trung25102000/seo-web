@extends('layouts.app')

@section('title', 'Admin lead báo giá')

@section('content')
    <section class="mb-6">
        <h1 class="text-2xl font-semibold">Lead báo giá</h1>
        <p class="mt-2 text-sm text-zinc-600">Ưu tiên lead theo dịch vụ, ngân sách, công nghệ liên quan và kênh liên hệ mong muốn.</p>
    </section>

    <form method="GET" class="mb-6 grid gap-3 rounded-lg border border-zinc-200 bg-white p-4 shadow-sm md:grid-cols-5">
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
        <select class="rounded-md border px-3 py-2 text-sm" name="service_type">
            <option value="">Tất cả dịch vụ</option>
            @foreach ($serviceTypes as $value => $label)
                <option value="{{ $value }}" @selected($filters['service_type'] === $value)>{{ $label }}</option>
            @endforeach
        </select>
        <select class="rounded-md border px-3 py-2 text-sm" name="preferred_contact_channel">
            <option value="">Tất cả kênh ưu tiên</option>
            @foreach ($preferredContactChannels as $value => $label)
                <option value="{{ $value }}" @selected($filters['preferred_contact_channel'] === $value)>{{ $label }}</option>
            @endforeach
        </select>
        <select class="rounded-md border px-3 py-2 text-sm" name="lead_source">
            <option value="">Tất cả nguồn lead</option>
            @foreach ($leadSources as $value => $label)
                <option value="{{ $value }}" @selected($filters['lead_source'] === $value)>{{ $label }}</option>
            @endforeach
        </select>
        <button class="rounded-md bg-rose-600 px-4 py-2 text-sm font-semibold text-white md:col-span-5 md:w-fit" type="submit">Lọc danh sách</button>
    </form>

    <section class="space-y-4">
        @foreach ($quotes as $quote)
            <article class="rounded-lg border border-zinc-200 bg-white p-5 shadow-sm">
                <div class="flex flex-wrap items-start justify-between gap-4">
                    <div class="max-w-2xl">
                        <div class="flex flex-wrap items-center gap-2">
                            <h2 class="text-lg font-semibold text-zinc-950">{{ $quote->customer_name }}</h2>
                            <span class="rounded-full bg-zinc-100 px-2.5 py-1 text-xs font-semibold text-zinc-700">{{ $leadStatuses[$quote->status] ?? $quote->status }}</span>
                            <span class="rounded-full bg-amber-100 px-2.5 py-1 text-xs font-semibold text-amber-800">{{ $leadPriorities[$quote->priority] ?? $quote->priority }}</span>
                        </div>
                        <p class="mt-2 text-sm text-zinc-600">{{ $quote->customer_phone }} · {{ $quote->customer_email ?: 'Chưa có email' }}</p>
                        <p class="mt-1 text-sm text-zinc-600">Dịch vụ: {{ $serviceTypes[$quote->service_type] ?? $quote->service_type }} · Kênh ưu tiên: {{ $preferredContactChannels[$quote->preferred_contact_channel] ?? $quote->preferred_contact_channel }} · Nguồn: {{ $leadSources[$quote->lead_source] ?? $quote->lead_source }}</p>
                        <p class="mt-1 text-sm text-zinc-600">Ngân sách: {{ $quote->budget_range ?: 'Chưa rõ' }} · Deadline: {{ $quote->deadline ?: 'Chưa rõ' }} · Công nghệ: {{ $quote->technology_stack ?: 'Chưa nêu' }}</p>
                        <p class="mt-3 text-sm leading-6 text-zinc-700">{{ $quote->requirements }}</p>
                        <div class="mt-3 flex flex-wrap gap-2 text-xs font-semibold">
                            @if ($quote->customer_phone)
                                <a class="rounded-md bg-emerald-50 px-3 py-2 text-emerald-700" href="https://zalo.me/{{ preg_replace('/\D+/', '', $quote->customer_phone) }}">Nhắn Zalo</a>
                                <a class="rounded-md bg-sky-50 px-3 py-2 text-sky-700" href="tel:{{ $quote->customer_phone }}">Gọi nhanh</a>
                            @endif
                            @if ($quote->customer_email)
                                <a class="rounded-md bg-zinc-100 px-3 py-2 text-zinc-700" href="mailto:{{ $quote->customer_email }}">Email</a>
                            @endif
                        </div>
                    </div>

                    <form class="grid w-full gap-2 md:max-w-sm" method="POST" action="{{ route('admin.marketplace.quotes.update', $quote) }}">
                        @csrf
                        @method('PATCH')
                        <select class="rounded-md border px-3 py-2 text-sm" name="status">
                            @foreach ($leadStatuses as $value => $label)
                                <option value="{{ $value }}" @selected($quote->status === $value)>{{ $label }}</option>
                            @endforeach
                        </select>
                        <select class="rounded-md border px-3 py-2 text-sm" name="priority">
                            @foreach ($leadPriorities as $value => $label)
                                <option value="{{ $value }}" @selected($quote->priority === $value)>{{ $label }}</option>
                            @endforeach
                        </select>
                        <select class="rounded-md border px-3 py-2 text-sm" name="lead_source">
                            @foreach ($leadSources as $value => $label)
                                <option value="{{ $value }}" @selected($quote->lead_source === $value)>{{ $label }}</option>
                            @endforeach
                        </select>
                        <textarea class="min-h-24 rounded-md border px-3 py-2 text-sm" name="admin_note" placeholder="Ghi chú tư vấn nội bộ">{{ $quote->admin_note }}</textarea>
                        <button class="rounded-md bg-rose-600 px-3 py-2 text-sm font-semibold text-white" type="submit">Cập nhật lead</button>
                    </form>
                </div>
            </article>
        @endforeach

        {{ $quotes->links() }}
    </section>
@endsection
