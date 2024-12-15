<x-app-layout>
    <div class="py-6">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6">
                    <header>
                        <h2 class="text-lg font-medium text-gray-900">
                            {{ __('Edit Assign') }}
                        </h2>

                        <p class="mt-1 text-sm text-gray-600">
                            {{ __("Tugaskan Program berserta Indikator ke Karyawan Fundraising.") }}
                        </p>
                    </header>

                    <form method="post" action="{{ route('assign.update', $assign->id) }}" class="mt-6 space-y-6">
                        @csrf
                        @method('PATCH')

                        <div class="mt-4">
                            <x-input-label for="program" :value="__('Program*')" />
                            <x-select-option id="program" class="block mt-1 w-full" name="program_id" :value="old('program')" required>
                                <option selected disabled>Pilih Program</option>
                                @foreach ($programs as $program)
                                <option value="{{ $program->id }}"
                                    @if ($program->id == $assign->program_id)
                                        selected
                                    @endif>
                                    {{ $program->name }}
                                </option>
                                @endforeach
                            </x-select-option>
                            <x-input-error :messages="$errors->get('program')" class="mt-2" />
                        </div>

                        <div class="mt-4">
                            <x-input-label for="user" :value="__('Nama Karyawan*')" />
                            <x-select-option id="user" class="block mt-1 w-full" name="user_id" :value="old('user')" required>
                                <option selected disabled>Pilih Nama Karyawan</option>
                                @foreach ($users as $user)
                                <option value="{{ $user->id }}"
                                    @if ($user->id == $assign->user_id)
                                        selected
                                    @endif>
                                    {{ $user->name }}
                                </option>
                                @endforeach
                            </x-select-option>
                            <x-input-error :messages="$errors->get('user')" class="mt-2" />
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
