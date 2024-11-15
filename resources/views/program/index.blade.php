<x-app-layout>
    {{-- <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Dashboard') }}
        </h2>
    </x-slot> --}}

    <div class="py-6">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="pt-6 px-6 text-gray-900">
                    {{-- {{ __("User Page.") }} --}}
                    {{-- <button class="px-4 py-2 bg-green-500 text-white font-semibold rounded-lg shadow-md hover:bg-green-600 focus:outline-none focus:ring-2 focus:ring-green-400 focus:ring-opacity-75">
                        Tambah Data
                    </button> --}}
                    <x-primary-href :href="route('program.create')">
                        {{ __('Add Program') }}
                    </x-primary-href>
                </div>

                <div class="overflow-x-auto p-6">
                    <table class="min-w-full bg-white border border-gray-200">
                        <thead>
                            <tr class="w-full bg-gray-100 border-b">
                                <th class="px-6 py-3 text-left text-sm font-medium text-gray-600">No</th>
                                <th class="px-6 py-3 text-left text-sm font-medium text-gray-600">Name</th>
                                <th class="px-6 py-3 text-left text-sm font-medium text-gray-600">Description</th>
                                <th class="px-6 py-3 text-left text-sm font-medium text-gray-600">Start</th>
                                <th class="px-6 py-3 text-left text-sm font-medium text-gray-600">End</th>
                                <th class="px-6 py-3 text-left text-sm font-medium text-gray-600">Duration</th>
                                <th class="px-6 py-3 text-left text-sm font-medium text-gray-600">Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse ($programs as $program)
                                <tr class="border-b hover:bg-gray-50">
                                    <td class="px-6 py-4 text-sm text-gray-700">{{ $loop->iteration }}</td>
                                    <td class="px-6 py-4 text-sm text-gray-700">{{ $program->name }}</td>
                                    <td class="px-6 py-4 text-sm text-gray-700">{{ $program->description }}</td>
                                    <td class="px-6 py-4 text-sm text-gray-700">{{ \Carbon\Carbon::parse($program->start_date)->translatedFormat('d F Y') }}</td>
                                    <td class="px-6 py-4 text-sm text-gray-700">{{ \Carbon\Carbon::parse($program->end_date)->translatedFormat('d F Y') }}</td>
                                    <td class="px-6 py-4 text-sm text-gray-700">{{ $program->duration }}</td>
                                    <td class="px-6 py-4 inline-flex">
                                        <x-primary-href :href="route('program.edit', $program->id)" class="mr-2">
                                            {{ __('Edit') }}
                                        </x-primary-href>
                                        <form action="{{ route('program.destroy', $program->id) }}" method="POST">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="inline-flex items-center px-4 py-2 bg-gray-800 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-gray-700 focus:bg-gray-700 active:bg-gray-900 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 transition ease-in-out duration-150 cursor-pointer">Delete</button>
                                        </form>
                                    </td>
                                </tr>
                            @empty
                                <tr class="border-b hover:bg-gray-50">
                                    <td class="text-red-800 text-center p-6" colspan="7">There is no data.</td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
