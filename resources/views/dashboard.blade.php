<x-app-layout>
    {{-- <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Dashboard') }}
        </h2>
    </x-slot> --}}

    <div class="py-6">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                @if (Auth::user()->role === 'manager')
                    <div class="p-6 text-gray-900">
                        {{ __("Dashboard Manager") }}
                    </div>
                @endif

                @if (Auth::user()->role === 'program')
                    <div class="p-6 text-gray-900">
                        {{ __("Dashboard Program") }}
                    </div>
                @endif

                @if (Auth::user()->role === 'fundraising')
                        @forelse($programs as $program)
                            <div class="text-gray-900">
                                <div class="m-6 border p-4 rounded">
                                    <h2 class="text-xl font-semibold">{{ $program->name }}</h2>
                                    <p class="text-gray-500">{{ \Carbon\Carbon::parse($program->start_date)->translatedFormat('d F Y') }} - {{ \Carbon\Carbon::parse($program->end_date)->translatedFormat('d F Y') }}</p>
                                    {{-- <ul class="list-disc pl-6 mt-2">
                                        @forelse($program->indicators as $indicator)
                                            <li>{{ $indicator->name }}</li>
                                        @empty
                                            <li class="text-gray-500">Belum ada indikator untuk program ini.</li>
                                        @endforelse
                                    </ul> --}}
                                    <table class="min-w-full bg-white border border-gray-200 mt-3">
                                        <thead>
                                            <tr class="w-full bg-gray-100 border-b">
                                                <th class="px-6 py-3 text-left text-sm font-medium text-gray-600">No</th>
                                                <th class="px-6 py-3 text-left text-sm font-medium text-gray-600">Indikator</th>
                                                <th class="px-6 py-3 text-left text-sm font-medium text-gray-600">Deskripsi</th>
                                                <th class="px-6 py-3 text-left text-sm font-medium text-gray-600">Target</th>
                                                <th class="px-6 py-3 text-left text-sm font-medium text-gray-600">Unit</th>
                                                <th class="px-6 py-3 text-left text-sm font-medium text-gray-600">Capaian Aktual</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @forelse ($program->indicators as $indicator)
                                                <tr class="border-b hover:bg-gray-50">
                                                    <td class="px-6 py-4 text-sm text-gray-700">{{ $loop->iteration }}</td>
                                                    <td class="px-6 py-4 text-sm text-gray-700">{{ $indicator->name }}</td>
                                                    <td class="px-6 py-4 text-sm text-gray-700">{{ $indicator->description === null ? '-' : $indicator->description }}</td>
                                                    <td class="px-6 py-4 text-sm text-gray-700">{{ number_format($indicator->target, 0, '.', '.') }}</td>
                                                    <td class="px-6 py-4 text-sm text-gray-700">{{ $indicator->unit }}</td>
                                                    <td class="px-6 py-4 text-sm text-gray-700">-</td>
                                                </tr>
                                            @empty
                                                <tr class="border-b hover:bg-gray-50">
                                                    <td class="text-red-800 text-center p-6" colspan="6">Belum Ada Indikator Satupun☹️</td>
                                                </tr>
                                            @endforelse
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        @empty
                            <div class="p-6 text-gray-900">
                                <p class="text-red-800">Belum Ada Program Satupun☹️</p>
                            </div>
                        @endforelse
                @endif
            </div>
        </div>
    </div>
</x-app-layout>
