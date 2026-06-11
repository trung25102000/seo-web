@extends('layouts.app')

@section('title', 'Admin feedback khách hàng')

@section('content')
    <div class="space-y-6">
        <section class="rounded-lg border border-zinc-200 bg-white p-5 shadow-sm">
            <h1 class="text-2xl font-semibold text-zinc-950">Feedback khách hàng</h1>
            <p class="mt-2 text-sm text-zinc-600">Quản lý testimonial và social proof dùng cho homepage, dịch vụ và portfolio.</p>

            <form class="mt-5 grid gap-3 md:grid-cols-2" method="POST" action="{{ route('admin.marketplace.testimonials.store') }}">
                @csrf
                <input class="rounded-md border px-3 py-2" name="name" placeholder="Tên khách hàng hoặc nhãn" required>
                <input class="rounded-md border px-3 py-2" maxlength="8" name="avatar_label" placeholder="Avatar label, ví dụ LS">
                <select class="rounded-md border px-3 py-2" name="audience_type" required>
                    <option value="shop_owner">Shop nhỏ</option>
                    <option value="online_seller">Kinh doanh online</option>
                    <option value="student">Sinh viên</option>
                    <option value="small_business">Doanh nghiệp nhỏ</option>
                </select>
                <select class="rounded-md border px-3 py-2" name="service_type" required>
                    <option value="website">Website</option>
                    <option value="landing_page">Landing page</option>
                    <option value="seo">SEO</option>
                    <option value="ui_fix">Fix giao diện</option>
                    <option value="coding_task">Task lập trình</option>
                    <option value="student_support">Hỗ trợ đồ án</option>
                </select>
                <textarea class="rounded-md border px-3 py-2 md:col-span-2" name="content" placeholder="Nội dung feedback" required></textarea>
                <input class="rounded-md border px-3 py-2" max="5" min="1" name="rating" type="number" value="5" required>
                <input class="rounded-md border px-3 py-2" name="trust_tag" placeholder="Trust tag, ví dụ Bàn giao rõ ràng">
                <input class="rounded-md border px-3 py-2" name="sort_order" type="number" value="0">
                <select class="rounded-md border px-3 py-2" name="status">
                    <option value="published">Published</option>
                    <option value="draft">Draft</option>
                </select>
                <button class="rounded-md bg-rose-600 px-4 py-2 font-semibold text-white md:col-span-2" type="submit">Tạo feedback</button>
            </form>
        </section>

        <section class="rounded-lg border border-zinc-200 bg-white p-5 shadow-sm">
            <div class="overflow-x-auto">
                <table class="min-w-full text-left text-sm">
                    <thead class="text-zinc-500">
                        <tr>
                            <th class="pb-3">Khách hàng</th>
                            <th class="pb-3">Nhóm</th>
                            <th class="pb-3">Dịch vụ</th>
                            <th class="pb-3">Rating</th>
                            <th class="pb-3">Trust tag</th>
                            <th class="pb-3">Trạng thái</th>
                            <th class="pb-3">Thứ tự</th>
                            <th class="pb-3">Hành động</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-zinc-100">
                        @foreach ($testimonials as $testimonial)
                            <tr>
                                <td class="py-3">
                                    <p class="font-semibold text-zinc-950">{{ $testimonial->name }}</p>
                                    <p class="text-zinc-500">{{ $testimonial->content }}</p>
                                </td>
                                <td class="py-3">{{ $testimonial->audience_type }}</td>
                                <td class="py-3">{{ $testimonial->service_type }}</td>
                                <td class="py-3">{{ $testimonial->rating }}/5</td>
                                <td class="py-3">{{ $testimonial->trust_tag }}</td>
                                <td class="py-3">{{ $testimonial->status }}</td>
                                <td class="py-3">{{ $testimonial->sort_order }}</td>
                                <td class="py-3">
                                    <form class="flex items-center gap-2" method="POST" action="{{ route('admin.marketplace.testimonials.update', $testimonial) }}">
                                        @csrf
                                        @method('PATCH')
                                        <input class="w-20 rounded-md border px-2 py-1" name="sort_order" type="number" value="{{ $testimonial->sort_order }}">
                                        <select class="rounded-md border px-2 py-1" name="status">
                                            <option value="published" @selected($testimonial->status === 'published')>published</option>
                                            <option value="draft" @selected($testimonial->status === 'draft')>draft</option>
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
                {{ $testimonials->links() }}
            </div>
        </section>
    </div>
@endsection
