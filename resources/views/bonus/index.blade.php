<x-app-layout>
    <div class="py-6">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6">
                    <header>
                        <h2 class="text-lg font-medium text-gray-900">
                            {{ __('Daftar Karyawan Fundraising yang Mendapat Bonus') }}
                        </h2>
                        <p class="mt-1 text-sm text-gray-600">
                            {{ __("Karyawan fundraising yang memiliki kinerja lebih dari 100% akan mendapatkan bonus.") }}
                        </p>
                    </header>

                    @if($employees->isEmpty())
                        <p class="text-red-800 mt-4">Tidak ada karyawan fundraising yang memenuhi syarat bonus.</p>
                    @else
                        <table class="min-w-full bg-white border border-gray-200 mt-6">
                            <thead>
                                <tr class="bg-gray-100 border-b">
                                    <th class="px-6 py-3 text-left text-sm font-medium text-gray-600">No</th>
                                    <th class="px-6 py-3 text-left text-sm font-medium text-gray-600">Nama Karyawan</th>
                                    <th class="px-6 py-3 text-left text-sm font-medium text-gray-600">Program</th>
                                    <th class="px-6 py-3 text-left text-sm font-medium text-gray-600">Total Kinerja (%)</th>
                                    <th class="px-6 py-3 text-left text-sm font-medium text-gray-600">Gaji Pokok (Rp)</th>
                                    <th class="px-6 py-3 text-left text-sm font-medium text-gray-600">Bonus (Rp)</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($employees as $index => $employee)
                                    <tr class="border-b hover:bg-gray-50">
                                        <td class="px-6 py-4 text-sm text-gray-700">{{ $index + 1 }}</td>
                                        <td class="px-6 py-4 text-sm text-gray-700">{{ $employee->name }}</td>
                                        <td class="px-6 py-4 text-sm text-gray-700">{{ $employee->program_name }}</td>
                                        <td class="px-6 py-4 text-sm text-gray-700">{{ number_format($employee->total_final_score, 2, '.', '.') }}</td>
                                        <td class="px-6 py-4 text-sm text-gray-700">{{ number_format($employee->salary, 0, '.', '.') }}</td>
                                        <td class="px-6 py-4 text-sm text-gray-700 text-green-600 font-semibold">
                                            {{ number_format($employee->bonus, 0, '.', '.') }}
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    @endif
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
