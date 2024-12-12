<x-app-layout>
    <div class="py-6">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6">
                    <header>
                        <h2 class="text-lg font-medium text-gray-900">
                            {{ __('Tambah Indikator') }}
                        </h2>

                        <p class="mt-1 text-sm text-gray-600">
                            {{ __("Indikator ini digunakan untuk mengukur keberhasilan dalam menghimpun dana selama periode tertentu.") }}
                        </p>
                    </header>

                    <form method="post" action="{{ route('indicator.store') }}" class="mt-6 space-y-6">
                        @csrf

                        <div class="mt-4">
                            <x-input-label for="program" :value="__('Program*')" />
                            <x-select-option id="program" class="block mt-1 w-full" name="program_id" :value="old('program')" required>
                                <option selected disabled>Pilih Program</option>
                                @foreach ($programs as $program)
                                <option {{ old('program_id') == $program->id ? "selected" : "" }} value="{{ $program->id }}">{{ $program->name }}</option>
                                @endforeach
                            </x-select-option>
                            <x-input-error :messages="$errors->get('program')" class="mt-2" />
                        </div>

                        <div>
                            <x-input-label for="name" :value="__('Nama Indikator*')" />
                            <x-text-input id="name" name="name" type="text" class="mt-1 block w-full" :value="old('name')" required />
                            <x-input-error class="mt-2" :messages="$errors->get('name')" />
                        </div>

                        <div class="mt-4">
                            <x-input-label for="description" :value="__('Deskripsi')" />
                            <textarea id="description" name="description" rows="4" class="mt-1 block w-full border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm">{{ old('description') }}</textarea>
                            <x-input-error class="mt-2" :messages="$errors->get('description')" />
                        </div>

                        <div class="mt-4">
                            <x-input-label for="rank" :value="__('Urutan Prioritas*')" />
                            <x-select-option id="rank" class="block mt-1 w-full" name="rank" :value="old('rank')" required>
                                <option selected disabled>Pilih Urutan Prioritas</option>
                                <option {{ old('rank') == 1 ? "selected" : "" }} value="1">1</option>
                                <option {{ old('rank') == 2 ? "selected" : "" }} value="2">2</option>
                                <option {{ old('rank') == 3 ? "selected" : "" }} value="3">3</option>
                                <option {{ old('rank') == 4 ? "selected" : "" }} value="4">4</option>
                                <option {{ old('rank') == 5 ? "selected" : "" }} value="5">5</option>
                                <option {{ old('rank') == 6 ? "selected" : "" }} value="6">6</option>
                                <option {{ old('rank') == 7 ? "selected" : "" }} value="7">7</option>
                                <option {{ old('rank') == 8 ? "selected" : "" }} value="8">8</option>
                                <option {{ old('rank') == 9 ? "selected" : "" }} value="9">9</option>
                                <option {{ old('rank') == 10 ? "selected" : "" }} value="10">10</option>
                            </x-select-option>
                            <x-input-error :messages="$errors->get('rank')" class="mt-2" />
                        </div>

                        <div>
                            <x-input-label for="target" :value="__('Target*')" />
                            <x-text-input id="target" name="target" type="number" min="0" class="mt-1 block w-full" :value="old('target')" required />
                            <x-input-error class="mt-2" :messages="$errors->get('target')" />
                        </div>

                        <div>
                            <x-input-label for="unit" :value="__('Unit*')" />
                            <x-text-input id="unit" name="unit" type="text" class="mt-1 block w-full" :value="old('unit')" required />
                            <x-input-error class="mt-2" :messages="$errors->get('unit')" />
                        </div>

                        <div class="flex items-center gap-4">
                            <x-primary-button>{{ __('Tambah') }}</x-primary-button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
