<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Edit Trip:') }} {{ $trip->name }}
        </h2>
    </x-slot>

    <!-- Success Message -->
    @if (session('status'))
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 mt-4">
            <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded relative" role="alert">
                <span class="block sm:inline">{{ session('status') }}</span>
            </div>
        </div>
    @endif

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <!-- Trip Details Card -->
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg mb-6">
                <div class="p-6 bg-white border-b border-gray-200">
                    <h3 class="text-lg font-medium text-gray-900 mb-4">Trip Details</h3>
                    
                    <form method="POST" action="{{ route('trips.update', $trip) }}" id="trip-details-form">
                        @csrf
                        @method('PUT')
                        
                        <!-- Name -->
                        <div class="mb-4">
                            <x-input-label for="name" :value="__('Trip Name')" />
                            <x-text-input id="name" class="block mt-1 w-full" type="text" name="name" :value="old('name', $trip->name)" required autofocus />
                            <x-input-error :messages="$errors->get('name')" class="mt-2" />
                        </div>
                        
                        <!-- Dates -->
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mb-4">
                            <div>
                                <x-input-label for="start_date" :value="__('Start Date')" />
                                <x-text-input id="start_date" class="block mt-1 w-full" type="date" name="start_date" :value="old('start_date', $trip->start_date->format('Y-m-d'))" required />
                                <x-input-error :messages="$errors->get('start_date')" class="mt-2" />
                            </div>
                            
                            <div>
                                <x-input-label for="end_date" :value="__('End Date')" />
                                <x-text-input id="end_date" class="block mt-1 w-full" type="date" name="end_date" :value="old('end_date', $trip->end_date->format('Y-m-d'))" required />
                                <x-input-error :messages="$errors->get('end_date')" class="mt-2" />
                            </div>
                        </div>
                        
                        <!-- Destination -->
                        <div class="mb-4">
                            <x-input-label for="destination" :value="__('Destination')" />
                            <x-text-input id="destination" class="block mt-1 w-full" type="text" name="destination" :value="old('destination', $trip->destination)" required />
                            <x-input-error :messages="$errors->get('destination')" class="mt-2" />
                        </div>
                        
                        <!-- Travelers -->
                        <div class="mb-4">
                            <x-input-label for="travelers" :value="__('Number of Travelers')" />
                            <x-text-input id="travelers" class="block mt-1 w-full" type="number" name="travelers" :value="old('travelers', $trip->travelers)" required min="1" />
                            <x-input-error :messages="$errors->get('travelers')" class="mt-2" />
                        </div>
                        
                        <!-- Budget -->
                        <div class="mb-4">
                            <x-input-label for="budget" :value="__('Budget (USD)')" />
                            <x-text-input id="budget" class="block mt-1 w-full" type="number" name="budget" :value="old('budget', $trip->budget)" step="0.01" min="0" />
                            <x-input-error :messages="$errors->get('budget')" class="mt-2" />
                        </div>
                        
                        <!-- Public/Private -->
                        <div class="mb-4">
                            <label for="is_public" class="inline-flex items-center">
                                <input id="is_public" type="checkbox" class="rounded border-gray-300 text-indigo-600 shadow-sm focus:ring-indigo-500" name="is_public" value="1" {{ old('is_public', $trip->is_public) ? 'checked' : '' }}>
                                <span class="ml-2 text-sm text-gray-600">{{ __('Make this trip public') }}</span>
                            </label>
                        </div>
                        
                        <div class="flex items-center justify-end mt-4">
                            <x-primary-button class="ml-4">
                                {{ __('Update Details') }}
                            </x-primary-button>
                        </div>
                    </form>
                </div>
            </div>

            <!-- Save All Trip Details Card -->
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg mb-6">
                <div class="p-6 bg-white border-b border-gray-200">
                    <h3 class="text-lg font-medium text-gray-900 mb-4">Save All Trip Details</h3>
                    <p class="text-sm text-gray-600 mb-4">Click the button below to save all changes made to your trip.</p>
                    <button type="button" id="save-trip" class="px-6 py-3 bg-green-600 text-white rounded-md font-semibold hover:bg-green-700 focus:outline-none focus:ring-2 focus:ring-green-500 focus:ring-offset-2">
                        Save All Trip Details
                    </button>
                </div>
            </div>

            <!-- Interactive Map -->
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg mb-6">
                <div class="p-6 bg-white border-b border-gray-200">
                    <h3 class="text-lg font-medium text-gray-900 mb-4">Interactive Map</h3>
                    
                    <div id="trip-map" class="h-96 w-full rounded-lg"></div>
                    <p class="text-sm text-gray-500 mt-2">Click on the map to add locations to your trip.</p>
                </div>
            </div>
            
            <!-- Itinerary Builder -->
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg mb-6">
                <div class="p-6 bg-white border-b border-gray-200">
                    <h3 class="text-lg font-medium text-gray-900 mb-4">Itinerary Builder</h3>
                    
                    <div id="itinerary-builder">
                        <!-- Itinerary days will be added here dynamically -->
                    </div>
                    
                    <button type="button" id="add-day" class="mt-4 px-4 py-2 bg-blue-500 text-white rounded hover:bg-blue-600">
                        Add Day
                    </button>
                </div>
            </div>
            \
            
            <!-- Weather Forecast -->
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg mb-6">
                <div class="p-6 bg-white border-b border-gray-200">
                    <h3 class="text-lg font-medium text-gray-900 mb-4">Weather Forecast</h3>
                    <div id="weather-forecast" class="flex overflow-x-auto space-x-4 pb-4">
                        <!-- Weather data will be loaded here -->
                        <p class="text-gray-500">Loading weather data...</p>
                    </div>
                </div>
            </div>
            
            <!-- Packing Checklist -->
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg mb-6">
                <div class="p-6 bg-white border-b border-gray-200">
                    <h3 class="text-lg font-medium text-gray-900 mb-4">Packing Checklist</h3>
                    <div id="packing-checklist" class="space-y-4">
                        <div class="flex items-center space-x-2">
                            <input type="text" id="new-item" placeholder="Add new item..." class="rounded-md shadow-sm border-gray-300 focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50 block w-full">
                            <button type="button" id="add-item" class="inline-flex items-center px-4 py-2 bg-blue-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-blue-700">
                                Add
                            </button>
                        </div>
                        
                        <div class="border rounded-md p-4">
                            <h4 class="font-medium mb-2">Your Packing List</h4>
                            <ul id="packing-items" class="space-y-2">
                                <!-- Items will be added here dynamically -->
                                @if(isset($trip->packing_list) && count($trip->packing_list) > 0)
                                    @foreach($trip->packing_list as $item)
                                        <li class="flex items-center space-x-2">
                                            <input type="checkbox" class="rounded border-gray-300 text-indigo-600 shadow-sm focus:ring-indigo-500" {{ $item['packed'] ? 'checked' : '' }}>
                                            <span class="flex-grow {{ $item['packed'] ? 'line-through text-gray-500' : '' }}">{{ $item['name'] }}</span>
                                            <button type="button" class="text-red-500 hover:text-red-700 delete-item">
                                                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" viewBox="0 0 20 20" fill="currentColor">
                                                    <path fill-rule="evenodd" d="M9 2a1 1 0 00-.894.553L7.382 4H4a1 1 0 000 2v10a2 2 0 002 2h8a2 2 0 002-2V6a1 1 0 100-2h-3.382l-.724-1.447A1 1 0 0011 2H9zM7 8a1 1 0 012 0v6a1 1 0 11-2 0V8zm5-1a1 1 0 00-1 1v6a1 1 0 102 0V8a1 1 0 00-1-1z" clip-rule="evenodd" />
                                                </svg>
                                            </button>
                                        </li>
                                    @endforeach
                                @endif
                            </ul>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Expense Tracker -->
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg mb-6">
                <div class="p-6 bg-white border-b border-gray-200">
                    <h3 class="text-lg font-medium text-gray-900 mb-4">Expense Tracker</h3>
                    <div id="expense-tracker" class="space-y-4">
                        <div class="grid grid-cols-1 md:grid-cols-4 gap-4">
                            <div>
                                <label for="expense-description" class="block text-sm font-medium text-gray-700">Description</label>
                                <input type="text" id="expense-description" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50">
                            </div>
                            <div>
                                <label for="expense-amount" class="block text-sm font-medium text-gray-700">Amount</label>
                                <input type="number" id="expense-amount" min="0" step="0.01" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50">
                            </div>
                            <div>
                                <label for="expense-category" class="block text-sm font-medium text-gray-700">Category</label>
                                <select id="expense-category" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50">
                                    <option value="accommodation">Accommodation</option>
                                    <option value="transportation">Transportation</option>
                                    <option value="food">Food & Drinks</option>
                                    <option value="activities">Activities</option>
                                    <option value="shopping">Shopping</option>
                                    <option value="other">Other</option>
                                </select>
                            </div>
                            <div class="flex items-end">
                                <button type="button" id="add-expense" class="inline-flex items-center px-4 py-2 bg-blue-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-blue-700 w-full justify-center">
                                    Add Expense
                                </button>
                            </div>
                        </div>
                        
                        <div class="mt-6">
                            <h4 class="font-medium mb-2">Expenses</h4>
                            <div class="overflow-x-auto">
                                <table class="min-w-full divide-y divide-gray-200">
                                    <thead class="bg-gray-50">
                                        <tr>
                                            <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Description</th>
                                            <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Category</th>
                                            <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Amount</th>
                                            <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Actions</th>
                                        </tr>
                                    </thead>
                                    <tbody id="expenses-list" class="bg-white divide-y divide-gray-200">
                                        <!-- Expenses will be added here dynamically -->
                                        @if(isset($trip->expenses) && count($trip->expenses) > 0)
                                            @foreach($trip->expenses as $expense)
                                                <tr>
                                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">{{ $expense['description'] }}</td>
                                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">{{ ucfirst($expense['category']) }}</td>
                                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">${{ number_format($expense['amount'], 2) }}</td>
                                                    <td class="px-6 py-4 whitespace-nowrap text-sm font-medium">
                                                        <button type="button" class="text-red-500 hover:text-red-700 delete-expense">
                                                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" viewBox="0 0 20 20" fill="currentColor">
                                                                <path fill-rule="evenodd" d="M9 2a1 1 0 00-.894.553L7.382 4H4a1 1 0 000 2v10a2 2 0 002 2h8a2 2 0 002-2V6a1 1 0 100-2h-3.382l-.724-1.447A1 1 0 0011 2H9zM7 8a1 1 0 012 0v6a1 1 0 11-2 0V8zm5-1a1 1 0 00-1 1v6a1 1 0 102 0V8a1 1 0 00-1-1z" clip-rule="evenodd" />
                                                            </svg>
                                                        </button>
                                                    </td>
                                                </tr>
                                            @endforeach
                                        @endif
                                    </tbody>
                                    <tfoot>
                                        <tr>
                                            <td class="px-6 py-4 whitespace-nowrap text-sm font-bold text-gray-900">Total</td>
                                            <td></td>
                                            <td class="px-6 py-4 whitespace-nowrap text-sm font-bold text-gray-900" id="total-expenses">
                                                ${{ isset($trip->expenses) ? number_format(array_sum(array_column($trip->expenses, 'amount')), 2) : '0.00' }}
                                            </td>
                                            <td></td>
                                        </tr>
                                    </tfoot>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Accommodation -->
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg mb-6">
                <div class="p-6 bg-white border-b border-gray-200">
                    <h3 class="text-lg font-medium text-gray-900 mb-4">Accommodation</h3>
                    <div id="accommodation" class="space-y-4">
                        <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                            <div>
                                <label for="accommodation-name" class="block text-sm font-medium text-gray-700">Name/Hotel</label>
                                <input type="text" id="accommodation-name" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50">
                            </div>
                            <div>
                                <label for="accommodation-address" class="block text-sm font-medium text-gray-700">Address</label>
                                <input type="text" id="accommodation-address" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50">
                            </div>
                            <div class="flex items-end">
                                <button type="button" id="add-accommodation" class="inline-flex items-center px-4 py-2 bg-blue-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-blue-700 w-full justify-center">
                                    Add Accommodation
                                </button>
                            </div>
                        </div>
                        
                        <div class="mt-6">
                            <h4 class="font-medium mb-2">Your Accommodations</h4>
                            <ul id="accommodations-list" class="space-y-2">
                                <!-- Accommodations will be added here dynamically -->
                                @if(isset($trip->accommodations) && count($trip->accommodations) > 0)
                                    @foreach($trip->accommodations as $accommodation)
                                        <li class="border rounded-md p-3">
                                            <div class="flex justify-between">
                                                <div>
                                                    <h5 class="font-medium">{{ $accommodation['name'] }}</h5>
                                                    <p class="text-sm text-gray-600">{{ $accommodation['address'] }}</p>
                                                </div>
                                                <button type="button" class="text-red-500 hover:text-red-700 delete-accommodation">
                                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" viewBox="0 0 20 20" fill="currentColor">
                                                        <path fill-rule="evenodd" d="M9 2a1 1 0 00-.894.553L7.382 4H4a1 1 0 000 2v10a2 2 0 002 2h8a2 2 0 002-2V6a1 1 0 100-2h-3.382l-.724-1.447A1 1 0 0011 2H9zM7 8a1 1 0 012 0v6a1 1 0 11-2 0V8zm5-1a1 1 0 00-1 1v6a1 1 0 102 0V8a1 1 0 00-1-1z" clip-rule="evenodd" />
                                                    </svg>
                                                </button>
                                            </div>
                                        </li>
                                    @endforeach
                                @endif
                            </ul>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Transportation -->
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg mb-6">
                <div class="p-6 bg-white border-b border-gray-200">
                    <h3 class="text-lg font-medium text-gray-900 mb-4">Transportation</h3>
                    <div id="transportation" class="space-y-4">
                        <div class="grid grid-cols-1 md:grid-cols-4 gap-4">
                            <div>
                                <label for="transport-type" class="block text-sm font-medium text-gray-700">Type</label>
                                <select id="transport-type" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50">
                                    <option value="flight">Flight</option>
                                    <option value="train">Train</option>
                                    <option value="bus">Bus</option>
                                    <option value="car">Car Rental</option>
                                    <option value="taxi">Taxi/Rideshare</option>
                                    <option value="other">Other</option>
                                </select>
                            </div>
                            <div>
                                <label for="transport-details" class="block text-sm font-medium text-gray-700">Details</label>
                                <input type="text" id="transport-details" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50">
                            </div>
                            <div>
                                <label for="transport-date" class="block text-sm font-medium text-gray-700">Date</label>
                                <input type="date" id="transport-date" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50">
                            </div>
                            <div class="flex items-end">
                                <button type="button" id="add-transport" class="inline-flex items-center px-4 py-2 bg-blue-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-blue-700 w-full justify-center">
                                    Add Transport
                                </button>
                            </div>
                        </div>
                        
                        <div class="mt-6">
                            <h4 class="font-medium mb-2">Your Transportation</h4>
                            <ul id="transportation-list" class="space-y-2">
                                <!-- Transportation will be added here dynamically -->
                                @if(isset($trip->transportation) && count($trip->transportation) > 0)
                                    @foreach($trip->transportation as $transport)
                                        <li class="border rounded-md p-3">
                                            <div class="flex justify-between">
                                                <div>
                                                    <h5 class="font-medium">{{ ucfirst($transport['type']) }}</h5>
                                                    <p class="text-sm text-gray-600">{{ $transport['details'] }}</p>
                                                    <p class="text-xs text-gray-500">{{ \Carbon\Carbon::parse($transport['date'])->format('M d, Y') }}</p>
                                                </div>
                                                <button type="button" class="text-red-500 hover:text-red-700 delete-transport">
                                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" viewBox="0 0 20 20" fill="currentColor">
                                                        <path fill-rule="evenodd" d="M9 2a1 1 0 00-.894.553L7.382 4H4a1 1 0 000 2v10a2 2 0 002 2h8a2 2 0 002-2V6a1 1 0 100-2h-3.382l-.724-1.447A1 1 0 0011 2H9zM7 8a1 1 0 012 0v6a1 1 0 11-2 0V8zm5-1a1 1 0 00-1 1v6a1 1 0 102 0V8a1 1 0 00-1-1z" clip-rule="evenodd" />
                                                    </svg>
                                                </button>
                                            </div>
                                        </li>
                                    @endforeach
                                @endif
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
            
            <!-- Travel Notes -->
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg mb-6">
                <div class="p-6 bg-white border-b border-gray-200">
                    <h3 class="text-lg font-medium text-gray-900 mb-4">Travel Notes</h3>
                    <textarea id="notes" name="notes" rows="6" class="w-full rounded-md shadow-sm border-gray-300 focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50">{{ $trip->notes }}</textarea>
                    <button type="button" id="save-notes" class="mt-2 px-4 py-2 bg-green-500 text-white rounded hover:bg-green-600">
                        Save Notes
                    </button>
                </div>
            </div>
            
            <!-- Share & Export -->
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-6">
                
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                    <div class="p-6 bg-white border-b border-gray-200">
                        <h3 class="text-lg font-medium text-gray-900 mb-4">Export Trip</h3>
                        <button type="button" id="export-pdf" class="px-4 py-2 bg-red-500 text-white rounded hover:bg-red-600">
                            Export as PDF
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </div>

    @push('scripts')
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            // Initialize Leaflet map
            const map = L.map('trip-map').setView([0, 0], 2);
            
            // Add OpenStreetMap tiles
            L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
                attribution: '&copy; <a href="https://www.openstreetmap.org/copyright">OpenStreetMap</a> contributors'
            }).addTo(map);
            
            // Initialize map with destination
            geocodeDestination('{{ $trip->destination }}');
            
            // Function to geocode destination and center map
            function geocodeDestination(destination) {
                fetch(`https://nominatim.openstreetmap.org/search?format=json&q=${encodeURIComponent(destination)}`)
                    .then(response => response.json())
                    .then(data => {
                        if (data && data.length > 0) {
                            const lat = parseFloat(data[0].lat);
                            const lon = parseFloat(data[0].lon);
                            map.setView([lat, lon], 10);
                            L.marker([lat, lon]).addTo(map)
                                .bindPopup(`<b>${destination}</b>`).openPopup();
                        }
                    });
            }
            
            // Load weather forecast
            loadWeatherForecast('{{ $trip->destination }}');
            
            function loadWeatherForecast(destination) {
                fetch(`/api/weather/${encodeURIComponent(destination)}`)
                    .then(response => response.json())
                    .then(data => {
                        if (data && data.list) {
                            const weatherContainer = document.getElementById('weather-forecast');
                            weatherContainer.innerHTML = '';
                            
                            data.list.forEach(day => {
                                const date = new Date(day.dt * 1000);
                                const temp = Math.round(day.main.temp);
                                const icon = day.weather[0].icon;
                                const description = day.weather[0].description;
                                
                                const dayEl = document.createElement('div');
                                dayEl.className = 'flex-shrink-0 w-32 bg-gray-100 rounded-lg p-3 text-center';
                                dayEl.innerHTML = `
                                    <p class="font-semibold">${date.toLocaleDateString('en-US', { weekday: 'short' })}</p>
                                    <p class="text-xs text-gray-500">${date.toLocaleDateString()}</p>
                                    <img src="https://openweathermap.org/img/wn/${icon}@2x.png" alt="${description}" class="w-16 h-16 mx-auto">
                                    <p class="font-bold">${temp}°C</p>
                                    <p class="text-xs">${description}</p>
                                `;
                                
                                weatherContainer.appendChild(dayEl);
                            });
                        }
                    })
                    .catch(error => {
                        console.error('Error fetching weather:', error);
                        document.getElementById('weather-forecast').innerHTML = '<p class="text-red-500">Failed to load weather data</p>';
                    });
            }
            
            // Initialize itinerary builder
            initItineraryBuilder();
            
            function initItineraryBuilder() {
                const itinerary = @json($trip->itinerary ?? []);
                const container = document.getElementById('itinerary-builder');
                
                // Clear container
                container.innerHTML = '';
                
                // Add existing days or create a default day
                if (itinerary.length > 0) {
                    itinerary.forEach((day, index) => {
                        addItineraryDay(index + 1, day);
                    });
                } else {
                    addItineraryDay(1);
                }
                
                // Add day button
                document.getElementById('add-day').addEventListener('click', function() {
                    const dayCount = container.querySelectorAll('.itinerary-day').length;
                    addItineraryDay(dayCount + 1);
                });
            }
            
            function addItineraryDay(dayNumber, dayData = { activities: [] }) {
                const container = document.getElementById('itinerary-builder');
                
                const dayEl = document.createElement('div');
                dayEl.className = 'itinerary-day bg-gray-50 rounded-lg p-4 mb-4';
                dayEl.dataset.day = dayNumber;
                
                dayEl.innerHTML = `
                    <div class="flex justify-between items-center mb-3">
                        <h4 class="font-semibold">Day ${dayNumber}</h4>
                        <button type="button" class="add-activity px-2 py-1 bg-blue-500 text-white text-sm rounded hover:bg-blue-600">
                            Add Activity
                        </button>
                    </div>
                    <div class="activities-container space-y-2">
                        ${dayData.activities.map(activity => `
                            <div class="activity bg-white p-3 rounded shadow-sm">
                                <div class="flex justify-between">
                                    <span class="font-medium">${activity.time} - ${activity.title}</span>
                                    <button type="button" class="remove-activity text-red-500 hover:text-red-700">×</button>
                                </div>
                                <p class="text-sm text-gray-600">${activity.description}</p>
                            </div>
                        `).join('')}
                    </div>
                `;
                
                container.appendChild(dayEl);
                
                // Add event listeners
                dayEl.querySelector('.add-activity').addEventListener('click', function() {
                    addActivity(dayEl);
                });
                
                dayEl.querySelectorAll('.remove-activity').forEach(button => {
                    button.addEventListener('click', function() {
                        button.closest('.activity').remove();
                        saveItinerary();
                    });
                });
            }
            
            function addActivity(dayEl) {
                const activitiesContainer = dayEl.querySelector('.activities-container');
                
                const activityEl = document.createElement('div');
                activityEl.className = 'activity bg-white p-3 rounded shadow-sm';
                activityEl.innerHTML = `
                    <div class="flex justify-between">
                        <input type="text" class="activity-time w-20 border-gray-300 rounded-md shadow-sm" placeholder="Time">
                        <input type="text" class="activity-title flex-1 mx-2 border-gray-300 rounded-md shadow-sm" placeholder="Activity title">
                        <button type="button" class="remove-activity text-red-500 hover:text-red-700">×</button>
                    </div>
                    <textarea class="activity-description w-full mt-2 text-sm border-gray-300 rounded-md shadow-sm" placeholder="Description" rows="2"></textarea>
                `;
                
                activitiesContainer.appendChild(activityEl);
                
                // Add event listeners
                activityEl.querySelector('.remove-activity').addEventListener('click', function() {
                    activityEl.remove();
                    saveItinerary();
                });
                
                const inputs = activityEl.querySelectorAll('input, textarea');
                inputs.forEach(input => {
                    input.addEventListener('blur', saveItinerary);
                });
                
                // Focus the first input
                activityEl.querySelector('.activity-time').focus();
            }
            
            function saveItinerary() {
                const itinerary = [];
                
                document.querySelectorAll('.itinerary-day').forEach(dayEl => {
                    const dayNumber = parseInt(dayEl.dataset.day);
                    const activities = [];
                    
                    dayEl.querySelectorAll('.activity').forEach(activityEl => {
                        const timeEl = activityEl.querySelector('.activity-time');
                        const titleEl = activityEl.querySelector('.activity-title');
                        const descriptionEl = activityEl.querySelector('.activity-description');
                        
                        if (timeEl && titleEl) {
                            activities.push({
                                time: timeEl.value || timeEl.textContent,
                                title: titleEl.value || titleEl.textContent,
                                description: descriptionEl ? (descriptionEl.value || descriptionEl.textContent) : ''
                            });
                        }
                    });
                    
                    itinerary.push({
                        day: dayNumber,
                        activities: activities
                    });
                });
                
                // Save to server
                fetch(`/api/trips/{{ $trip->id }}/itinerary`, {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
                    },
                    body: JSON.stringify({ itinerary })
                });
            }
            
            // Save notes
            document.getElementById('save-notes').addEventListener('click', function() {
                const notes = document.getElementById('notes').value;
                
                fetch(`/trips/{{ $trip->id }}`, {
                    method: 'PUT',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
                    },
                    body: JSON.stringify({ notes })
                })
                .then(response => response.json())
                .then(data => {
                    if (data.success) {
                        alert('Notes saved successfully!');
                    }
                });
            });
            
            // Export as PDF
            document.getElementById('export-pdf').addEventListener('click', function() {
                window.location.href = `/trips/{{ $trip->id }}/export`;
            });
        });
    </script>
    @endpush
