<x-app-layout>
    <div class="py-6">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                @can ('access-manager')
                    <div class="p-6 text-gray-900">
                        {{ __("Dashboard Manager") }}
                    </div>
                @endcan

                @can ('access-program')
                    <div class="p-6 text-gray-900">
                        {{ __("Dashboard Program") }}
                    </div>
                @endcan

                @can ('access-fundraising')
                        @forelse($programs as $program)
                            <div class="text-gray-900">
                                <div class="m-6 border p-4 rounded">
                                    <h2 class="text-xl font-semibold">{{ $program->name }}</h2>
                                    <p class="text-gray-500">{{ \Carbon\Carbon::parse($program->start_date)->translatedFormat('d F Y') }} - {{ \Carbon\Carbon::parse($program->end_date)->translatedFormat('d F Y') }}</p>

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
                                                    <td class="px-6 py-4 text-sm text-gray-700">{{ $indicator->description ?? '-'}}</td>
                                                    <td class="px-6 py-4 text-sm text-gray-700">{{ number_format($indicator->target, 0, '.', '.') }}</td>
                                                    <td class="px-6 py-4 text-sm text-gray-700">{{ $indicator->unit }}</td>
                                                    <td class="px-6 py-4 text-sm text-gray-700">
                                                        @if ($indicator->performances->isEmpty())
                                                            <span class="text-red-500">Belum diinputkan oleh manajer</span>
                                                        @else
                                                            {{ number_format($indicator->performances[0]->actual ?? 0, 0, '.', '.') }}
                                                        @endif
                                                    </td>
                                                </tr>
                                            @empty
                                                <tr class="border-b hover:bg-gray-50">
                                                    <td class="text-red-800 text-center p-6" colspan="6">Belum Ada Indikator Satupun☹️</td>
                                                </tr>
                                            @endforelse
                                        </tbody>
                                    </table>

                                    @if ($program->hasilKinerja > 100)
                                        <div class="mt-6 text-gray-900">
                                            <p>
                                                📣Selamat kamu berhak mendapatkan bonus atas kinerja yang sangat luar biasa.
                                            </p>
                                        </div>

                                        <table class="min-w-full bg-white border border-gray-200 mt-1">
                                            <thead>
                                                <tr class="bg-gray-100 border-b">
                                                    <th class="px-6 py-3 text-left text-sm font-medium text-gray-600">No</th>
                                                    <th class="px-6 py-3 text-left text-sm font-medium text-gray-600">Total Kinerja (%)</th>
                                                    <th class="px-6 py-3 text-left text-sm font-medium text-gray-600">Gaji Pokok (Rp)</th>
                                                    <th class="px-6 py-3 text-left text-sm font-medium text-gray-600">Bonus (Rp)</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                @foreach($employees as $index => $employee)
                                                    <tr class="border-b hover:bg-gray-50">
                                                        <td class="px-6 py-4 text-sm text-gray-700">{{ $loop->iteration }}</td>
                                                        <td class="px-6 py-4 text-sm text-gray-700">{{ number_format($employee->total_final_score, 2, '.', '.') }}</td>
                                                        <td class="px-6 py-4 text-sm text-gray-700">{{ number_format($employee->salary, 0, '.', '.') }}</td>
                                                        <td class="px-6 py-4 text-sm text-gray-700 text-green-600 font-semibold">
                                                            {{ number_format($employee->bonus, 0, '.', '.') }}
                                                        </td>
                                                    </tr>
                                                @endforeach
                                            </tbody>
                                        </table>
                                    @else
                                        <div class="mt-6 text-gray-900">
                                            <p>
                                                Kinerja Kamu di Program <strong>{{ $program->name }}</strong> sebesar
                                                <strong>{{ number_format($program->hasilKinerja, 2, '.', ',') }}%</strong>
                                            </p>
                                        </div>
                                    @endif
                                </div>
                            </div>
                        @empty
                            <div class="p-6 text-gray-900">
                                <p class="text-red-800">Belum Ada Program Satupun☹️</p>
                            </div>
                        @endforelse
                @endcan
            </div>
        </div>
    </div>
</x-app-layout>
