@extends('layouts.app')

@section('title', 'Admin danh mục dịch vụ')

@section('content')
    <div class="space-y-6">
        <section class="rounded-lg border border-zinc-200 bg-white p-5 shadow-sm">
            <h1 class="text-2xl font-semibold text-zinc-950">Danh mục dịch vụ</h1>
            <p class="mt-2 text-sm text-zinc-600">Quản lý các dịch vụ công khai cho web, code, app, SEO và hỗ trợ kỹ thuật.</p>

            <form class="mt-5 grid gap-3 md:grid-cols-2" method="POST" action="{{ route('admin.marketplace.services.store') }}">
                @csrf
                <input class="rounded-md border px-3 py-2" name="name" placeholder="Tên dịch vụ" required>
                <select class="rounded-md border px-3 py-2" name="service_group" required>
                    <option value="seo">SEO website</option>
                    <option value="ui_fix">Fix giao diện</option>
                    <option value="website">Website / landing page</option>
                    <option value="student_support">Hỗ trợ đồ án</option>
                    <option value="coding_task">Task lập trình</option>
                </select>
                <textarea class="rounded-md border px-3 py-2 md:col-span-2" name="short_description" placeholder="Mô tả ngắn" required></textarea>
                <textarea class="rounded-md border px-3 py-2 md:col-span-2" name="detail_description" placeholder="Mô tả chi tiết" required></textarea>
                <textarea class="rounded-md border px-3 py-2" name="target_audiences" placeholder="Mỗi nhóm khách hàng một dòng"></textarea>
                <textarea class="rounded-md border px-3 py-2" name="key_benefits" placeholder="Mỗi lợi ích một dòng"></textarea>
                <textarea class="rounded-md border px-3 py-2" name="process_steps" placeholder="Mỗi bước quy trình một dòng"></textarea>
                <textarea class="rounded-md border px-3 py-2" name="pricing_note" placeholder="Ghi chú bảng giá/gói tham khảo"></textarea>
                <input class="rounded-md border px-3 py-2" name="sort_order" type="number" min="0" value="0">
                <select class="rounded-md border px-3 py-2" name="status">
                    <option value="published">Published</option>
                    <option value="draft">Draft</option>
                </select>
                <button class="rounded-md bg-rose-600 px-4 py-2 font-semibold text-white md:col-span-2" type="submit">Tạo dịch vụ</button>
            </form>
        </section>

        <section class="rounded-lg border border-zinc-200 bg-white p-5 shadow-sm">
            <div class="overflow-x-auto">
                <table class="min-w-full text-left text-sm">
                    <thead class="text-zinc-500">
                        <tr>
                            <th class="pb-3">Tên</th>
                            <th class="pb-3">Nhóm</th>
                            <th class="pb-3">Audience</th>
                            <th class="pb-3">Trạng thái</th>
                            <th class="pb-3">Thứ tự</th>
                            <th class="pb-3">Hành động</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-zinc-100">
                        @foreach ($services as $service)
                            <tr>
                                <td class="py-3">
                                    <p class="font-semibold text-zinc-950">{{ $service->name }}</p>
                                    <p class="text-zinc-500">{{ $service->short_description }}</p>
                                </td>
                                <td class="py-3">{{ $service->service_group }}</td>
                                <td class="py-3">{{ implode(', ', $service->target_audiences ?? []) }}</td>
                                <td class="py-3">{{ $service->status }}</td>
                                <td class="py-3">{{ $service->sort_order }}</td>
                                <td class="py-3">
                                    <form class="flex items-center gap-2" method="POST" action="{{ route('admin.marketplace.services.update', $service) }}">
                                        @csrf
                                        @method('PATCH')
                                        <input class="w-20 rounded-md border px-2 py-1" name="sort_order" type="number" min="0" value="{{ $service->sort_order }}">
                                        <select class="rounded-md border px-2 py-1" name="status">
                                            <option value="published" @selected($service->status === 'published')>published</option>
                                            <option value="draft" @selected($service->status === 'draft')>draft</option>
                                        </select>
                                        <button class="rounded-md border border-zinc-300 px-3 py-1 font-semibold text-zinc-700" type="submit">Lưu</button>
                                    </form>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>

            <div class="mt-4">
                {{ $services->links() }}
            </div>
        </section>
    </div>
@endsection