</x-app-layout>

<!-- JavaScript for all sections -->
<script>
    document.addEventListener('DOMContentLoaded', function() {
        // CSRF token for all AJAX requests
        const csrfToken = document.querySelector('meta[name="csrf-token"]').getAttribute('content');
        const tripId = {{ $trip->id }};
        
        // ===== PACKING LIST FUNCTIONALITY =====
        const newItemInput = document.getElementById('new-item');
        const addItemButton = document.getElementById('add-item');
        const packingItemsList = document.getElementById('packing-items');
        
        // Add new packing item
        addItemButton.addEventListener('click', function() {
            const itemName = newItemInput.value.trim();
            if (itemName) {
                addPackingItem(itemName, false);
                newItemInput.value = '';
                savePackingList();
            }
        });
        
        // Allow pressing Enter to add item
        newItemInput.addEventListener('keypress', function(e) {
            if (e.key === 'Enter') {
                addItemButton.click();
                e.preventDefault();
            }
        });
        
        // Function to add packing item to the list
        function addPackingItem(name, packed) {
            const li = document.createElement('li');
            li.className = 'flex items-center space-x-2';
            li.innerHTML = `
                <input type="checkbox" class="rounded border-gray-300 text-indigo-600 shadow-sm focus:ring-indigo-500" ${packed ? 'checked' : ''}>
                <span class="flex-grow ${packed ? 'line-through text-gray-500' : ''}">${name}</span>
                <button type="button" class="text-red-500 hover:text-red-700 delete-item">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" viewBox="0 0 20 20" fill="currentColor">
                        <path fill-rule="evenodd" d="M9 2a1 1 0 00-.894.553L7.382 4H4a1 1 0 000 2v10a2 2 0 002 2h8a2 2 0 002-2V6a1 1 0 100-2h-3.382l-.724-1.447A1 1 0 0011 2H9zM7 8a1 1 0 012 0v6a1 1 0 11-2 0V8zm5-1a1 1 0 00-1 1v6a1 1 0 102 0V8a1 1 0 00-1-1z" clip-rule="evenodd" />
                    </svg>
                </button>
            `;
            packingItemsList.appendChild(li);
            
            // Add event listeners to the new item
            const checkbox = li.querySelector('input[type="checkbox"]');
            checkbox.addEventListener('change', function() {
                const itemText = li.querySelector('span');
                if (this.checked) {
                    itemText.classList.add('line-through', 'text-gray-500');
                } else {
                    itemText.classList.remove('line-through', 'text-gray-500');
                }
                savePackingList();
            });
            
            const deleteButton = li.querySelector('.delete-item');
            deleteButton.addEventListener('click', function() {
                li.remove();
                savePackingList();
            });
        }
        
        // Function to save packing list to the server
        function savePackingList() {
            const items = [];
            packingItemsList.querySelectorAll('li').forEach(li => {
                const name = li.querySelector('span').textContent;
                const packed = li.querySelector('input[type="checkbox"]').checked;
                items.push({ name, packed });
            });
            
            fetch(`/api/trips/${tripId}/packing-list`, {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': csrfToken
                },
                body: JSON.stringify({ packing_list: items })
            })
            .then(response => response.json())
            .then(data => {
                console.log('Packing list saved:', data);
            })
            .catch(error => {
                console.error('Error saving packing list:', error);
            });
        }
        
        // ===== EXPENSE TRACKER FUNCTIONALITY =====
        const expenseDescription = document.getElementById('expense-description');
        const expenseAmount = document.getElementById('expense-amount');
        const expenseCategory = document.getElementById('expense-category');
        const addExpenseButton = document.getElementById('add-expense');
        const expensesList = document.getElementById('expenses-list');
        const totalExpenses = document.getElementById('total-expenses');
        
        // Add new expense
        addExpenseButton.addEventListener('click', function() {
            const description = expenseDescription.value.trim();
            const amount = parseFloat(expenseAmount.value);
            const category = expenseCategory.value;
            
            if (description && !isNaN(amount) && amount > 0) {
                addExpense(description, amount, category);
                expenseDescription.value = '';
                expenseAmount.value = '';
                saveExpenses();
            }
        });
        
        // Function to add expense to the list
        function addExpense(description, amount, category) {
            const tr = document.createElement('tr');
            tr.innerHTML = `
                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">${description}</td>
                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">${category.charAt(0).toUpperCase() + category.slice(1)}</td>
                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">$${amount.toFixed(2)}</td>
                <td class="px-6 py-4 whitespace-nowrap text-sm font-medium">
                    <button type="button" class="text-red-500 hover:text-red-700 delete-expense">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" viewBox="0 0 20 20" fill="currentColor">
                            <path fill-rule="evenodd" d="M9 2a1 1 0 00-.894.553L7.382 4H4a1 1 0 000 2v10a2 2 0 002 2h8a2 2 0 002-2V6a1 1 0 100-2h-3.382l-.724-1.447A1 1 0 0011 2H9zM7 8a1 1 0 012 0v6a1 1 0 11-2 0V8zm5-1a1 1 0 00-1 1v6a1 1 0 102 0V8a1 1 0 00-1-1z" clip-rule="evenodd" />
                        </svg>
                    </button>
                </td>
            `;
            expensesList.appendChild(tr);
            
            // Add event listener to delete button
            const deleteButton = tr.querySelector('.delete-expense');
            deleteButton.addEventListener('click', function() {
                tr.remove();
                updateTotalExpenses();
                saveExpenses();
            });
            
            updateTotalExpenses();
        }
        
        // Function to update total expenses
        function updateTotalExpenses() {
            let total = 0;
            expensesList.querySelectorAll('tr').forEach(tr => {
                const amountText = tr.querySelector('td:nth-child(3)').textContent;
                const amount = parseFloat(amountText.replace('$', ''));
                if (!isNaN(amount)) {
                    total += amount;
                }
            });
            totalExpenses.textContent = `$${total.toFixed(2)}`;
        }
        
        // Function to save expenses to the server
        function saveExpenses() {
            const expenses = [];
            expensesList.querySelectorAll('tr').forEach(tr => {
                const description = tr.querySelector('td:nth-child(1)').textContent;
                const category = tr.querySelector('td:nth-child(2)').textContent.toLowerCase();
                const amountText = tr.querySelector('td:nth-child(3)').textContent;
                const amount = parseFloat(amountText.replace('$', ''));
                expenses.push({ description, category, amount });
            });
            
            fetch(`/api/trips/${tripId}/expenses`, {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': csrfToken
                },
                body: JSON.stringify({ expenses })
            })
            .then(response => response.json())
            .then(data => {
                console.log('Expenses saved:', data);
            })
            .catch(error => {
                console.error('Error saving expenses:', error);
            });
        }
        
        // ===== ACCOMMODATION FUNCTIONALITY =====
        const accommodationName = document.getElementById('accommodation-name');
        const accommodationAddress = document.getElementById('accommodation-address');
        const addAccommodationButton = document.getElementById('add-accommodation');
        const accommodationsList = document.getElementById('accommodations-list');
        
        // Add new accommodation
        addAccommodationButton.addEventListener('click', function() {
            const name = accommodationName.value.trim();
            const address = accommodationAddress.value.trim();
            
            if (name && address) {
                addAccommodation(name, address);
                accommodationName.value = '';
                accommodationAddress.value = '';
                saveAccommodations();
            }
        });
        
        // Function to add accommodation to the list
        function addAccommodation(name, address) {
            const li = document.createElement('li');
            li.className = 'border rounded-md p-3';
            li.innerHTML = `
                <div class="flex justify-between">
                    <div>
                        <h5 class="font-medium">${name}</h5>
                        <p class="text-sm text-gray-600">${address}</p>
                    </div>
                    <button type="button" class="text-red-500 hover:text-red-700 delete-accommodation">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" viewBox="0 0 20 20" fill="currentColor">
                            <path fill-rule="evenodd" d="M9 2a1 1 0 00-.894.553L7.382 4H4a1 1 0 000 2v10a2 2 0 002 2h8a2 2 0 002-2V6a1 1 0 100-2h-3.382l-.724-1.447A1 1 0 0011 2H9zM7 8a1 1 0 012 0v6a1 1 0 11-2 0V8zm5-1a1 1 0 00-1 1v6a1 1 0 102 0V8a1 1 0 00-1-1z" clip-rule="evenodd" />
                        </svg>
                    </button>
                </div>
            `;
            accommodationsList.appendChild(li);
            
            // Add event listener to delete button
            const deleteButton = li.querySelector('.delete-accommodation');
            deleteButton.addEventListener('click', function() {
                li.remove();
                saveAccommodations();
            });
        }
        
        // Function to save accommodations to the server
        function saveAccommodations() {
            const accommodations = [];
            accommodationsList.querySelectorAll('li').forEach(li => {
                const name = li.querySelector('h5').textContent;
                const address = li.querySelector('p').textContent;
                accommodations.push({ name, address });
            });
            
            fetch(`/trips/${tripId}`, {
                method: 'PUT',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': csrfToken
                },
                body: JSON.stringify({ accommodations })
            })
            .then(response => response.json())
            .then(data => {
                console.log('Accommodations saved:', data);
            })
            .catch(error => {
                console.error('Error saving accommodations:', error);
            });
        }
        
        // ===== TRANSPORTATION FUNCTIONALITY =====
        const transportType = document.getElementById('transport-type');
        const transportDetails = document.getElementById('transport-details');
        const transportDate = document.getElementById('transport-date');
        const addTransportButton = document.getElementById('add-transport');
        const transportationList = document.getElementById('transportation-list');
        
        // Add new transportation
        addTransportButton.addEventListener('click', function() {
            const type = transportType.value;
            const details = transportDetails.value.trim();
            const date = transportDate.value;
            
            if (type && details && date) {
                addTransportation(type, details, date);
                transportDetails.value = '';
                transportDate.value = '';
                saveTransportation();
            }
        });
        
        // Function to add transportation to the list
        function addTransportation(type, details, date) {
            const li = document.createElement('li');
            li.className = 'border rounded-md p-3';
            
            // Format the date
            const formattedDate = new Date(date).toLocaleDateString('en-US', {
                month: 'short',
                day: 'numeric',
                year: 'numeric'
            });
            
            li.innerHTML = `
                <div class="flex justify-between">
                    <div>
                        <h5 class="font-medium">${type.charAt(0).toUpperCase() + type.slice(1)}</h5>
                        <p class="text-sm text-gray-600">${details}</p>
                        <p class="text-xs text-gray-500">${formattedDate}</p>
                    </div>
                    <button type="button" class="text-red-500 hover:text-red-700 delete-transport">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" viewBox="0 0 20 20" fill="currentColor">
                            <path fill-rule="evenodd" d="M9 2a1 1 0 00-.894.553L7.382 4H4a1 1 0 000 2v10a2 2 0 002 2h8a2 2 0 002-2V6a1 1 0 100-2h-3.382l-.724-1.447A1 1 0 0011 2H9zM7 8a1 1 0 012 0v6a1 1 0 11-2 0V8zm5-1a1 1 0 00-1 1v6a1 1 0 102 0V8a1 1 0 00-1-1z" clip-rule="evenodd" />
                        </svg>
                    </button>
                </div>
            `;
            transportationList.appendChild(li);
            
            // Add event listener to delete button
            const deleteButton = li.querySelector('.delete-transport');
            deleteButton.addEventListener('click', function() {
                li.remove();
                saveTransportation();
            });
        }
        
        // Function to save transportation to the server
        function saveTransportation() {
            const transportation = [];
            transportationList.querySelectorAll('li').forEach(li => {
                const type = li.querySelector('h5').textContent.toLowerCase();
                const details = li.querySelector('p:nth-child(2)').textContent;
                const dateText = li.querySelector('p:nth-child(3)').textContent;
                
                // Convert the formatted date back to YYYY-MM-DD
                const dateParts = new Date(dateText);
                const date = dateParts.toISOString().split('T')[0];
                
                transportation.push({ type, details, date });
            });
            
            fetch(`/trips/${tripId}`, {
                method: 'PUT',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': csrfToken
                },
                body: JSON.stringify({ transportation })
            })
            .then(response => response.json())
            .then(data => {
                console.log('Transportation saved:', data);
            })
            .catch(error => {
                console.error('Error saving transportation:', error);
            });
        }
    });
