<x-guest-layout>
    <form method="POST" action="{{ route('user.update', $user->id) }}">
        @csrf
        @method('PATCH')

        <div>
            <x-input-label for="name" :value="__('Nama*')" />
            <x-text-input id="name" class="block mt-1 w-full" type="text" name="name" value="{{ !old('name') ? $user->name : old('name') }}" required autocomplete="name" />
            <x-input-error :messages="$errors->get('name')" class="mt-2" />
        </div>

        <!-- Email Address -->
        <div class="mt-4">
            <x-input-label for="email" :value="__('Email*')" />
            <x-text-input id="email" class="block mt-1 w-full" type="email" name="email" value="{{ !old('email') ? $user->email : old('email') }}" required autocomplete="username" />
            <x-input-error :messages="$errors->get('email')" class="mt-2" />
        </div>

        <div class="mt-4">
            <x-input-label for="role" :value="__('Role*')" />
            <x-select-option id="role" class="block mt-1 w-full" name="role" :value="old('role')" required>
                <option selected disabled>Choose Role</option>
                <option value="admin" @if ($user->role == "admin") selected @endif>Admin</option>
                <option value="employee" @if ($user->role == "employee") selected @endif>Employee</option>
                <option value="manager" @if ($user->role == "manager") selected @endif>Manager</option>
                <option value="finance" @if ($user->role == "finance") selected @endif>Finance</option>
                <option value="program" @if ($user->role == "program") selected @endif>Program</option>
                <option value="fundraising" @if ($user->role == "fundraising") selected @endif>Fundraising</option>
            </x-select-option>
            <x-input-error :messages="$errors->get('role')" class="mt-2" />
        </div>

        <div class="mt-4">
            <x-input-label for="salary" :value="__('Salary')" />
            <x-text-input id="salary" class="block mt-1 w-full" type="number" min="0" name="salary" value="{{ !old('salary') ? $user->salary : old('salary') }}" />
            <x-input-error :messages="$errors->get('salary')" class="mt-2" />
        </div>

        <div class="flex items-center justify-end mt-4">
            <x-primary-button class="ms-4">
                {{ __('Edit') }}
            </x-primary-button>
        </div>
    </form>
</x-guest-layout>
