<x-guest-layout>
<!-- Page Header -->
<div class="mb-8 text-center">
    <div class="inline-flex items-center justify-center w-20 h-20 bg-gradient-to-r from-[#f7b7a1] via-[#e9896d] to-[#d76f49] rounded-full mb-6 shadow-lg">
        <svg class="w-10 h-10 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 16l-4-4m0 0l4-4m-4 4h14m-5 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h7a3 3 0 013 3v1"></path>
        </svg>
    </div>
    <h1 class="text-3xl font-bold bg-gradient-to-r from-[#d76f49] via-[#e9896d] to-[#f7b7a1] bg-clip-text text-transparent mb-2">
        Welcome Back
    </h1>
    <p class="text-gray-600 text-lg">Sign in to continue shopping</p>
</div>

<x-auth-session-status class="mb-6" :status="session('status')" />

<!-- Social Login Options -->
<div class="space-y-4 mb-8">
    <button type="button" onclick="socialLogin('google')" class="w-full flex items-center justify-center gap-3 px-4 py-3 border-2 border-[#ffe7dd] rounded-xl bg-white hover:bg-[#fff9f5] hover:border-[#f7b7a1] transition-all duration-200 group">
        <svg class="w-5 h-5" viewBox="0 0 24 24">
            <path fill="#4285F4" d="M22.56 12.25c0-.78-.07-1.53-.2-2.25H12v4.26h5.92c-.26 1.37-1.04 2.53-2.21 3.31v2.77h3.57c2.08-1.92 3.28-4.74 3.28-8.09z"/>
            <path fill="#34A853" d="M12 23c2.97 0 5.46-.98 7.28-2.66l-3.57-2.77c-.98.66-2.23 1.06-3.71 1.06-2.86 0-5.29-1.93-6.16-4.53H2.18v2.84C3.99 20.53 7.7 23 12 23z"/>
            <path fill="#FBBC05" d="M5.84 14.09c-.22-.66-.35-1.36-.35-2.09s.13-1.43.35-2.09V7.07H2.18C1.43 8.55 1 10.22 1 12s.43 3.45 1.18 4.93l2.85-2.22.81-.62z"/>
            <path fill="#EA4335" d="M12 5.38c1.62 0 3.06.56 4.21 1.64l3.15-3.15C17.45 2.09 14.97 1 12 1 7.7 1 3.99 3.47 2.18 7.07l3.66 2.84c.87-2.6 3.3-4.53 6.16-4.53z"/>
        </svg>
        <span class="font-medium text-gray-700 group-hover:text-gray-900">Continue with Google</span>
    </button>

    <button type="button" onclick="socialLogin('facebook')" class="w-full flex items-center justify-center gap-3 px-4 py-3 border-2 border-[#ffe7dd] rounded-xl bg-white hover:bg-[#fff9f5] hover:border-[#f7b7a1] transition-all duration-200 group">
        <svg class="w-5 h-5 text-[#1877F2]" fill="currentColor" viewBox="0 0 24 24">
            <path d="M24 12.073c0-6.627-5.373-12-12-12s-12 5.373-12 12c0 5.99 4.388 10.954 10.125 11.854v-8.385H7.078v-3.47h3.047V9.43c0-3.007 1.792-4.669 4.533-4.669 1.312 0 2.686.235 2.686.235v2.953H15.83c-1.491 0-1.956.925-1.956 1.874v2.25h3.328l-.532 3.47h-2.796v8.385C19.612 23.027 24 18.062 24 12.073z"/>
        </svg>
        <span class="font-medium text-gray-700 group-hover:text-gray-900">Continue with Facebook</span>
    </button>
</div>

<!-- Divider -->
<div class="relative mb-8">
    <div class="absolute inset-0 flex items-center">
        <div class="w-full border-t border-[#ffe7dd]"></div>
    </div>
    <div class="relative flex justify-center text-sm">
        <span class="px-4 bg-white text-gray-500 font-medium">or continue with email</span>
    </div>
