<x-guest-layout>
    <!-- Session Status -->
    <x-auth-session-status class="mb-4" :status="session('status')" />

    <form method="POST" action="{{ route('login') }}" id="loginForm">
        @csrf

        <!-- Email Address -->
        <div>
            <x-input-label for="email" :value="__('Email')" />
            <x-text-input id="email" class="block mt-1 w-full" type="email" name="email" :value="old('email')" required autofocus autocomplete="username" />
            <x-input-error :messages="$errors->get('email')" class="mt-2" />
        </div>

        <!-- New User Message -->
        <div id="newUserMessage" class="mt-4 p-4 bg-blue-50 border border-blue-200 rounded-md hidden">
            <p class="text-blue-800 text-sm mb-3">You are a new user. You need to register first.</p>
            <button type="button" id="goToRegister" class="inline-flex items-center px-4 py-2 bg-blue-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-blue-700 focus:bg-blue-700 active:bg-blue-900 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-offset-2 transition ease-in-out duration-150">
                Go to Register
            </button>
        </div>

        <!-- Password -->
        <div class="mt-4">
            <x-input-label for="password" :value="__('Password')" />

            <x-text-input id="password" class="block mt-1 w-full"
                            type="password"
                            name="password"
                            required autocomplete="current-password" />

            <x-input-error :messages="$errors->get('password')" class="mt-2" />
        </div>

        <!-- Remember Me -->
        <div class="block mt-4">
            <label for="remember_me" class="inline-flex items-center">
                <input id="remember_me" type="checkbox" class="rounded border-gray-300 text-indigo-600 shadow-sm focus:ring-indigo-500" name="remember">
                <span class="ms-2 text-sm text-gray-600">{{ __('Remember me') }}</span>
            </label>
        </div>

        <div class="flex items-center justify-end mt-4" id="loginActions">
            @if (Route::has('password.request'))
                <a class="underline text-sm text-gray-600 hover:text-gray-900 rounded-md focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500" href="{{ route('password.request') }}">
                    {{ __('Forgot your password?') }}
                </a>
            @endif

            <x-primary-button class="ms-3" id="loginButton">
                {{ __('Log in') }}
            </x-primary-button>
        </div>
    </form>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const emailInput = document.getElementById('email');
            const newUserMessage = document.getElementById('newUserMessage');
            const goToRegisterBtn = document.getElementById('goToRegister');
            const loginActions = document.getElementById('loginActions');
            const loginButton = document.getElementById('loginButton');
            const passwordField = document.querySelector('input[name="password"]').closest('div');
            const rememberField = document.querySelector('input[name="remember"]').closest('div');
            let checkTimeout;

            // Function to check if user exists
            function checkUserExists(email) {
                if (!email || !email.includes('@')) {
                    return;
                }

                fetch('{{ route("check.user") }}', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]')?.getAttribute('content') ||
                                       document.querySelector('input[name="_token"]').value
                    },
                    body: JSON.stringify({ email: email })
                })
                .then(response => response.json())
                .then(data => {
                    if (!data.exists) {
                        // Show new user message and hide login fields
                        newUserMessage.classList.remove('hidden');
                        passwordField.classList.add('hidden');
                        rememberField.classList.add('hidden');
                        loginActions.classList.add('hidden');
                    } else {
                        // Hide new user message and show login fields
                        newUserMessage.classList.add('hidden');
                        passwordField.classList.remove('hidden');
                        rememberField.classList.remove('hidden');
                        loginActions.classList.remove('hidden');
                    }
                })
                .catch(error => {
                    console.error('Error checking user:', error);
                    // On error, show login fields (default behavior)
                    newUserMessage.classList.add('hidden');
                    passwordField.classList.remove('hidden');
                    rememberField.classList.remove('hidden');
                    loginActions.classList.remove('hidden');
                });
            }

            // Check user when email input changes
            emailInput.addEventListener('input', function() {
                clearTimeout(checkTimeout);
                checkTimeout = setTimeout(() => {
                    checkUserExists(this.value.trim());
                }, 500); // Wait 500ms after user stops typing
            });

            // Check user when email input loses focus
            emailInput.addEventListener('blur', function() {
                clearTimeout(checkTimeout);
                checkUserExists(this.value.trim());
            });

            // Redirect to register page
            goToRegisterBtn.addEventListener('click', function() {
                const email = emailInput.value.trim();
                const registerUrl = '{{ route("register") }}' + (email ? '?email=' + encodeURIComponent(email) : '');
                window.location.href = registerUrl;
            });
        });
    </script>
</x-guest-layout>
