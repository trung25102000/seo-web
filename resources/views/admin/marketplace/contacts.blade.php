@extends('layouts.app')

@section('title', 'Admin liên hệ')

@section('content')
    <section class="mb-6">
        <h1 class="text-2xl font-semibold">Tin nhắn liên hệ</h1>
        <p class="mt-2 text-sm text-zinc-600">Nhóm các liên hệ chung theo dịch vụ, kênh ưu tiên và phản hồi nhanh ngay từ admin.</p>
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
            @foreach ($contactChannels as $value => $label)
                <option value="{{ $value }}" @selected($filters['preferred_contact_channel'] === $value)>{{ $label }}</option>
            @endforeach
        </select>
        <select class="rounded-md border px-3 py-2 text-sm" name="channel">
            <option value="">Tất cả nguồn gửi</option>
            @foreach ($contactChannels as $value => $label)
                <option value="{{ $value }}" @selected($filters['channel'] === $value)>{{ $label }}</option>
            @endforeach
        </select>
        <button class="rounded-md bg-rose-600 px-4 py-2 text-sm font-semibold text-white md:col-span-5 md:w-fit" type="submit">Lọc danh sách</button>
    </form>

    <section class="space-y-4">
        @foreach ($messages as $message)
            <article class="rounded-lg border border-zinc-200 bg-white p-5 shadow-sm">
                <div class="flex flex-wrap items-start justify-between gap-4">
                    <div class="max-w-2xl">
                        <div class="flex flex-wrap items-center gap-2">
                            <h2 class="text-lg font-semibold text-zinc-950">{{ $message->name }}</h2>
                            <span class="rounded-full bg-zinc-100 px-2.5 py-1 text-xs font-semibold text-zinc-700">{{ $leadStatuses[$message->status] ?? $message->status }}</span>
                            <span class="rounded-full bg-amber-100 px-2.5 py-1 text-xs font-semibold text-amber-800">{{ $leadPriorities[$message->priority] ?? $message->priority }}</span>
                        </div>
                        <p class="mt-2 text-sm text-zinc-600">{{ $message->phone ?: 'Chưa có số điện thoại' }} · {{ $message->email ?: 'Chưa có email' }}</p>
                        <p class="mt-1 text-sm text-zinc-600">Nguồn gửi: {{ $contactChannels[$message->channel] ?? $message->channel }} · Kênh ưu tiên: {{ $contactChannels[$message->preferred_contact_channel] ?? ($message->preferred_contact_channel ?: 'Chưa rõ') }} · Dịch vụ: {{ $serviceTypes[$message->service_type] ?? ($message->service_type ?: 'Chưa rõ') }}</p>
                        <p class="mt-3 text-sm leading-6 text-zinc-700">{{ $message->message }}</p>
                        <div class="mt-3 flex flex-wrap gap-2 text-xs font-semibold">
                            @if ($message->phone)
                                <a class="rounded-md bg-emerald-50 px-3 py-2 text-emerald-700" href="https://zalo.me/{{ preg_replace('/\D+/', '', $message->phone) }}">Nhắn Zalo</a>
                                <a class="rounded-md bg-sky-50 px-3 py-2 text-sky-700" href="tel:{{ $message->phone }}">Gọi nhanh</a>
                            @endif
                            @if ($message->email)
                                <a class="rounded-md bg-zinc-100 px-3 py-2 text-zinc-700" href="mailto:{{ $message->email }}">Email</a>
                            @endif
                        </div>
                    </div>

                    <form class="grid w-full gap-2 md:max-w-sm" method="POST" action="{{ route('admin.marketplace.contacts.update', $message) }}">
                        @csrf
                        @method('PATCH')
                        <select class="rounded-md border px-3 py-2 text-sm" name="status">
                            @foreach ($leadStatuses as $value => $label)
                                <option value="{{ $value }}" @selected($message->status === $value)>{{ $label }}</option>
                            @endforeach
                        </select>
                        <select class="rounded-md border px-3 py-2 text-sm" name="priority">
                            @foreach ($leadPriorities as $value => $label)
                                <option value="{{ $value }}" @selected($message->priority === $value)>{{ $label }}</option>
                            @endforeach
                        </select>
                        <textarea class="min-h-24 rounded-md border px-3 py-2 text-sm" name="admin_note" placeholder="Ghi chú tư vấn nội bộ">{{ $message->admin_note }}</textarea>
                        <button class="rounded-md bg-rose-600 px-3 py-2 text-sm font-semibold text-white" type="submit">Cập nhật liên hệ</button>
                    </form>
                </div>
            </article>
        @endforeach

        {{ $messages->links() }}
    </section>
@endsection
