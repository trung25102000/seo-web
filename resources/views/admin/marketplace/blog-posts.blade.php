@extends('layouts.app')
@section('title', 'Admin blog SEO')
@section('content')
<section class="mb-6 rounded-lg border bg-white p-5">
    <h1 class="text-2xl font-semibold">Blog SEO</h1>
    <form class="mt-4 grid gap-3 md:grid-cols-2" method="POST" action="{{ route('admin.marketplace.blog-posts.store') }}">
        @csrf
        <input class="rounded-md border px-3 py-2" name="title" placeholder="Tiêu đề" required>
        <select class="rounded-md border px-3 py-2" name="audience_type">
            <option value="shop_owner">Shop nhỏ</option>
            <option value="online_seller">Kinh doanh online</option>
            <option value="student">Sinh viên</option>
        </select>
        <select class="rounded-md border px-3 py-2" name="content_pillar">
            @foreach (\App\Models\BlogPost::pillarOptions() as $value => $pillar)
                <option value="{{ $value }}">{{ $pillar['label'] }}</option>
            @endforeach
        </select>
        <select class="rounded-md border px-3 py-2" name="service_group">
            @foreach (\App\Models\BlogPost::serviceGroupOptions() as $value => $label)
                <option value="{{ $value }}">{{ $label }}</option>
            @endforeach
        </select>
        <textarea class="rounded-md border px-3 py-2 md:col-span-2" name="excerpt" placeholder="Excerpt"></textarea>
        <input class="rounded-md border px-3 py-2" name="meta_title" placeholder="Meta title">
        <input class="rounded-md border px-3 py-2" name="meta_description" placeholder="Meta description">
        <select class="rounded-md border px-3 py-2" name="status">
            <option value="draft">draft</option>
            <option value="published">published</option>
        </select>
        <textarea class="rounded-md border px-3 py-2 md:col-span-2" name="content" placeholder="Nội dung" required></textarea>
        <button class="rounded-md bg-rose-600 px-4 py-2 font-semibold text-white md:col-span-2">Tạo bài</button>
    </form>
</section>
<x-admin.marketplace.table :items="$posts" :columns="['title' => 'Tiêu đề', 'content_pillar' => 'Trụ cột', 'service_group' => 'Dịch vụ', 'status' => 'Trạng thái']" />
@endsection
