@props(['title', 'action', 'fields'])

<section class="mb-6 rounded-lg border border-zinc-200 bg-white p-5 shadow-sm">
    <h1 class="text-2xl font-semibold">{{ $title }}</h1>
    <form class="mt-4 grid gap-3 md:grid-cols-2" method="POST" action="{{ $action }}">
        @csrf
        @foreach ($fields as $name => $label)
            @if (str_contains($name, 'description') || str_contains($name, 'content'))
                <textarea class="rounded-md border border-zinc-300 px-3 py-2 text-sm" name="{{ $name }}" placeholder="{{ $label }}"></textarea>
            @else
                <input class="rounded-md border border-zinc-300 px-3 py-2 text-sm" name="{{ $name }}" placeholder="{{ $label }}" required>
            @endif
        @endforeach
        <button class="rounded-md bg-rose-600 px-4 py-2 text-sm font-semibold text-white md:col-span-2">Lưu</button>
    </form>
</section>
