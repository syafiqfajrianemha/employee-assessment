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
                <div class="pt-6 px-6 text-gray-900 flex justify-between items-center">
                    {{-- {{ __("User Page.") }} --}}
                    {{-- <button class="px-4 py-2 bg-green-500 text-white font-semibold rounded-lg shadow-md hover:bg-green-600 focus:outline-none focus:ring-2 focus:ring-green-400 focus:ring-opacity-75">
                        Tambah Data
                    </button> --}}
                    <x-primary-href :href="route('indicator.create')">
                        {{ __('Tambah Indikator') }}
                    </x-primary-href>

                    <select id="indicatorFilter" class="border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm">
                        <option selected disabled>Cari Berdasarkan Program</option>
                        @foreach ($programs as $program)
                            <option value="{{ $program->id }}">{{ $program->name }}</option>
                        @endforeach
                    </select>
                </div>

                <div class="overflow-x-auto p-6" id="indicatorList">
                    @include('indicator._list')
                </div>
            </div>
        </div>
    </div>

    @push('script')
        <script src="https://code.jquery.com/jquery-3.6.0.min.js" integrity="sha256-/xUj+3OJU5yExlq6GSYGSHk7tPXikynS7ogEvDej/m4=" crossorigin="anonymous"></script>
        <script src="//cdn.jsdelivr.net/npm/sweetalert2@10"></script>
        <script src="{{ asset('js/main.js') }}"></script>

        <script>
            $(document).ready(function() {
                $('#indicatorFilter').on('change', function() {
                    const programId = $(this).val();

                    $.ajax({
                        url: '{{ route("indicator.filter") }}',
                        type: 'GET',
                        data: { programId },
                        success: function(response) {
                            $('#indicatorList').html(response);
                        },
                        error: function() {
                            alert('Terjadi kesalahan saat memuat data');
                        }
                    });
                });
            });
        </script>
    @endpush
</x-app-layout>