</script>

<script>
document.addEventListener('DOMContentLoaded', function() {
    // Add event listener for the save trip button
    document.getElementById('save-trip').addEventListener('click', function() {
        saveAllTripDetails();
    });
    
    // Function to save all trip details
    function saveAllTripDetails() {
        // Show loading state on button
        const saveButton = document.getElementById('save-trip');
        const originalText = saveButton.textContent;
        saveButton.textContent = 'Saving...';
        saveButton.disabled = true;
        
        // Get the CSRF token
        const csrfToken = document.querySelector('meta[name="csrf-token"]').getAttribute('content');
        const tripId = {{ $trip->id }}; // Make sure this is properly set
        
        // Collect all trip data
        const tripData = {
            name: document.querySelector('input[name="name"]').value,
            start_date: document.querySelector('input[name="start_date"]').value,
            end_date: document.querySelector('input[name="end_date"]').value,
            destination: document.querySelector('input[name="destination"]').value,
            travelers: document.querySelector('input[name="travelers"]').value,
            budget: document.querySelector('input[name="budget"]').value,
            is_public: document.querySelector('input[name="is_public"]')?.checked || false,
            notes: document.getElementById('notes')?.value || ''
            // Add other data collection as needed
        };
        
        console.log('Sending trip data:', tripData);
        
        // Send data to server
        fetch(`/trips/${tripId}/save-all`, {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': csrfToken
            },
            body: JSON.stringify(tripData)
        })
        .then(response => {
            if (!response.ok) {
                throw new Error(`HTTP error! Status: ${response.status}`);
            }
            return response.json();
        })
        .then(data => {
            console.log('Response received:', data);
            if (data.success) {
                // Redirect to thank you page
                window.location.href = data.redirect_url;
            } else {
                // Reset button state
                saveButton.textContent = originalText;
                saveButton.disabled = false;
                alert('Error saving trip details: ' + (data.message || 'Unknown error'));
            }
        })
        .catch(error => {
            console.error('Error saving trip details:', error);
            // Reset button state
            saveButton.textContent = originalText;
            saveButton.disabled = false;
            alert('Error saving trip details. Please try again. ' + error.message);
        });
    }
    
    // Helper functions to collect data from different sections
    function collectItineraryData() {
        const itinerary = [];
        document.querySelectorAll('.itinerary-day').forEach(dayEl => {
            const dayNumber = parseInt(dayEl.dataset.day);
            const activities = [];
            
            dayEl.querySelectorAll('.activity').forEach(activityEl => {
                const timeEl = activityEl.querySelector('.activity-time');
                const titleEl = activityEl.querySelector('.activity-title');
                const descriptionEl = activityEl.querySelector('.activity-description');
                
                if (timeEl && titleEl) {
                    activities.push({
                        time: timeEl.value || timeEl.textContent,
                        title: titleEl.value || titleEl.textContent,
                        description: descriptionEl ? (descriptionEl.value || descriptionEl.textContent) : ''
                    });
                }
            });
            
            itinerary.push({
                day: dayNumber,
                activities: activities
            });
        });
        return itinerary;
    }
    
    function collectPackingListData() {
        const items = [];
        document.querySelectorAll('#packing-items li').forEach(li => {
            const name = li.querySelector('span').textContent;
            const packed = li.querySelector('input[type="checkbox"]').checked;
            items.push({ name, packed });
        });
        return items;
    }
    
    function collectExpensesData() {
        const expenses = [];
        document.querySelectorAll('#expenses-list tr:not(:first-child)').forEach(tr => {
            const description = tr.querySelector('td:nth-child(1)').textContent;
            const category = tr.querySelector('td:nth-child(2)').textContent.toLowerCase();
            const amountText = tr.querySelector('td:nth-child(3)').textContent;
            const amount = parseFloat(amountText.replace('$', ''));
            expenses.push({ description, category, amount });
        });
        return expenses;
    }
    
    function collectAccommodationsData() {
        const accommodations = [];
        document.querySelectorAll('#accommodations-list li').forEach(li => {
            const name = li.querySelector('h5').textContent;
            const address = li.querySelector('p').textContent;
            accommodations.push({ name, address });
        });
        return accommodations;
    }
    
    function collectTransportationData() {
        const transportation = [];
        document.querySelectorAll('#transportation-list li').forEach(li => {
            const type = li.querySelector('h5').textContent.toLowerCase();
            const details = li.querySelector('p:nth-child(2)').textContent;
            const dateText = li.querySelector('p:nth-child(3)').textContent;
            
            // Convert the formatted date back to YYYY-MM-DD
            const dateParts = new Date(dateText);
            const date = dateParts.toISOString().split('T')[0];
            
            transportation.push({ type, details, date });
        });
        return transportation;
    }
});
</script>






