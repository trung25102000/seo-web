@props(['faqs'])

@if ($faqs->isNotEmpty())
    <section class="space-y-4">
        <div>
            <p class="text-sm font-semibold text-rose-700">FAQ</p>
            <h2 class="mt-2 text-2xl font-semibold text-zinc-950">Câu hỏi thường gặp</h2>
        </div>
        <div class="grid gap-3 md:grid-cols-2">
            @foreach ($faqs as $faq)
                <article class="rounded-lg border border-zinc-200 bg-white p-5 shadow-sm">
                    <h3 class="font-semibold text-zinc-950">{{ $faq->question }}</h3>
                    <p class="mt-2 text-sm leading-6 text-zinc-600">{{ $faq->answer }}</p>
                </article>
            @endforeach
        </div>
    </section>
@endif
