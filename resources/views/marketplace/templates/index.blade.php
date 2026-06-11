@extends('layouts.app')

@section('title', 'Mẫu website có thể triển khai nhanh')

@section('content')
    <div class="space-y-6">
        <section data-reveal>
            <h1 class="text-3xl font-semibold text-zinc-950">Mẫu website có thể triển khai nhanh</h1>
            <p class="mt-2 text-sm text-zinc-600">Lọc theo nhu cầu, xem demo trước và chọn mẫu phù hợp để tiết kiệm thời gian triển khai.</p>
        </section>
        <form class="grid gap-3 rounded-lg border border-zinc-200 bg-white p-4 shadow-sm md:grid-cols-4" method="GET" data-reveal>
            <input class="rounded-md border border-zinc-300 px-3 py-2 text-sm md:col-span-2" name="search" value="{{ $filters['search'] ?? '' }}" placeholder="Tìm mẫu website phù hợp...">
            <select class="rounded-md border border-zinc-300 px-3 py-2 text-sm" name="category">
                <option value="">Tất cả danh mục</option>
                @foreach ($categories as $category)
                    <option value="{{ $category->slug }}" @selected(($filters['category'] ?? '') === $category->slug)>{{ $category->name }}</option>
                @endforeach
            </select>
            <select class="rounded-md border border-zinc-300 px-3 py-2 text-sm" name="sort">
                <option value="newest">Mới nhất</option>
                <option value="price_asc" @selected(($filters['sort'] ?? '') === 'price_asc')>Giá tăng dần</option>
                <option value="price_desc" @selected(($filters['sort'] ?? '') === 'price_desc')>Giá giảm dần</option>
            </select>
            <button class="rounded-md bg-rose-600 px-4 py-2 text-sm font-semibold text-white md:col-span-4">Tìm mẫu phù hợp</button>
        </form>
        <div class="grid gap-4 md:grid-cols-3" data-reveal>
            @foreach ($templates as $template)
                <x-template-card :template="$template" />
            @endforeach
        </div>
        {{ $templates->links() }}
    </div>
@endsection
