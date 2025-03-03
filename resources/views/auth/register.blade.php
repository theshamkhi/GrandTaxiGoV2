<x-guest-layout>
    <!-- Register Form -->
    <form method="POST" action="{{ route('register') }}" enctype="multipart/form-data">
        @csrf

        <!-- Form Title -->
        <h2 class="text-3xl font-bold text-center text-gray-900 mb-8">Create Your Account</h2>

        <!-- Name -->
        <div class="mb-6">
            <x-input-label for="name" :value="__('Name')" class="block text-sm font-medium text-gray-700 mb-2" />
            <x-text-input id="name" class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-purple-500 focus:border-purple-500 transition duration-300"
                          type="text" name="name" :value="old('name')" required autofocus autocomplete="name" />
            <x-input-error :messages="$errors->get('name')" class="mt-2 text-sm text-red-600" />
        </div>

        <!-- Email Address -->
        <div class="mb-6">
            <x-input-label for="email" :value="__('Email')" class="block text-sm font-medium text-gray-700 mb-2" />
            <x-text-input id="email" class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-purple-500 focus:border-purple-500 transition duration-300"
                          type="email" name="email" :value="old('email')" required autocomplete="username" />
            <x-input-error :messages="$errors->get('email')" class="mt-2 text-sm text-red-600" />
        </div>

        <!-- Phone Number -->
        <div class="mb-6">
            <x-input-label for="phone" :value="__('Phone Number')" class="block text-sm font-medium text-gray-700 mb-2" />
            <x-text-input id="phone" class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-purple-500 focus:border-purple-500 transition duration-300"
                          type="text" name="phone" :value="old('phone')" autocomplete="tel" />
            <x-input-error :messages="$errors->get('phone')" class="mt-2 text-sm text-red-600" />
        </div>

        <!-- Role Selection -->
        <div class="mb-6">
            <x-input-label for="role" :value="__('Register As')" class="block text-sm font-medium text-gray-700 mb-2" />
            <select id="role" name="role" class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-purple-500 focus:border-purple-500 transition duration-300" required>
                <option value="passenger" {{ old('role') == 'passenger' ? 'selected' : '' }}>Passenger</option>
                <option value="driver" {{ old('role') == 'driver' ? 'selected' : '' }}>Driver</option>
            </select>
            <x-input-error :messages="$errors->get('role')" class="mt-2 text-sm text-red-600" />
        </div>

        <!-- Profile Photo -->
        <div class="mb-6">
            <x-input-label for="profile_photo" :value="__('Profile Photo')" class="block text-sm font-medium text-gray-700 mb-2" />
            <input id="profile_photo" class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-purple-500 focus:border-purple-500 transition duration-300 file:mr-4 file:py-2 file:px-4 file:rounded-md file:border-0 file:text-sm file:font-semibold file:bg-purple-50 file:text-purple-700 hover:file:bg-purple-100"
                   type="file" name="profile_photo" accept="image/*" />
            <x-input-error :messages="$errors->get('profile_photo')" class="mt-2 text-sm text-red-600" />
        </div>

        <!-- Password -->
        <div class="mb-6">
            <x-input-label for="password" :value="__('Password')" class="block text-sm font-medium text-gray-700 mb-2" />
            <x-text-input id="password" class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-purple-500 focus:border-purple-500 transition duration-300"
                          type="password" name="password" required autocomplete="new-password" />
            <x-input-error :messages="$errors->get('password')" class="mt-2 text-sm text-red-600" />
        </div>

        <!-- Confirm Password -->
        <div class="mb-6">
            <x-input-label for="password_confirmation" :value="__('Confirm Password')" class="block text-sm font-medium text-gray-700 mb-2" />
            <x-text-input id="password_confirmation" class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-purple-500 focus:border-purple-500 transition duration-300"
                          type="password" name="password_confirmation" required autocomplete="new-password" />
            <x-input-error :messages="$errors->get('password_confirmation')" class="mt-2 text-sm text-red-600" />
        </div>

        <!-- Already Registered Link -->
        <div class="flex items-center justify-between mb-6">
            <a class="text-sm text-purple-600 hover:text-purple-800 transition duration-300" href="{{ route('login') }}">
                {{ __('Already registered?') }}
            </a>
        </div>

        <!-- Submit Button -->
        <div class="flex justify-center">
            <x-primary-button class="w-full bg-purple-600 text-white px-6 py-3 rounded-lg hover:bg-purple-700 hover-scale transition duration-300">
                {{ __('Register') }}
            </x-primary-button>
        </div>
    </form>
</x-guest-layout>