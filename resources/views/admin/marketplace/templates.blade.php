@extends('layouts.app')
@section('title', 'Admin template')
@section('content')
    <div class="space-y-6">
        <section class="rounded-lg border bg-white p-5">
            <h1 class="text-2xl font-semibold">Template website</h1>
            <form class="mt-4 grid gap-3 md:grid-cols-2" method="POST" action="{{ route('admin.marketplace.templates.store') }}">
                @csrf
                <input class="rounded-md border px-3 py-2" name="name" placeholder="Tên template" required>
                <select class="rounded-md border px-3 py-2" name="template_category_id"><option value="">Danh mục</option>@foreach($categories as $category)<option value="{{ $category->id }}">{{ $category->name }}</option>@endforeach</select>
                <select class="rounded-md border px-3 py-2" name="audience_type"><option value="shop_owner">Shop nhỏ</option><option value="online_seller">Kinh doanh online</option><option value="student">Sinh viên</option></select>
                <input class="rounded-md border px-3 py-2" name="template_type" value="website">
                <input class="rounded-md border px-3 py-2" name="price" type="number" placeholder="Giá">
                <input class="rounded-md border px-3 py-2" name="demo_url" placeholder="Demo URL">
                <select class="rounded-md border px-3 py-2" name="status"><option value="active">active</option><option value="inactive">inactive</option></select>
                <textarea class="rounded-md border px-3 py-2 md:col-span-2" name="summary" placeholder="Tóm tắt"></textarea>
                <button class="rounded-md bg-rose-600 px-4 py-2 font-semibold text-white md:col-span-2">Tạo template</button>
            </form>
        </section>
        <x-admin.marketplace.table :items="$templates" :columns="['name' => 'Tên', 'audience_type' => 'Nhóm', 'price' => 'Giá', 'status' => 'Trạng thái']" />
    </div>
@endsection
