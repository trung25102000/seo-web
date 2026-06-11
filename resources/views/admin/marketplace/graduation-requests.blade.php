@extends('layouts.app')

@section('title', 'Admin yêu cầu đồ án')

@section('content')
    <section class="mb-6">
        <h1 class="text-2xl font-semibold">Yêu cầu đồ án tốt nghiệp</h1>
        <p class="mt-2 text-sm text-zinc-600">Theo dõi các lead sinh viên, đánh dấu độ ưu tiên và lưu note nội bộ theo tiến độ tư vấn.</p>
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
        <button class="rounded-md bg-rose-600 px-4 py-2 text-sm font-semibold text-white md:w-fit" type="submit">Lọc danh sách</button>
    </form>

    <section class="space-y-4">
        @foreach ($requests as $item)
            <article class="rounded-lg border border-zinc-200 bg-white p-5 shadow-sm">
                <div class="flex flex-wrap items-start justify-between gap-4">
                    <div class="max-w-2xl">
                        <div class="flex flex-wrap items-center gap-2">
                            <h2 class="text-lg font-semibold text-zinc-950">{{ $item->student_name }}</h2>
                            <span class="rounded-full bg-zinc-100 px-2.5 py-1 text-xs font-semibold text-zinc-700">{{ $leadStatuses[$item->status] ?? $item->status }}</span>
                            <span class="rounded-full bg-amber-100 px-2.5 py-1 text-xs font-semibold text-amber-800">{{ $leadPriorities[$item->priority] ?? $item->priority }}</span>
                        </div>
                        <p class="mt-2 text-sm text-zinc-600">{{ $item->student_phone }} · {{ $item->student_email ?: 'Chưa có email' }}</p>
                        <p class="mt-1 text-sm text-zinc-600">{{ $item->school ?: 'Chưa có trường' }} · {{ $item->major ?: 'Chưa có chuyên ngành' }} · Nguồn: {{ $leadSources[$item->lead_source] ?? $item->lead_source }}</p>
                        <p class="mt-1 text-sm font-semibold text-zinc-900">Đề tài: {{ $item->topic }}</p>
                        <p class="mt-3 text-sm leading-6 text-zinc-700">{{ $item->requirements ?: 'Chưa có mô tả chi tiết.' }}</p>
                        <div class="mt-3 flex flex-wrap gap-2 text-xs">
                            @foreach ([
                                'Cần báo cáo' => $item->need_report,
                                'Cần database' => $item->need_database,
                                'Cần hướng dẫn cài đặt' => $item->need_installation_guide,
                            ] as $label => $active)
                                <span class="rounded-full px-3 py-1 font-semibold {{ $active ? 'bg-emerald-50 text-emerald-700' : 'bg-zinc-100 text-zinc-600' }}">{{ $label }}</span>
                            @endforeach
                        </div>
                        <div class="mt-3 flex flex-wrap gap-2 text-xs font-semibold">
                            @if ($item->student_phone)
                                <a class="rounded-md bg-emerald-50 px-3 py-2 text-emerald-700" href="https://zalo.me/{{ preg_replace('/\D+/', '', $item->student_phone) }}">Nhắn Zalo</a>
                                <a class="rounded-md bg-sky-50 px-3 py-2 text-sky-700" href="tel:{{ $item->student_phone }}">Gọi nhanh</a>
                            @endif
                            @if ($item->student_email)
                                <a class="rounded-md bg-zinc-100 px-3 py-2 text-zinc-700" href="mailto:{{ $item->student_email }}">Email</a>
                            @endif
                        </div>
                    </div>

                    <form class="grid w-full gap-2 md:max-w-sm" method="POST" action="{{ route('admin.marketplace.graduation-requests.update', $item) }}">
                        @csrf
                        @method('PATCH')
                        <select class="rounded-md border px-3 py-2 text-sm" name="status">
                            @foreach ($leadStatuses as $value => $label)
                                <option value="{{ $value }}" @selected($item->status === $value)>{{ $label }}</option>
                            @endforeach
                        </select>
                        <select class="rounded-md border px-3 py-2 text-sm" name="priority">
                            @foreach ($leadPriorities as $value => $label)
                                <option value="{{ $value }}" @selected($item->priority === $value)>{{ $label }}</option>
                            @endforeach
                        </select>
                        <select class="rounded-md border px-3 py-2 text-sm" name="lead_source">
                            @foreach ($leadSources as $value => $label)
                                <option value="{{ $value }}" @selected($item->lead_source === $value)>{{ $label }}</option>
                            @endforeach
                        </select>
                        <textarea class="min-h-24 rounded-md border px-3 py-2 text-sm" name="admin_note" placeholder="Ghi chú tư vấn nội bộ">{{ $item->admin_note }}</textarea>
                        <button class="rounded-md bg-rose-600 px-3 py-2 text-sm font-semibold text-white" type="submit">Cập nhật yêu cầu</button>
                    </form>
                </div>
            </article>
        @endforeach

        {{ $requests->links() }}
    </section>
@endsection
