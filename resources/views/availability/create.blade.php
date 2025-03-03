@extends('layout')

@section('content')
<div class="container mx-auto px-6 py-8">
    <!-- Form Title -->
    <h2 class="text-3xl font-bold text-gray-900 mb-6">
        {{ isset($availability) ? 'Edit' : 'Create' }} Availability
    </h2>

    <!-- Availability Form -->
    <form method="POST" action="{{ isset($availability) ? route('availability.update', $availability) : route('availability.store') }}" class="max-w-2xl mx-auto bg-white rounded-lg shadow-lg p-8">
        @csrf
        @if(isset($availability))
            @method('PUT')
        @endif

        <!-- Start Time -->
        <div class="mb-6">
            <label for="start_time" class="block text-sm font-medium text-gray-700 mb-2">
                Start Time
            </label>
            <input type="datetime-local" id="start_time" name="start_time" required
                   class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-purple-500 focus:border-purple-500 transition duration-300"
                   value="{{ isset($availability) ? $availability->start_time->format('Y-m-d\TH:i') : old('start_time') }}">
            @error('start_time')
                <p class="text-sm text-red-600 mt-2">{{ $message }}</p>
            @enderror
        </div>

        <!-- End Time -->
        <div class="mb-6">
            <label for="end_time" class="block text-sm font-medium text-gray-700 mb-2">
                End Time
            </label>
            <input type="datetime-local" id="end_time" name="end_time" required
                   class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-purple-500 focus:border-purple-500 transition duration-300"
                   value="{{ isset($availability) ? $availability->end_time->format('Y-m-d\TH:i') : old('end_time') }}">
            @error('end_time')
                <p class="text-sm text-red-600 mt-2">{{ $message }}</p>
            @enderror
        </div>

        <!-- Location -->
        <div class="mb-6">
            <label for="location" class="block text-sm font-medium text-gray-700 mb-2">
                Location
            </label>
            <input type="text" id="location" name="location" required
                   class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-purple-500 focus:border-purple-500 transition duration-300"
                   value="{{ isset($availability) ? $availability->location : old('location') }}">
            @error('location')
                <p class="text-sm text-red-600 mt-2">{{ $message }}</p>
            @enderror
        </div>

        <!-- Submit Button -->
        <div class="flex justify-end">
            <button type="submit"
                    class="bg-purple-600 text-white px-6 py-3 rounded-lg hover:bg-purple-700 hover-scale transition duration-300">
                {{ isset($availability) ? 'Update' : 'Create' }}
            </button>
        </div>
    </form>
</div>
@endsection