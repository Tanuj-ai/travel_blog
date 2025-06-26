<x-app-layout>
    <div class="flex h-screen bg-gradient-to-br from-gray-50 to-gray-100">
        <!-- Sidebar -->
        <div class="hidden md:flex md:flex-shrink-0">
            <div class="flex flex-col w-64 bg-white border-r border-gray-200 shadow-sm">
                <!-- Sidebar Header -->
                <div class="px-6 pt-8 pb-4">
                    <div class="flex items-center">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-8 w-8 text-sky-500" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3.055 11H5a2 2 0 012 2v1a2 2 0 002 2h2a2 2 0 002-2v-1a2 2 0 012-2h1.945M5.055 15H15a2 2 0 002-2v-1a2 2 0 012-2h1.945" />
                        </svg>
                        <span class="ml-2 text-xl font-bold text-gray-800">The Traveller</span>
                    </div>
                    <p class="mt-1 text-sm text-gray-600">Welcome, {{ Auth::user()?->name ?? 'Guest' }}</p>
                </div>
                
                <!-- Navigation -->
                <nav class="flex-1 px-4 pb-4 space-y-1 overflow-y-auto">
                    <a href="{{ route('dashboard') }}" class="flex items-center px-4 py-3 text-sm font-medium rounded-lg bg-sky-50 text-sky-700 transition-all duration-200 hover:bg-sky-100">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-3" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 012-2h1.945" />
                        </svg>
                        Dashboard
                    </a>
                    
                    <a href="{{ route('admin.posts') }}" class="flex items-center px-4 py-3 text-sm font-medium rounded-lg text-gray-700 transition-all duration-200 hover:bg-gray-50">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-3" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z" />
                        </svg>
                        My Posts
                    </a>
                    
                    <a href="{{ route('trips.index') }}" class="flex items-center px-4 py-3 text-sm font-medium rounded-lg text-gray-700 hover:bg-gray-50">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-3" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2h11a2 2 0 002-2v-6a2 2 0 01-2-2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10" />
                        </svg>
                        My Trips
                    </a>
                    
                    <a href="#" class="flex items-center px-4 py-3 text-sm font-medium rounded-lg text-gray-700 hover:bg-gray-50">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-3" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z" />
                        </svg>
                        Photo Gallery
                    </a>
                    
                    <div class="pt-4 mt-4 border-t border-gray-200">
                        <h3 class="px-4 text-xs font-semibold text-gray-500 uppercase tracking-wider">Settings</h3>
                        
                        <a href="{{ route('profile.edit') }}" class="flex items-center px-4 py-3 mt-2 text-sm font-medium rounded-lg text-gray-700 hover:bg-gray-50">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-3" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" />
                            </svg>
                            Profile
                        </a>
                    </div>
                </nav>
            </div>
        </div>
        
        <!-- Main Content -->
        <div class="flex-1 overflow-auto">
            <main class="p-6">
                <h1 class="text-2xl font-semibold text-gray-900">Dashboard</h1>
                
                <!-- Display trips if available -->
                @if(isset($trips) && $trips->count() > 0)
                    <div class="mt-6">
                        <h2 class="text-lg font-medium text-gray-800 mb-4">Your Recent Trips</h2>
                        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                            @foreach($trips as $trip)
                                <div class="bg-white rounded-lg shadow-sm overflow-hidden">
                                    <div class="p-5">
                                        <h3 class="font-medium text-gray-900">{{ $trip->destination }}</h3>
                                        <p class="text-sm text-gray-500 mt-1">{{ $trip->start_date->format('M d, Y') }} - {{ $trip->end_date->format('M d, Y') }}</p>
                                        <div class="mt-4">
                                            <a href="#" class="text-sm text-sky-600 hover:text-sky-800">View Details →</a>
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    </div>
                @else
                    <div class="mt-6 bg-white rounded-lg shadow-sm p-6">
                        <p class="text-gray-700">You haven't added any trips yet.</p>
                        <a href="#" class="mt-4 inline-block px-4 py-2 bg-sky-500 text-white rounded-md hover:bg-sky-600">Plan a Trip</a>
                    </div>
                @endif
                
                <!-- Recent Posts Section -->
                <div class="mt-8">
                    <div class="flex justify-between items-center mb-4">
                        <h2 class="text-lg font-medium text-gray-800">Recent Posts</h2>
                        <a href="{{ url('/admin/posts/create') }}" 
                           onclick="console.log('Add New Post button clicked'); return true;" 
                           class="px-4 py-2 bg-indigo-600 text-white rounded-md hover:bg-indigo-700 text-sm font-medium">
                            Add New Post
                        </a>
                    </div>
                    
                    <div class="bg-white rounded-lg shadow-sm overflow-hidden">
                        @if(isset($posts) && count($posts) > 0)
                            <ul class="divide-y divide-gray-200">
                                @foreach($posts as $post)
                                    <li class="p-4 hover:bg-gray-50 transition-colors duration-150">
                                        <a href="{{ route('posts.show', $post->slug) }}" class="block">
                                            <div class="flex justify-between">
                                                <h3 class="font-medium text-gray-900">{{ $post->title }}</h3>
                                                <span class="text-sm text-gray-500">
                                                    {{ $post->published_at ? $post->published_at->format('M d, Y') : $post->created_at->format('M d, Y') }}
                                                </span>
                                            </div>
                                            <p class="mt-1 text-sm text-gray-600 line-clamp-2">{{ $post->excerpt }}</p>
                                            @if($post->hashtags)
                                                <div class="mt-2">
                                                    @foreach(explode(',', $post->hashtags) as $tag)
                                                        <span class="inline-block bg-gray-100 rounded-full px-3 py-1 text-xs font-semibold text-gray-600 mr-2">
                                                            #{{ trim($tag) }}
                                                        </span>
                                                    @endforeach
                                                </div>
                                            @endif
                                        </a>
                                    </li>
                                @endforeach
                            </ul>
                            <div class="bg-gray-50 px-4 py-3 text-right">
                                <a href="{{ route('admin.posts') }}" class="text-sm text-indigo-600 hover:text-indigo-800">View all posts →</a>
                            </div>
                        @else
                            <div class="p-6 text-center">
                                <p class="text-gray-500">You haven't created any posts yet.</p>
                                <a href="{{ url('/admin/posts/create') }}" class="mt-2 inline-block text-indigo-600 hover:text-indigo-800">Create your first post →</a>
                            </div>
                        @endif
                    </div>
                </div>
                
                
                
                <!-- To-Do List Section -->
                <div class="mt-8">
                    <h2 class="text-lg font-medium text-gray-800 mb-4">Travel To-Do List</h2>
                    
                    <div class="bg-white rounded-lg shadow-sm overflow-hidden">
                        <div class="p-4">
                            <div class="flex space-x-2 mb-4">
                                <input type="text" id="new-todo" placeholder="Add a new task..." 
                                       class="flex-1 rounded-md border-gray-300 shadow-sm focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50">
                                <button id="add-todo" class="px-4 py-2 bg-green-600 text-white rounded-md hover:bg-green-700">
                                    Add
                                </button>
                            </div>
                            
                            <ul id="todo-list" class="space-y-2">
                                <!-- To-do items will be added here dynamically -->
                            </ul>
                        </div>
                    </div>
                </div>
                
                <!-- Weather Widget -->
                <div class="mt-8">
                    <h2 class="text-lg font-medium text-gray-800 mb-4">Weather at Popular Destinations</h2>
                    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                        <div id="bali-weather" class="bg-amber-50 p-4 rounded-lg">
                            <h3 class="font-semibold text-amber-800 mb-2">Bali, Indonesia</h3>
                            <div class="animate-pulse flex space-x-4">
                                <div class="rounded-full bg-slate-200 h-10 w-10"></div>
                                <div class="flex-1 space-y-6 py-1">
                                    <div class="h-2 bg-slate-200 rounded"></div>
                                    <div class="space-y-3">
                                        <div class="grid grid-cols-3 gap-4">
                                            <div class="h-2 bg-slate-200 rounded col-span-2"></div>
                                            <div class="h-2 bg-slate-200 rounded col-span-1"></div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        
                        <div id="santorini-weather" class="bg-blue-50 p-4 rounded-lg">
                            <h3 class="font-semibold text-blue-800 mb-2">Santorini, Greece</h3>
                            <div class="animate-pulse flex space-x-4">
                                <div class="rounded-full bg-slate-200 h-10 w-10"></div>
                                <div class="flex-1 space-y-6 py-1">
                                    <div class="h-2 bg-slate-200 rounded"></div>
                                    <div class="space-y-3">
                                        <div class="grid grid-cols-3 gap-4">
                                            <div class="h-2 bg-slate-200 rounded col-span-2"></div>
                                            <div class="h-2 bg-slate-200 rounded col-span-1"></div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        
                        <div id="kyoto-weather" class="bg-green-50 p-4 rounded-lg">
                            <h3 class="font-semibold text-green-800 mb-2">Kyoto, Japan</h3>
                            <div class="animate-pulse flex space-x-4">
                                <div class="rounded-full bg-slate-200 h-10 w-10"></div>
                                <div class="flex-1 space-y-6 py-1">
                                    <div class="h-2 bg-slate-200 rounded"></div>
                                    <div class="space-y-3">
                                        <div class="grid grid-cols-3 gap-4">
                                            <div class="h-2 bg-slate-200 rounded col-span-2"></div>
                                            <div class="h-2 bg-slate-200 rounded col-span-1"></div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </main>
        </div>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            // OpenWeatherMap API key
            const apiKey = 'c3350498e2eed1f3fbb8c30f9c704a30';
            
            // Function to fetch weather data
            function fetchWeather(city, elementId) {
                const url = `https://api.openweathermap.org/data/2.5/weather?q=${city}&units=metric&appid=${apiKey}`;
                
                fetch(url)
                    .then(response => {
                        if (!response.ok) {
                            throw new Error('Network response was not ok');
                        }
                        return response.json();
                    })
                    .then(data => {
                        if (data.cod === 200) {
                            const weatherElement = document.getElementById(elementId);
                            if (weatherElement) {
                                const temp = Math.round(data.main.temp);
                                const description = data.weather[0].description;
                                const icon = data.weather[0].icon;
                                const humidity = data.main.humidity;
                                const windSpeed = data.wind.speed;
                                
                                weatherElement.innerHTML = `
                                    <h3 class="font-semibold text-gray-800 mb-2">${city.split(',')[0]}</h3>
                                    <div class="flex items-center mb-2">
                                        <img src="https://openweathermap.org/img/wn/${icon}@2x.png" alt="${description}" class="w-16 h-16">
                                        <div class="ml-2">
                                            <div class="text-2xl font-bold">${temp}°C</div>
                                            <div class="capitalize">${description}</div>
                                        </div>
                                    </div>
                                    <div class="grid grid-cols-2 gap-2 text-sm">
                                        <div>
                                            <span class="font-semibold">Humidity:</span> ${humidity}%
                                        </div>
                                        <div>
                                            <span class="font-semibold">Wind:</span> ${windSpeed} m/s
                                        </div>
                                    </div>
                                `;
                            }
                        } else {
                            console.error('Weather data not available');
                            document.getElementById(elementId).innerHTML = '<p>Weather data not available</p>';
                        }
                    })
                    .catch(error => {
                        console.error('Error fetching weather:', error);
                        document.getElementById(elementId).innerHTML = '<p>Failed to load weather data</p>';
                    });
            }
            
            // Fetch weather for popular destinations
            fetchWeather('Denpasar,ID', 'bali-weather');
            fetchWeather('Santorini,GR', 'santorini-weather');
            fetchWeather('Kyoto,JP', 'kyoto-weather');
            
            // To-Do List Functionality
            const todoInput = document.getElementById('new-todo');
            const addTodoButton = document.getElementById('add-todo');
            const todoList = document.getElementById('todo-list');
            
            // Load todos from localStorage
            function loadTodos() {
                const todos = JSON.parse(localStorage.getItem('travel-todos') || '[]');
                todoList.innerHTML = '';
                
                todos.forEach((todo, index) => {
                    const li = document.createElement('li');
                    li.className = 'flex items-center p-2 border border-gray-200 rounded-md';
                    li.innerHTML = `
                        <input type="checkbox" class="todo-checkbox mr-3 h-5 w-5 text-blue-600 rounded" 
                               ${todo.completed ? 'checked' : ''} data-index="${index}">
                        <span class="flex-1 ${todo.completed ? 'line-through text-gray-400' : ''}">${todo.text}</span>
                        <button class="delete-todo text-red-500 hover:text-red-700" data-index="${index}">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" viewBox="0 0 20 20" fill="currentColor">
                                <path fill-rule="evenodd" d="M9 2a1 1 0 00-.894.553L7.382 4H4a1 1 0 000 2v10a2 2 0 002 2h8a2 2 0 002-2V6a1 1 0 100-2h-3.382l-.724-1.447A1 1 0 0011 2H9zM7 8a1 1 0 012 0v6a1 1 0 11-2 0V8zm5-1a1 1 0 00-1 1v6a1 1 0 102 0V8a1 1 0 00-1-1z" clip-rule="evenodd" />
                            </svg>
                        </button>
                    `;
                    todoList.appendChild(li);
                });
                
                // Add event listeners to checkboxes and delete buttons
                document.querySelectorAll('.todo-checkbox').forEach(checkbox => {
                    checkbox.addEventListener('change', toggleTodoComplete);
                });
                
                document.querySelectorAll('.delete-todo').forEach(button => {
                    button.addEventListener('click', deleteTodo);
                });
            }
            
            // Add new todo
            function addTodo() {
                const todoText = todoInput.value.trim();
                if (todoText) {
                    const todos = JSON.parse(localStorage.getItem('travel-todos') || '[]');
                    todos.push({ text: todoText, completed: false });
                    localStorage.setItem('travel-todos', JSON.stringify(todos));
                    todoInput.value = '';
                    loadTodos();
                }
            }
            
            // Toggle todo complete status
            function toggleTodoComplete() {
                const index = this.dataset.index;
                const todos = JSON.parse(localStorage.getItem('travel-todos') || '[]');
                todos[index].completed = this.checked;
                localStorage.setItem('travel-todos', JSON.stringify(todos));
                loadTodos();
            }
            
            // Delete todo
            function deleteTodo() {
                const index = this.dataset.index;
                const todos = JSON.parse(localStorage.getItem('travel-todos') || '[]');
                todos.splice(index, 1);
                localStorage.setItem('travel-todos', JSON.stringify(todos));
                loadTodos();
            }
            
            // Add event listeners
            addTodoButton.addEventListener('click', addTodo);
            todoInput.addEventListener('keypress', function(e) {
                if (e.key === 'Enter') {
                    addTodo();
                }
            });
            
            // Initialize to-do list
            loadTodos();
        });
    </script>
</x-app-layout>

