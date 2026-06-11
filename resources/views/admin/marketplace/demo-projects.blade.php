@extends('layouts.app')

@section('title', 'Admin portfolio project')

@section('content')
    <div class="space-y-6">
        <section class="rounded-lg border border-zinc-200 bg-white p-5 shadow-sm">
            <h1 class="text-2xl font-semibold text-zinc-950">Portfolio / case studies</h1>
            <p class="mt-2 text-sm text-zinc-600">Quản lý các dự án đã làm để hiển thị công khai như portfolio và case study.</p>

            <form class="mt-5 grid gap-3 md:grid-cols-2" method="POST" action="{{ route('admin.marketplace.demo-projects.store') }}">
                @csrf
                <input class="rounded-md border px-3 py-2" name="name" placeholder="Tên dự án" required>
                <select class="rounded-md border px-3 py-2" name="project_type" required>
                    <option value="website">Website</option>
                    <option value="landing_page">Landing Page</option>
                    <option value="seo">SEO</option>
                    <option value="app">App</option>
                    <option value="bug_fix">Fix bug</option>
                </select>
                <select class="rounded-md border px-3 py-2" name="website_template_id">
                    <option value="">Không gắn template</option>
                    @foreach ($templates as $template)
                        <option value="{{ $template->id }}">{{ $template->name }}</option>
                    @endforeach
                </select>
                <input class="rounded-md border px-3 py-2 md:col-span-2" name="demo_url" placeholder="Demo URL" required>
                <textarea class="rounded-md border px-3 py-2 md:col-span-2" name="client_problem" placeholder="Bài toán khách hàng" required></textarea>
                <textarea class="rounded-md border px-3 py-2 md:col-span-2" name="implemented_solution" placeholder="Giải pháp thực hiện" required></textarea>
                <textarea class="rounded-md border px-3 py-2" name="tech_stack" placeholder="Mỗi công nghệ một dòng"></textarea>
                <textarea class="rounded-md border px-3 py-2" name="role_summary" placeholder="Vai trò thực hiện"></textarea>
                <textarea class="rounded-md border px-3 py-2" name="outcome_summary" placeholder="Kết quả đạt được"></textarea>
                <input class="rounded-md border px-3 py-2" name="preview_image_path" placeholder="Preview image path">
                <select class="rounded-md border px-3 py-2" name="status">
                    <option value="published">Published</option>
                    <option value="draft">Draft</option>
                </select>
                <label class="flex items-center gap-2 text-sm"><input checked name="is_active" type="checkbox" value="1"> Hiển thị công khai</label>
                <button class="rounded-md bg-rose-600 px-4 py-2 font-semibold text-white md:col-span-2" type="submit">Tạo case study</button>
            </form>
        </section>

        <section class="rounded-lg border border-zinc-200 bg-white p-5 shadow-sm">
            <div class="overflow-x-auto">
                <table class="min-w-full text-left text-sm">
                    <thead class="text-zinc-500">
                        <tr>
                            <th class="pb-3">Tên</th>
                            <th class="pb-3">Loại</th>
                            <th class="pb-3">Liên kết</th>
                            <th class="pb-3">Trạng thái</th>
                            <th class="pb-3">Hiển thị</th>
                            <th class="pb-3">Hành động</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-zinc-100">
                        @foreach ($demos as $demo)
                            <tr>
                                <td class="py-3">
                                    <p class="font-semibold text-zinc-950">{{ $demo->name }}</p>
                                    <p class="text-zinc-500">{{ $demo->websiteTemplate?->name }}</p>
                                </td>
                                <td class="py-3">{{ $demo->project_type }}</td>
                                <td class="py-3"><a class="text-rose-700" href="{{ $demo->demo_url }}">Demo</a></td>
                                <td class="py-3">{{ $demo->status }}</td>
                                <td class="py-3">{{ $demo->is_active ? 'yes' : 'no' }}</td>
                                <td class="py-3">
                                    <form class="flex items-center gap-2" method="POST" action="{{ route('admin.marketplace.demo-projects.update', $demo) }}">
                                        @csrf
                                        @method('PATCH')
                                        <select class="rounded-md border px-2 py-1" name="status">
                                            <option value="published" @selected($demo->status === 'published')>published</option>
                                            <option value="draft" @selected($demo->status === 'draft')>draft</option>
                                        </select>
                                        <label class="flex items-center gap-1 text-xs">
                                            <input name="is_active" type="checkbox" value="1" @checked($demo->is_active)>
                                            active
                                        </label>
                                        <button class="rounded-md border border-zinc-300 px-3 py-1 font-semibold text-zinc-700" type="submit">Lưu</button>
                                    </form>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>

            <div class="mt-4">
                {{ $demos->links() }}
            </div>
        </section>
    </div>
@endsection
