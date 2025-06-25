<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Contact Us') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    <h3 class="text-2xl font-bold mb-6">Get in Touch</h3>
                    
                    <p class="mb-8">We'd love to hear from you! Fill out the form below and we'll get back to you as soon as possible.</p>
                    
                    @if(session('success'))
                        <div class="mb-6 bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded">
                            {{ session('success') }}
                        </div>
                    @endif

                    <form method="POST" action="{{ route('contact.submit') }}" class="space-y-6">
                        @csrf

                        <!-- Name -->
                        <div>
                            <x-input-label for="name" :value="__('Your Name')" />
                            <x-text-input id="name" class="block mt-1 w-full" type="text" name="name" 
                                :value="old('name') ?? (Auth::check() ? Auth::user()->name : '')" required autofocus />
                            <x-input-error :messages="$errors->get('name')" class="mt-2" />
                        </div>

                        <!-- Email -->
                        <div>
                            <x-input-label for="email" :value="__('Your Email')" />
                            <x-text-input id="email" class="block mt-1 w-full" type="email" name="email" 
                                :value="old('email') ?? (Auth::check() ? Auth::user()->email : '')" required />
                            <x-input-error :messages="$errors->get('email')" class="mt-2" />
                        </div>

                        <!-- Message -->
                        <div>
                            <x-input-label for="message" :value="__('Your Message')" />
                            <textarea id="message" name="message" rows="5" class="block mt-1 w-full border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm" required>{{ old('message') }}</textarea>
                            <x-input-error :messages="$errors->get('message')" class="mt-2" />
                        </div>

                        <div class="flex items-center justify-end">
                            <x-primary-button class="ml-3">
                                {{ __('Send Message') }}
                            </x-primary-button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>






