<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Create New Trip') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 bg-white border-b border-gray-200">
                    <form method="POST" action="{{ route('trips.store') }}">
                        @csrf
                        
                        <!-- Trip Name -->
                        <div class="mb-4">
                            <x-input-label for="name" :value="__('Trip Name')" />
                            <x-text-input id="name" class="block mt-1 w-full" type="text" name="name" :value="old('name')" required autofocus />
                            <x-input-error :messages="$errors->get('name')" class="mt-2" />
                        </div>
                        
                        <!-- Dates -->
                        <div class="flex space-x-4 mb-4">
                            <div class="w-1/2">
                                <x-input-label for="start_date" :value="__('Start Date')" />
                                <x-text-input id="start_date" class="block mt-1 w-full" type="date" name="start_date" :value="old('start_date')" required />
                                <x-input-error :messages="$errors->get('start_date')" class="mt-2" />
                            </div>
                            <div class="w-1/2">
                                <x-input-label for="end_date" :value="__('End Date')" />
                                <x-text-input id="end_date" class="block mt-1 w-full" type="date" name="end_date" :value="old('end_date')" required />
                                <x-input-error :messages="$errors->get('end_date')" class="mt-2" />
                            </div>
                        </div>
                        
                        <!-- Destination -->
                        <div class="mb-4">
                            <x-input-label for="destination" :value="__('Destination')" />
                            <x-text-input id="destination" class="block mt-1 w-full" type="text" name="destination" :value="old('destination', $destination ?? '')" required />
                            <x-input-error :messages="$errors->get('destination')" class="mt-2" />
                        </div>
                        
                        <!-- Travelers -->
                        <div class="mb-4">
                            <x-input-label for="travelers" :value="__('Number of Travelers')" />
                            <x-text-input id="travelers" class="block mt-1 w-full" type="number" name="travelers" :value="old('travelers', 1)" min="1" required />
                            <x-input-error :messages="$errors->get('travelers')" class="mt-2" />
                        </div>
                        
                        <!-- Budget -->
                        <div class="mb-4">
                            <x-input-label for="budget" :value="__('Budget Estimation (USD)')" />
                            <x-text-input id="budget" class="block mt-1 w-full" type="number" name="budget" :value="old('budget')" step="0.01" />
                            <x-input-error :messages="$errors->get('budget')" class="mt-2" />
                        </div>
                        
                        <div class="flex items-center justify-end mt-4">
                            <x-primary-button class="ml-4">
                                {{ __('Create Trip') }}
                            </x-primary-button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
