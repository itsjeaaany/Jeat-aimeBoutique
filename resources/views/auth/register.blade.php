<x-guest-layout>
<div class="min-h-screen bg-[#0f172a] py-12">
    <div class="mx-auto max-w-2xl px-4">
        <div class="rounded-[2rem] bg-white p-8 shadow-2xl shadow-[#00000040]">
                <form method="POST" action="{{ route('register') }}" class="space-y-6">
                    @csrf

                    <div class="space-y-2">
                        <x-input-label for="name" :value="__('Full Name')" />
                        <div class="relative group">
                            <div class="absolute inset-y-0 left-0 pl-4 flex items-center pointer-events-none">
                                <svg class="h-5 w-5 text-[#d76f49] group-focus-within:text-[#f7b7a1] transition-colors" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path>
                                </svg>
                            </div>
                            <x-text-input
                                id="name"
                                type="text"
                                name="name"
                                :value="old('name')"
                                required
                                autofocus
                                autocomplete="name"
                                placeholder="Enter your full name"
                                class="pl-12 border-[#e5e7eb] focus:border-[#f7b7a1] focus:ring-[#f7b7a1] bg-[#f8fafc]"
                            />
                        </div>
                        <x-input-error :messages="$errors->get('name')" class="mt-2 text-sm text-red-500" />
                    </div>

                    <div class="space-y-2">
                        <x-input-label for="email" :value="__('Email Address')" />
                        <div class="relative group">
                            <div class="absolute inset-y-0 left-0 pl-4 flex items-center pointer-events-none">
                                <svg class="h-5 w-5 text-[#d76f49] group-focus-within:text-[#f7b7a1] transition-colors" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 12a4 4 0 10-8 0 4 4 0 008 0zm0 0v1.5a2.5 2.5 0 005 0V12a9 9 0 10-9 9m4.5-1.206a8.959 8.959 0 01-4.5 1.207"></path>
                                </svg>
                            </div>
                            <x-text-input
                                id="email"
                                type="email"
                                name="email"
                                :value="old('email')"
                                required
                                autocomplete="username"
                                placeholder="Enter your email address"
                                class="pl-12 border-[#e5e7eb] focus:border-[#f7b7a1] focus:ring-[#f7b7a1] bg-[#f8fafc]"
                            />
                        </div>
                        <x-input-error :messages="$errors->get('email')" class="mt-2 text-sm text-red-500" />
                    </div>

                    <div class="space-y-3">
                        <x-input-label :value="__('What would you like to do?')" />
                        <div class="grid gap-3">
                            <label for="role-buyer" class="relative flex items-center gap-4 cursor-pointer rounded-2xl border border-[#e5e7eb] bg-[#f8fafc] p-4 transition hover:border-[#f7b7a1] hover:bg-[#fff4eb]">
                                <input
                                    id="role-buyer"
                                    type="radio"
                                    name="role"
                                    value="buyer"
                                    {{ old('role', 'buyer') === 'buyer' ? 'checked' : '' }}
                                    class="absolute inset-0 w-full h-full opacity-0 cursor-pointer peer"
                                />
                                <div class="pointer-events-none absolute inset-0 rounded-2xl border-2 border-transparent peer-checked:border-[#f7b7a1] peer-checked:bg-[#fff4eb]"></div>
                                <div class="relative z-10 flex items-center gap-4">
                                    <div class="relative">
                                        <div class="w-5 h-5 rounded-full border-2 border-[#d97706] peer-checked:bg-gradient-to-r peer-checked:from-[#f7b7a1] peer-checked:to-[#e9896d] peer-checked:border-[#f7b7a1]"></div>
                                        <div class="absolute top-0.5 left-0.5 w-4 h-4 rounded-full bg-white opacity-0 peer-checked:opacity-100"></div>
                                    </div>
                                    <div class="flex-1">
                                        <div class="flex items-center gap-2">
                                            <svg class="w-5 h-5 text-[#d76f49]" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z"></path>
                                            </svg>
                                            <span class="font-semibold text-gray-900">Shop & Buy</span>
                                        </div>
                                        <p class="text-sm text-gray-600 mt-1">Browse and purchase items from sellers</p>
                                    </div>
                                </div>
                            </label>

                            <label for="role-seller" class="relative flex items-center gap-4 cursor-pointer rounded-2xl border border-[#e5e7eb] bg-[#f8fafc] p-4 transition hover:border-[#f7b7a1] hover:bg-[#fff4eb]">
                                <input
                                    id="role-seller"
                                    type="radio"
                                    name="role"
                                    value="seller"
                                    {{ old('role') === 'seller' ? 'checked' : '' }}
                                    class="absolute inset-0 w-full h-full opacity-0 cursor-pointer peer"
                                />
                                <div class="pointer-events-none absolute inset-0 rounded-2xl border-2 border-transparent peer-checked:border-[#f7b7a1] peer-checked:bg-[#fff4eb]"></div>
                                <div class="relative z-10 flex items-center gap-4">
                                    <div class="relative">
                                        <div class="w-5 h-5 rounded-full border-2 border-[#d97706] peer-checked:bg-gradient-to-r peer-checked:from-[#f7b7a1] peer-checked:to-[#e9896d] peer-checked:border-[#f7b7a1]"></div>
                                        <div class="absolute top-0.5 left-0.5 w-4 h-4 rounded-full bg-white opacity-0 peer-checked:opacity-100"></div>
                                    </div>
                                    <div class="flex-1">
                                        <div class="flex items-center gap-2">
                                            <svg class="w-5 h-5 text-[#d76f49]" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.746 0 3.332.477 4.5 1.253v13C19.832 18.477 18.246 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"></path>
                                            </svg>
                                            <span class="font-semibold text-gray-900">Sell Items</span>
                                        </div>
                                        <p class="text-sm text-gray-600 mt-1">Create a shop and sell your products</p>
                                    </div>
                                </div>
                            </label>

                            <label for="role-buyer-seller" class="relative flex items-center gap-4 cursor-pointer rounded-2xl border border-[#e5e7eb] bg-[#f8fafc] p-4 transition hover:border-[#f7b7a1] hover:bg-[#fff4eb]">
                                <input
                                    id="role-buyer-seller"
                                    type="radio"
                                    name="role"
                                    value="buyer_seller"
                                    {{ old('role') === 'buyer_seller' ? 'checked' : '' }}
                                    class="absolute inset-0 w-full h-full opacity-0 cursor-pointer peer"
                                />
                                <div class="pointer-events-none absolute inset-0 rounded-2xl border-2 border-transparent peer-checked:border-[#f7b7a1] peer-checked:bg-[#fff4eb]"></div>
                                <div class="relative z-10 flex items-center gap-4">
                                    <div class="relative">
                                        <div class="w-5 h-5 rounded-full border-2 border-[#d97706] peer-checked:bg-gradient-to-r peer-checked:from-[#f7b7a1] peer-checked:to-[#e9896d] peer-checked:border-[#f7b7a1]"></div>
                                        <div class="absolute top-0.5 left-0.5 w-4 h-4 rounded-full bg-white opacity-0 peer-checked:opacity-100"></div>
                                    </div>
                                    <div class="flex-1">
                                        <div class="flex items-center gap-2">
                                            <svg class="w-5 h-5 text-[#d76f49]" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 7h18M3 12h18M3 17h18"></path>
                                            </svg>
                                            <span class="font-semibold text-gray-900">Buy & Sell</span>
                                        </div>
                                        <p class="text-sm text-gray-600 mt-1">Browse items and sell your own products</p>
                                    </div>
                                </div>
                            </label>
                        </div>
                        <x-input-error :messages="$errors->get('role')" class="mt-2 text-sm text-red-500" />
                    </div>

                    <div class="space-y-2">
                        <x-input-label for="password" :value="__('Password')" />
                        <div class="relative group">
                            <div class="absolute inset-y-0 left-0 pl-4 flex items-center pointer-events-none">
                                <svg class="h-5 w-5 text-[#d76f49] group-focus-within:text-[#f7b7a1] transition-colors" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"></path>
                                </svg>
                            </div>
                            <x-text-input
                                id="password"
                                type="password"
                                name="password"
                                required
                                autocomplete="new-password"
                                placeholder="Create a strong password"
                                class="pl-12 pr-12 border-[#e5e7eb] focus:border-[#f7b7a1] focus:ring-[#f7b7a1] bg-[#f8fafc]"
                            />
                            <button type="button" class="absolute inset-y-0 right-0 pr-4 flex items-center" onclick="togglePassword()">
                                <svg id="eye-icon" class="h-5 w-5 text-[#d76f49] hover:text-[#f7b7a1] transition-colors" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path>
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"></path>
                                </svg>
                            </button>
                        </div>
                        <x-input-error :messages="$errors->get('password')" class="mt-2 text-sm text-red-500" />
                        <div class="mt-2 text-xs text-gray-500 flex items-center gap-1">
                            <svg class="w-4 h-4 text-[#d76f49]" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                            </svg>
                            Use at least 8 characters with letters, numbers, and symbols
                        </div>
                    </div>

                    <div class="space-y-2">
                        <x-input-label for="password_confirmation" :value="__('Confirm Password')" />
                        <div class="relative group">
                            <div class="absolute inset-y-0 left-0 pl-4 flex items-center pointer-events-none">
                                <svg class="h-5 w-5 text-[#d76f49] group-focus-within:text-[#f7b7a1] transition-colors" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                </svg>
                            </div>
                            <x-text-input
                                id="password_confirmation"
                                type="password"
                                name="password_confirmation"
                                required
                                autocomplete="new-password"
                                placeholder="Re-enter your password"
                                class="pl-12 border-[#e5e7eb] focus:border-[#f7b7a1] focus:ring-[#f7b7a1] bg-[#f8fafc]"
                            />
                        </div>
                        <x-input-error :messages="$errors->get('password_confirmation')" class="mt-2 text-sm text-red-500" />
                    </div>

                    <label class="flex items-start gap-3 py-2 cursor-pointer">
                        <div class="relative mt-0.5">
                            <input
                                id="terms"
                                name="terms"
                                type="checkbox"
                                required
                                class="absolute inset-0 w-full h-full opacity-0 cursor-pointer peer"
                            />
                            <div class="w-5 h-5 rounded-md border-2 border-[#e5e7eb] peer-checked:bg-gradient-to-r peer-checked:from-[#f7b7a1] peer-checked:to-[#e9896d] peer-checked:border-[#f7b7a1] transition-all peer-checked:shadow-md"></div>
                            <svg class="absolute top-0.5 left-0.5 w-4 h-4 text-white opacity-0 peer-checked:opacity-100 transition-opacity" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd"></path>
                            </svg>
                        </div>
                        <span class="text-sm text-gray-700 leading-relaxed">I agree to the <a href="#" class="font-semibold text-[#d76f49] underline">Terms of Service</a> and <a href="#" class="font-semibold text-[#d76f49] underline">Privacy Policy</a></span>
                    </label>

                    <div class="pt-2">
                        <x-primary-button class="w-full justify-center bg-gradient-to-r from-[#f7b7a1] via-[#e9896d] to-[#d76f49] hover:from-[#e9896d] hover:via-[#d76f49] hover:to-[#c75f40] border-0 shadow-lg hover:shadow-xl transform hover:-translate-y-0.5 transition-all duration-200">
                            <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M18 9v3m0 0v3m0-3h3m-3 0h-3m-2-5a4 4 0 11-8 0 4 4 0 018 0zM3 20a6 6 0 0112 0v1H3v-1z"></path>
                            </svg>
                            Create Jeat'aime Account
                        </x-primary-button>
                    </div>
                </form>
        </div>
    </div>
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
        showNotification(`${provider.charAt(0).toUpperCase() + provider.slice(1)} registration is coming soon! For now, please use the email form to create your account.`, 'info');
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