</div>

<form method="POST" action="{{ route('login') }}" class="space-y-6">
    @csrf

    <!-- Email Address -->
    <div class="space-y-2">
        <x-input-label for="email" :value="__('Email Address')" />
        <div class="relative group">
            <div class="absolute inset-y-0 left-0 pl-4 flex items-center pointer-events-none">
                <svg class="h-5 w-5 text-[#e9896d] group-focus-within:text-[#d76f49] transition-colors" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 12a4 4 0 10-8 0 4 4 0 008 0zm0 0v1.5a2.5 2.5 0 005 0V12a9 9 0 10-9 9m4.5-1.206a8.959 8.959 0 01-4.5 1.207"></path>
                </svg>
            </div>
            <x-text-input
                id="email"
                type="email"
                name="email"
                :value="old('email')"
                required
                autofocus
                autocomplete="username"
                placeholder="Enter your email address"
                class="pl-12 border-[#ffe7dd] focus:border-[#f7b7a1] focus:ring-[#f7b7a1] bg-[#fff9f5]"
            />
        </div>
        <x-input-error :messages="$errors->get('email')" class="mt-2 text-sm text-red-500" />
    </div>

    <!-- Password -->
    <div class="space-y-2">
        <x-input-label for="password" :value="__('Password')" />
        <div class="relative group">
            <div class="absolute inset-y-0 left-0 pl-4 flex items-center pointer-events-none">
                <svg class="h-5 w-5 text-[#e9896d] group-focus-within:text-[#d76f49] transition-colors" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"></path>
                </svg>
            </div>
            <x-text-input
                id="password"
                type="password"
                name="password"
                required
                autocomplete="current-password"
                placeholder="Enter your password"
                class="pl-12 pr-12 border-[#ffe7dd] focus:border-[#f7b7a1] focus:ring-[#f7b7a1] bg-[#fff9f5]"
            />
            <button type="button" class="absolute inset-y-0 right-0 pr-4 flex items-center" onclick="togglePassword()">
                <svg id="eye-icon" class="h-5 w-5 text-[#e9896d] hover:text-[#d76f49] transition-colors" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path>
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"></path>
                </svg>
            </button>
        </div>
        <x-input-error :messages="$errors->get('password')" class="mt-2 text-sm text-red-500" />
    </div>

    <!-- Remember Me & Forgot Password -->
    <div class="flex items-center justify-between py-2">
        <label for="remember_me" class="flex items-center gap-3 cursor-pointer group">
            <div class="relative">
                <input
                    id="remember_me"
                    type="checkbox"
                    name="remember"
                    class="sr-only peer"
                />
                <div class="w-5 h-5 border-2 border-[#ffe7dd] rounded-md peer-checked:bg-gradient-to-r peer-checked:from-[#f7b7a1] peer-checked:to-[#e9896d] peer-checked:border-[#f7b7a1] transition-all peer-checked:shadow-md"></div>
                <svg class="absolute top-0.5 left-0.5 w-4 h-4 text-white opacity-0 peer-checked:opacity-100 transition-opacity" fill="currentColor" viewBox="0 0 20 20">
                    <path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd"></path>
                </svg>
            </div>
            <span class="text-sm text-gray-700 font-medium group-hover:text-[#d76f49] transition">Keep me signed in</span>
        </label>

        @if (Route::has('password.request'))
            <a href="{{ route('password.request') }}" class="text-sm font-semibold text-[#d76f49] hover:text-[#e9896d] transition hover:underline">
                Forgot password?
            </a>
        @endif
    </div>

    <!-- Login Button -->
    <div class="pt-2">
        <x-primary-button class="w-full justify-center bg-gradient-to-r from-[#f7b7a1] via-[#e9896d] to-[#d76f49] hover:from-[#e9896d] hover:via-[#d76f49] hover:to-[#c75f40] border-0 shadow-lg hover:shadow-xl transform hover:-translate-y-0.5 transition-all duration-200">
            <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 16l-4-4m0 0l4-4m-4 4h14m-5 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h7a3 3 0 013 3v1"></path>
            </svg>
            Sign In to Jeat'aime
        </x-primary-button>
    </div>
