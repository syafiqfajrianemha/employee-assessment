<x-app-layout>
    <div class="py-6">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6">
                    <header>
                        <h2 class="text-lg font-medium text-gray-900">
                            {{ __('Hitung Kinerja') }}
                        </h2>

                        <p class="mt-1 text-sm text-gray-600">
                            {{ __("Indikator ini digunakan untuk mengukur keberhasilan dalam menghimpun dana selama periode tertentu.") }}
                        </p>
                    </header>

                    <form data-action="{{ route('calculate.store') }}" method="POST" class="mt-6 space-y-6" id="performanceForm">
                        @csrf

                        <table class="min-w-full bg-white border border-gray-200">
                            <thead>
                                <tr class="w-full bg-gray-100 border-b">
                                    <th class="px-6 py-3 text-left text-sm font-medium text-gray-600">Key Performance Indicator</th>
                                    <th class="px-6 py-3 text-left text-sm font-medium text-gray-600">Bobot</th>
                                    <th class="px-6 py-3 text-left text-sm font-medium text-gray-600">Target</th>
                                    <th class="px-6 py-3 text-left text-sm font-medium text-gray-600">Capaian Aktual</th>
                                    <th class="px-6 py-3 text-left text-sm font-medium text-gray-600">Skor</th>
                                    <th class="px-6 py-3 text-left text-sm font-medium text-gray-600">Skor Akhir</th>
                                </tr>
                            </thead>
                            <tbody id="performanceTable">
                                @forelse($indicators as $indicator)
                                    @php
                                        $performance = $performances->firstWhere('indicator_id', $indicator->id);
                                    @endphp
                                    <tr class="border-b hover:bg-gray-50">
                                        <td class="px-6 py-4 text-sm text-gray-700">{{ $indicator->name }}</td>
                                        <td class="px-6 py-4 text-sm text-gray-700">
                                            {{ $indicator->roc_weight }}
                                            <input type="number" class="bobot border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm" value="{{ $indicator->roc_weight }}" readonly hidden>
                                        </td>
                                        <td class="px-6 py-4 text-sm text-gray-700">
                                            {{ number_format($indicator->target, 0, '.', '.') }} ({{ $indicator->unit }})
                                            <input type="number" class="target border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm" value="{{ $indicator->target }}" readonly hidden>
                                        </td>
                                        <td class="px-6 py-4 text-sm text-gray-700">
                                            <input type="number" min="0" class="realisasi border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm" value="{{ $performance ? $performance->actual : '' }}">
                                        </td>
                                        <td class="px-6 py-4 text-sm text-gray-700">
                                            <input type="text" min="0" class="skor border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm" readonly value="{{ $performance ? number_format($performance->score, 2, '.', '.') : '' }}">
                                        </td>
                                        <td class="px-6 py-4 text-sm text-gray-700">
                                            <input type="text" min="0" class="skor-akhir border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm" readonly value="{{ $performance ? number_format($performance->final_score, 2, '.', '.') : '' }}">
                                        </td>
                                        <td class="px-6 py-4 text-sm text-gray-700" hidden>
                                            <input type="number" class="indicator-id" value="{{ $indicator->id }}" hidden>
                                        </td>
                                    </tr>
                                @empty
                                    <tr class="border-b hover:bg-gray-50">
                                        <td class="text-red-800 text-center p-6" colspan="6">Belum Ada Indikator Satupun☹️</td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>

                        <div class="flex items-center gap-4">
                            <x-primary-button type="submit" class="btn-submit">{{ __('Simpan') }}</x-primary-button>
                            {{-- <button type="button" id="savePerformance" class="px-4 py-2 mt-4 bg-blue-600 text-white rounded">Simpan</button> --}}
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    @push('script')
        <script src="https://code.jquery.com/jquery-3.6.0.min.js" integrity="sha256-/xUj+3OJU5yExlq6GSYGSHk7tPXikynS7ogEvDej/m4=" crossorigin="anonymous"></script>
        <script src="//cdn.jsdelivr.net/npm/sweetalert2@10"></script>

        <script>
            const form = document.querySelector('#performanceForm');
            const rows = document.querySelectorAll('#performanceTable tr');

            rows.forEach(row => {
                const realisasiInput = row.querySelector('.realisasi');
                const bobotInput = row.querySelector('.bobot');
                const targetInput = row.querySelector('.target');
                const skorInput = row.querySelector('.skor');
                const skorAkhirInput = row.querySelector('.skor-akhir');

                realisasiInput.addEventListener('input', function () {
                    const realisasi = parseFloat(realisasiInput.value) || 0;
                    const target = parseFloat(targetInput.value) || 1;
                    const bobot = parseFloat(bobotInput.value) || 0;

                    const skor = (realisasi / target) * 100;
                    const skorAkhir = bobot * skor

                    skorInput.value = skor.toFixed(2);
                    skorAkhirInput.value = skorAkhir.toFixed(2);
                });
            });

            $('.btn-submit').click(function (e) {
                e.preventDefault();

                const performances = [];
                rows.forEach(row => {
                    performances.push({
                        user_id: {{ $userId }},
                        program_id: {{ $programId }},
                        indicator_id: row.querySelector('.indicator-id').value,
                        target: row.querySelector('.target').value,
                        actual: row.querySelector('.realisasi').value,
                        score: row.querySelector('.skor').value,
                        final_score: row.querySelector('.skor-akhir').value,
                    });
                });

                $.ajax({
                    url: form.dataset.action,
                    type: 'POST',
                    data: {
                        _token: '{{ csrf_token() }}',
                        performances: performances,
                    },
                    success: function (response) {
                        // Swal.fire('Berhasil', 'Data kinerja berhasil disimpan.', 'success');
                        Swal.fire({
                            icon: 'success',
                            title: 'Data Kinerja Berhasil di Simpan.',
                            showConfirmButton: true,
                        }).then((result) => {
                            if (result.isConfirmed) {
                                window.location.href = '{{ route('calculate.index') }}';
                            }
                        });
                    },
                    error: function (xhr) {
                        console.error(xhr.responseText);
                        Swal.fire('Error!', 'Terjadi kesalahan saat menyimpan data.', 'error');
                    }
                });
            });
        </script>
    @endpush
</x-app-layout>
