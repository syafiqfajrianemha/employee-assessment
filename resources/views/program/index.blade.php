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
                    {{-- {{ __("User Page.") }} --}}
                    {{-- <button class="px-4 py-2 bg-green-500 text-white font-semibold rounded-lg shadow-md hover:bg-green-600 focus:outline-none focus:ring-2 focus:ring-green-400 focus:ring-opacity-75">
                        Tambah Data
                    </button> --}}
                    @if (Auth::user()->role === 'program')
                        <x-primary-href :href="route('program.create')">
                            {{ __('Tambah Program') }}
                        </x-primary-href>
                    @endif

                    @if (Auth::user()->role === 'manager')
                        <x-primary-href :href="route('assign.index')">
                            {{ __('Edit Assign') }}
                        </x-primary-href>
                    @endif
                </div>

                <div class="overflow-x-auto p-6">
                    <table class="min-w-full bg-white border border-gray-200 mb-5">
                        <thead>
                            <tr class="w-full bg-gray-100 border-b">
                                <th class="px-6 py-3 text-left text-sm font-medium text-gray-600">No</th>
                                <th class="px-6 py-3 text-left text-sm font-medium text-gray-600">Nama</th>
                                <th class="px-6 py-3 text-left text-sm font-medium text-gray-600">Tujuan</th>
                                <th class="px-6 py-3 text-left text-sm font-medium text-gray-600">Deskripsi</th>
                                <th class="px-6 py-3 text-left text-sm font-medium text-gray-600">Tanggal Pelaksanaan</th>
                                <th class="px-6 py-3 text-left text-sm font-medium text-gray-600">Status</th>
                                <th class="px-6 py-3 text-left text-sm font-medium text-gray-600">Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse ($programs as $program)
                                <tr class="border-b hover:bg-gray-50">
                                    <td class="px-6 py-4 text-sm text-gray-700">{{ ++$no }}</td>
                                    <td class="px-6 py-4 text-sm text-gray-700">{{ $program->name }}</td>
                                    <td class="px-6 py-4 text-sm text-gray-700">{{ $program->purpose }}</td>
                                    <td class="px-6 py-4 text-sm text-gray-700">{{ $program->description }}</td>
                                    <td class="px-6 py-4 text-sm text-gray-700">{{ \Carbon\Carbon::parse($program->start_date)->translatedFormat('d F Y') }} - {{ \Carbon\Carbon::parse($program->end_date)->translatedFormat('d F Y') }} ({{ $program->duration }})</td>
                                    <td class="px-6 py-4 text-sm text-gray-700">
                                        @if ($program->status === 'waiting')
                                            <span class="block text-center bg-yellow-100 text-yellow-800 text-xs font-medium p-1 rounded dark:bg-yellow-900 dark:text-yellow-300">Menunggu Persetujuan</span>
                                        @elseif ($program->status === 'approved')
                                            <span class="block text-center bg-green-100 text-green-800 text-xs font-medium p-1 rounded dark:bg-green-900 dark:text-green-300">Disetujui</span>
                                        @elseif ($program->status === 'rejected')
                                            <span class="block bg-red-100 text-red-800 text-xs font-medium p-1 rounded dark:bg-red-900 dark:text-red-300">{{ $program->rejected_note }}</span>
                                        @endif
                                    </td>
                                    @if (Auth::user()->role === 'program')
                                        @if ($program->status !== 'approved')
                                            <td class="px-6 py-4 text-sm text-gray-700">
                                                <x-primary-href :href="route('program.edit', $program->id)" class="mb-2">
                                                    {{ __('Edit') }}
                                                </x-primary-href>
                                                <form action="{{ route('program.destroy', $program->id) }}" method="POST" class="form-delete"">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="submit" class="px-4 py-2 bg-gray-800 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-gray-700 focus:bg-gray-700 active:bg-gray-900 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 transition ease-in-out duration-150 cursor-pointer">Hapus</button>
                                                </form>
                                            </td>
                                        @endif
                                        @if ($program->status === 'approved') <td class="px-6 py-4 text-sm text-gray-700">-</td> @endif
                                    @endif
                                    @if (Auth::user()->role === 'manager')
                                        @if ($program->status !== 'approved' && $program->status !== 'rejected')
                                            <td class="px-6 py-4 text-sm text-gray-700">
                                                <form action="{{ route('program.update.status', $program->id) }}" method="POST" class="form-approved">
                                                    @csrf
                                                    <input type="hidden" name="status" value="approved">
                                                    <button type="submit" class="px-4 py-2 bg-gray-800 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-gray-700 focus:bg-gray-700 active:bg-gray-900 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 transition ease-in-out duration-150 cursor-pointer mb-2">Setujui</button>
                                                </form>
                                                <form action="{{ route('program.update.status', $program->id) }}" method="POST" class="form-rejected">
                                                    @csrf
                                                    <input type="hidden" name="status" value="rejected">
                                                    <input type="hidden" name="rejected_note" class="rejected-note">
                                                    <button type="submit" class="px-4 py-2 bg-gray-800 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-gray-700 focus:bg-gray-700 active:bg-gray-900 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 transition ease-in-out duration-150 cursor-pointer">Tolak</button>
                                                </form>
                                            </td>
                                        @endif
                                        @if ($program->status === 'approved')
                                            <td class="px-6 py-4 text-sm text-gray-700">
                                                <form action="{{ route('assign.store') }}" method="POST" class="form-assign" data-program-id="{{ $program->id }}" data-program-name="{{ $program->name }}">
                                                    @csrf
                                                    <input type="hidden" name="program_id" value="{{ $program->id }}">
                                                    <input type="hidden" name="user_id" class="user_id">
                                                    <button type="submit" class="px-4 py-2 bg-gray-800 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-gray-700 focus:bg-gray-700 active:bg-gray-900 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 transition ease-in-out duration-150 cursor-pointer">Assign</button>
                                                </form>
                                            </td>
                                        @endif
                                    @endif
                                </tr>
                            @empty
                                <tr class="border-b hover:bg-gray-50">
                                    <td class="text-red-800 text-center p-6" colspan="7">Belum Ada Program Satupun☹️</td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                    {{ $programs->links() }}
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
                $('.form-assign button').on('click', function(e) {
                    e.preventDefault(); // Mencegah submit form langsung

                    // Ambil form terkait tombol yang diklik
                    const form = $(this).closest('.form-assign');
                    const programId = form.data('program-id');
                    const programName = form.data('program-name');

                    // Ambil data users dari server
                    $.ajax({
                        url: '{{ route("users.get") }}', // Pastikan route ini mengembalikan data users
                        type: 'GET',
                        success: function(users) {
                            // Buat select option HTML
                            let selectOptions = '<select id="userSelect" class="swal2-input">';
                            users.forEach(function(user) {
                                selectOptions += `<option value="${user.id}">${user.name}</option>`;
                            });
                            selectOptions += '</select>';

                            // Tampilkan SweetAlert dengan select
                            Swal.fire({
                                title: `${programName} Akan Di Assign Ke`,
                                html: selectOptions,
                                showCancelButton: true,
                                confirmButtonText: 'Assign',
                                cancelButtonText: 'Batal',
                                preConfirm: () => {
                                    const selectedUserId = Swal.getPopup().querySelector('#userSelect').value;
                                    if (!selectedUserId) {
                                        Swal.showValidationMessage('Anda harus memilih user!');
                                    }
                                    return selectedUserId;
                                }
                            }).then((result) => {
                                if (result.isConfirmed) {
                                    const selectedUserId = result.value;

                                    // Isi input hidden `user_id` dengan user yang dipilih
                                    form.find('.user_id').val(selectedUserId);

                                    // Submit form
                                    form.submit();
                                }
                            });
                        },
                        error: function() {
                            Swal.fire('Error', 'Gagal memuat data user', 'error');
                        }
                    });
                });
            });
        </script>
    @endpush
</x-app-layout>
