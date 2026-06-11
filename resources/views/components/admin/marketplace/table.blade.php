@props(['items', 'columns'])

<section class="overflow-hidden rounded-lg border border-zinc-200 bg-white shadow-sm">
    <table class="min-w-full divide-y divide-zinc-200 text-sm">
        <thead class="bg-zinc-50 text-left text-xs font-semibold uppercase text-zinc-500">
            <tr>
                @foreach ($columns as $label)
                    <th class="px-4 py-3">{{ $label }}</th>
                @endforeach
            </tr>
        </thead>
        <tbody class="divide-y divide-zinc-100">
            @forelse ($items as $item)
                <tr>
                    @foreach ($columns as $key => $label)
                        <td class="px-4 py-3">{{ is_bool($item->{$key}) ? ($item->{$key} ? 'Có' : 'Không') : $item->{$key} }}</td>
                    @endforeach
                </tr>
            @empty
                <tr><td class="px-4 py-5 text-zinc-500" colspan="{{ count($columns) }}">Chưa có dữ liệu.</td></tr>
            @endforelse
        </tbody>
    </table>
    <div class="border-t border-zinc-200 p-4">{{ $items->links() }}</div>
</section>
