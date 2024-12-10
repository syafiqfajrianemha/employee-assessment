<x-app-layout>
    @push('style')
        <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/flatpickr/dist/flatpickr.min.css">
    @endpush

    <div class="py-6">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6">
                    <header>
                        <h2 class="text-lg font-medium text-gray-900">
                            {{ __('Edit Program') }}
                        </h2>

                        <p class="mt-1 text-sm text-gray-600">
                            {{ __("Program ini adalah rencana kegiatan yang akan dijalankan ke depan untuk mencapai tujuan yang telah ditetapkan, dilengkapi dengan jadwal dan catatan pelaksanaannya.") }}
                        </p>
                    </header>

                    @if ($program->status === 'rejected')
                        <p class="mt-6 block bg-red-100 text-red-800 text-small font-medium py-3 px-6 rounded dark:bg-red-900 dark:text-red-300">
                            📣 {{ $program->rejected_note }}
                        </p>
                    @endif

                    <form method="post" action="{{ route('program.update', $program->id) }}" class="mt-6 space-y-6">
                        @csrf
                        @method('PATCH')

                        <div>
                            <x-input-label for="name" :value="__('Nama Program*')" />
                            <x-text-input id="name" name="name" type="text" class="mt-1 block w-full" value="{{ !old('name') ? $program->name : old('name') }}" required />
                            <x-input-error class="mt-2" :messages="$errors->get('name')" />
                        </div>

                        <div class="mt-4">
                            <x-input-label :value="__('Tanggal Awal Program*')" />
                            <x-text-input id="date" name="start_date" type="text" class="mt-1 block w-full border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm" value="{{ !old('start_date') ? $program->start_date : old('start_date') }}" required />
                            <x-input-error class="mt-2" :messages="$errors->get('start_date')" />
                        </div>

                        <div class="mt-4">
                            <x-input-label :value="__('Tanggal Akhir Program*')" />
                            <x-text-input id="date" name="end_date" type="text" class="mt-1 block w-full border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm" value="{{ !old('end_date') ? $program->end_date : old('end_date') }}" required />
                            <x-input-error class="mt-2" :messages="$errors->get('end_date')" />
                        </div>

                        <div class="mt-4">
                            <x-input-label for="purpose" :value="__('Tujuan Program*')" />
                            <textarea id="purpose" name="purpose" rows="4" class="mt-1 block w-full border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm" required>{{ !old('purpose') ? $program->purpose : old('purpose') }}</textarea>
                            <x-input-error class="mt-2" :messages="$errors->get('purpose')" />
                        </div>

                        <div class="mt-4">
                            <x-input-label for="description" :value="__('Deskripsi Program')" />
                            <textarea id="description" name="description" rows="4" class="mt-1 block w-full border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm" required>{{ !old('description') ? $program->description : old('description') }}</textarea>
                            <x-input-error class="mt-2" :messages="$errors->get('description')" />
                        </div>

                        <div class="flex items-center gap-4">
                            <x-primary-button>{{ __('Edit') }}</x-primary-button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    @push('script')
        <script src="https://cdn.jsdelivr.net/npm/flatpickr"></script>
        <script>
            document.addEventListener("DOMContentLoaded", function() {
                flatpickr("#date", {
                    dateFormat: "Y-m-d",
                    altInput: true,
                    altFormat: "j F Y",
                    allowInput: true,
                });
            });
        </script>
    @endpush
</x-app-layout>
