<table class="min-w-full bg-white border border-gray-200 mb-5">
    <thead>
        <tr class="w-full bg-gray-100 border-b">
            <th class="px-6 py-3 text-left text-sm font-medium text-gray-600">No</th>
            <th class="px-6 py-3 text-left text-sm font-medium text-gray-600">Nama Program</th>
            <th class="px-6 py-3 text-left text-sm font-medium text-gray-600">Indikator</th>
            <th class="px-6 py-3 text-left text-sm font-medium text-gray-600">Deskripsi</th>
            <th class="px-6 py-3 text-left text-sm font-medium text-gray-600">Urutan Prioritas</th>
            <th class="px-6 py-3 text-left text-sm font-medium text-gray-600">Bobot</th>
            <th class="px-6 py-3 text-left text-sm font-medium text-gray-600">Target</th>
            <th class="px-6 py-3 text-left text-sm font-medium text-gray-600">Unit</th>
            <th class="px-6 py-3 text-left text-sm font-medium text-gray-600">Aksi</th>
        </tr>
    </thead>
    <tbody>
        @forelse ($indicators as $indicator)
            <tr class="border-b hover:bg-gray-50">
                <td class="px-6 py-4 text-sm text-gray-700">{{ ++$no }}</td>
                <td class="px-6 py-4 text-sm text-gray-700">{{ $indicator->program->name }}</td>
                <td class="px-6 py-4 text-sm text-gray-700">{{ $indicator->name }}</td>
                <td class="px-6 py-4 text-sm text-gray-700">{{ $indicator->description === null ? '-' : $indicator->description }}</td>
                <td class="px-6 py-4 text-sm text-gray-700">{{ $indicator->rank }}</td>
                <td class="px-6 py-4 text-sm text-gray-700">{{ $indicator->roc_weight }}</td>
                <td class="px-6 py-4 text-sm text-gray-700">{{ number_format($indicator->target, 0, '.', '.') }}</td>
                <td class="px-6 py-4 text-sm text-gray-700">{{ $indicator->unit }}</td>
                <td class="px-6 py-4 text-sm text-gray-700">
                    <x-primary-href :href="route('indicator.edit', $indicator->id)" class="mb-2">
                        {{ __('Edit') }}
                    </x-primary-href>
                    <form action="{{ route('indicator.destroy', $indicator->id) }}" method="POST" class="form-delete">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="px-4 py-2 bg-gray-800 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-gray-700 focus:bg-gray-700 active:bg-gray-900 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 transition ease-in-out duration-150 cursor-pointer">Hapus</button>
                    </form>
                </td>
            </tr>
        @empty
            <tr class="border-b hover:bg-gray-50">
                <td class="text-red-800 text-center p-6" colspan="9">Belum Ada Indikator Satupun☹️</td>
            </tr>
        @endforelse
    </tbody>
</table>
{{ $indicators->links() }}
