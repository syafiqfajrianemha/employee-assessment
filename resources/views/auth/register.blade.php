<x-guest-layout>
    <form method="POST" action="{{ route('register') }}">
        @csrf

        <div>
            <x-input-label for="name" :value="__('Nama*')" />
            <x-text-input id="name" class="block mt-1 w-full" type="text" name="name" :value="old('name')" required autofocus autocomplete="name" />
            <x-input-error :messages="$errors->get('name')" class="mt-2" />
        </div>

        <div class="mt-4">
            <x-input-label for="email" :value="__('Email*')" />
            <x-text-input id="email" class="block mt-1 w-full" type="email" name="email" :value="old('email')" required autocomplete="username" />
            <x-input-error :messages="$errors->get('email')" class="mt-2" />
        </div>

        <div class="mt-4">
            <x-input-label for="role" :value="__('Role*')" />
            <x-select-option id="role" class="block mt-1 w-full" name="role" :value="old('role')" required>
                <option selected disabled>Choose Role</option>
                <option {{ old('role') == "admin" ? "selected" : "" }} value="admin">Admin</option>
                <option {{ old('role') == "employee" ? "selected" : "" }} value="employee">Karyawan</option>
                <option {{ old('role') == "manager" ? "selected" : "" }} value="manager">Manajer</option>
                <option {{ old('role') == "finance" ? "selected" : "" }} value="finance">Keuangan</option>
                <option {{ old('role') == "program" ? "selected" : "" }} value="program">Program</option>
                <option {{ old('role') == "fundraising" ? "selected" : "" }} value="fundraising">Fundraising</option>
            </x-select-option>
            <x-input-error :messages="$errors->get('role')" class="mt-2" />
        </div>

        <div class="mt-4">
            <x-input-label for="salary" :value="__('Salary')" />
            <x-text-input id="salary" class="block mt-1 w-full" type="number" min="0" name="salary" :value="old('salary')" value="0" />
            <x-input-error :messages="$errors->get('salary')" class="mt-2" />
        </div>

        <!-- Password -->
        <div class="mt-4">
            <x-input-label for="password" :value="__('Password*')" />

            <x-text-input id="password" class="block mt-1 w-full"
                            type="password"
                            name="password"
                            required autocomplete="new-password" />

            <x-input-error :messages="$errors->get('password')" class="mt-2" />
        </div>

        <!-- Confirm Password -->
        <div class="mt-4">
            <x-input-label for="password_confirmation" :value="__('Ulangi Password*')" />

            <x-text-input id="password_confirmation" class="block mt-1 w-full"
                            type="password"
                            name="password_confirmation" required autocomplete="new-password" />

            <x-input-error :messages="$errors->get('password_confirmation')" class="mt-2" />
        </div>

        <div class="flex items-center justify-end mt-4">
            <x-primary-button class="ms-4">
                {{ __('Daftar') }}
            </x-primary-button>
        </div>
    </form>
</x-guest-layout>
