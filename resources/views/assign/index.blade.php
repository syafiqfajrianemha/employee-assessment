<x-app-layout>
    <div id="flash-data" data-flashdata="{{ session('message') }}"></div>
    {{-- <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Dashboard') }}
        </h2>
    </x-slot> --}}

    <div class="py-6">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="pt-6 px-6 text-gray-900">
                    <x-primary-href :href="route('program.index')">
                        {{ __('⬅️ Kembali') }}
                    </x-primary-href>
                </div>

                <div class="overflow-x-auto p-6">
                    <table class="min-w-full bg-white border border-gray-200">
                        <thead>
                            <tr class="w-full bg-gray-100 border-b">
                                <th class="px-6 py-3 text-left text-sm font-medium text-gray-600">No</th>
                                <th class="px-6 py-3 text-left text-sm font-medium text-gray-600">Nama Program</th>
                                <th class="px-6 py-3 text-left text-sm font-medium text-gray-600">Karyawan</th>
                                <th class="px-6 py-3 text-left text-sm font-medium text-gray-600">Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse ($assigns as $assign)
                                <tr class="border-b hover:bg-gray-50">
                                    <td class="px-6 py-4 text-sm text-gray-700">{{ $loop->iteration }}</td>
                                    <td class="px-6 py-4 text-sm text-gray-700">{{ $assign->program->name }}</td>
                                    <td class="px-6 py-4 text-sm text-gray-700">{{ $assign->user->name }}</td>
                                    <td class="px-6 py-4 text-sm text-gray-700">
                                        <x-primary-href :href="route('assign.edit', $assign->id)" class="mb-2">
                                            {{ __('Edit') }}
                                        </x-primary-href>
                                        <form action="{{ route('assign.destroy', $assign->id) }}" method="POST" class="form-delete">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="px-4 py-2 bg-gray-800 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-gray-700 focus:bg-gray-700 active:bg-gray-900 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 transition ease-in-out duration-150 cursor-pointer">Hapus</button>
                                        </form>
                                    </td>
                                </tr>
                            @empty
                                <tr class="border-b hover:bg-gray-50">
                                    <td class="text-red-800 text-center p-6" colspan="4">Belum Ada Assign Satupun☹️</td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>

    @push('script')
        <script src="https://code.jquery.com/jquery-3.6.0.min.js" integrity="sha256-/xUj+3OJU5yExlq6GSYGSHk7tPXikynS7ogEvDej/m4=" crossorigin="anonymous"></script>
        <script src="//cdn.jsdelivr.net/npm/sweetalert2@10"></script>
        <script src="{{ asset('js/main.js') }}"></script>
    @endpush
</x-app-layout>