</form>

<!-- Register Link -->
<div class="mt-8 text-center">
    <p class="text-gray-600">
        New to Jeat'aime?
        <a href="{{ route('register') }}" class="font-semibold bg-gradient-to-r from-[#d76f49] to-[#e9896d] bg-clip-text text-transparent hover:from-[#e9896d] hover:to-[#f7b7a1] transition">
            Create your account
        </a>
    </p>
</div>

<!-- Help Text -->
<div class="mt-6 rounded-xl bg-gradient-to-r from-[#fff9f5] to-[#ffe7dd] p-4 text-center border border-[#ffd6c8]">
    <p class="text-xs text-gray-700 font-medium">
        <strong class="text-[#d76f49]">Test Account:</strong> admin@example.com / password
    </p>
</div>

<script>
function togglePassword() {
    const passwordInput = document.getElementById('password');
    const eyeIcon = document.getElementById('eye-icon');

    if (passwordInput.type === 'password') {
        passwordInput.type = 'text';
        eyeIcon.innerHTML = '<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13.875 18.825A10.05 10.05 0 0112 19c-4.478 0-8.268-2.943-9.543-7a9.97 9.97 0 011.563-3.029m5.858.908a3 3 0 114.243 4.243M9.878 9.878l4.242 4.242M9.878 9.878L3 3m6.878 6.878L21 21"></path>';
    } else {
        passwordInput.type = 'password';
        eyeIcon.innerHTML = '<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"></path>';
    }
}

function socialLogin(provider) {
    // Show loading state
    const button = event.target.closest('button');
    const originalText = button.innerHTML;
    button.innerHTML = '<div class="flex items-center justify-center gap-3"><div class="w-5 h-5 border-2 border-[#f7b7a1] border-t-transparent rounded-full animate-spin"></div><span>Connecting...</span></div>';
    button.disabled = true;

    // Simulate API call delay
    setTimeout(() => {
        // Reset button
        button.innerHTML = originalText;
        button.disabled = false;

        // Show coming soon message with peach styling
        showNotification(`${provider.charAt(0).toUpperCase() + provider.slice(1)} login is coming soon! For now, please use email and password to sign in.`, 'info');
    }, 2000);
}

function showNotification(message, type = 'info') {
    // Create notification element
    const notification = document.createElement('div');
    notification.className = `fixed top-4 right-4 z-50 p-4 rounded-xl shadow-lg transform translate-x-full transition-transform duration-300 ${
        type === 'success' ? 'bg-green-50 border border-green-200 text-green-800' :
        type === 'error' ? 'bg-red-50 border border-red-200 text-red-800' :
        'bg-[#fff9f5] border border-[#f7b7a1] text-[#d76f49]'
    }`;

    notification.innerHTML = `
        <div class="flex items-center gap-3">
            <div class="flex-shrink-0">
                ${type === 'success' ? '✅' : type === 'error' ? '❌' : 'ℹ️'}
            </div>
            <p class="text-sm font-medium">${message}</p>
            <button onclick="this.parentElement.parentElement.remove()" class="ml-4 text-gray-400 hover:text-gray-600">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                </svg>
            </button>
        </div>
    `;

    document.body.appendChild(notification);

    // Animate in
    setTimeout(() => {
        notification.classList.remove('translate-x-full');
    }, 100);

    // Auto remove after 5 seconds
    setTimeout(() => {
        if (notification.parentElement) {
            notification.classList.add('translate-x-full');
            setTimeout(() => notification.remove(), 300);
        }
    }, 5000);
}
</script>
</x-guest-layout>
