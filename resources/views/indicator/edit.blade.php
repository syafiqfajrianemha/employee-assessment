<x-app-layout>
    <div class="py-6">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6">
                    <header>
                        <h2 class="text-lg font-medium text-gray-900">
                            {{ __('Edit Indikator') }}
                        </h2>

                        <p class="mt-1 text-sm text-gray-600">
                            {{ __("Indikator ini digunakan untuk mengukur keberhasilan dalam menghimpun dana selama periode tertentu.") }}
                        </p>
                    </header>

                    <form method="post" action="{{ route('indicator.update', $indicator->id) }}" class="mt-6 space-y-6">
                        @csrf
                        @method('PATCH')

                        <div class="mt-4">
                            <x-input-label for="program" :value="__('Program*')" />
                            <x-select-option id="program" class="block mt-1 w-full" name="program_id" :value="old('program')" required>
                                <option selected disabled>Pilih Program</option>
                                @foreach ($programs as $program)
                                <option value="{{ $program->id }}"
                                    @if ($program->id == $indicator->program_id)
                                        selected
                                    @endif>
                                    {{ $program->name }}
                                </option>
                                @endforeach
                            </x-select-option>
                            <x-input-error :messages="$errors->get('program')" class="mt-2" />
                        </div>

                        <div>
                            <x-input-label for="name" :value="__('Nama Indikator*')" />
                            <x-text-input id="name" name="name" type="text" class="mt-1 block w-full" value="{{ !old('name') ? $indicator->name : old('name') }}" required />
                            <x-input-error class="mt-2" :messages="$errors->get('name')" />
                        </div>

                        <div class="mt-4">
                            <x-input-label for="description" :value="__('Deskripsi')" />
                            <textarea id="description" name="description" rows="4" class="mt-1 block w-full border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm">{{ !old('description') ? $indicator->description : old('description') }}</textarea>
                            <x-input-error class="mt-2" :messages="$errors->get('description')" />
                        </div>

                        <div class="mt-4">
                            <x-input-label for="rank" :value="__('Urutan Prioritas*')" />
                            <x-select-option id="rank" class="block mt-1 w-full" name="rank" :value="old('rank')" required>
                                <option selected disabled>Pilih Urutan Prioritas</option>
                                <option value="1" @if ($indicator->rank == 1) selected @endif>1</option>
                                <option value="2" @if ($indicator->rank == 2) selected @endif>2</option>
                                <option value="3" @if ($indicator->rank == 3) selected @endif>3</option>
                                <option value="4" @if ($indicator->rank == 4) selected @endif>4</option>
                                <option value="5" @if ($indicator->rank == 5) selected @endif>5</option>
                                <option value="6" @if ($indicator->rank == 6) selected @endif>6</option>
                                <option value="7" @if ($indicator->rank == 7) selected @endif>7</option>
                                <option value="8" @if ($indicator->rank == 8) selected @endif>8</option>
                                <option value="9" @if ($indicator->rank == 9) selected @endif>9</option>
                                <option value="10" @if ($indicator->rank == 10) selected @endif>10</option>
                            </x-select-option>
                            <x-input-error :messages="$errors->get('rank')" class="mt-2" />
                        </div>

                        <div>
                            <x-input-label for="target" :value="__('Target*')" />
                            <x-text-input id="target" name="target" type="number" min="0" class="mt-1 block w-full" value="{{ !old('target') ? $indicator->target : old('target') }}" required />
                            <x-input-error class="mt-2" :messages="$errors->get('target')" />
                        </div>

                        <div>
                            <x-input-label for="unit" :value="__('Unit*')" />
                            <x-text-input id="unit" name="unit" type="text" class="mt-1 block w-full" value="{{ !old('unit') ? $indicator->unit : old('unit') }}" required />
                            <x-input-error class="mt-2" :messages="$errors->get('unit')" />
                        </div>

                        <div class="flex items-center gap-4">
                            <x-primary-button>{{ __('Edit') }}</x-primary-button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
