<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center justify-between">
            <h2 class="font-bold text-3xl   ">
                Welcome, <span class="bg-gradient-to-r from-[#d76f49] to-[#e9896d] bg-clip-text text-transparent">{{ Auth::user()->name }}</span>! 
            </h2>
            <div class="hidden md:flex items-center gap-2 px-4 py-2 rounded-full bg-[#ffe7dd] text-[#c86a59] font-semibold">
                <span class="h-2 w-2 rounded-full bg-[#d76f49]"></span>
                {{ ucfirst(Auth::user()->role) }}
            </div>
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <!-- Welcome Section -->
            <div class="mb-8">
                <div class="overflow-hidden bg-gradient-to-r from-[#f7b7a1] to-[#e9896d] rounded-3xl shadow-xl">
                    <div class="relative px-8 py-10">
                        <div class="absolute inset-0 opacity-10">
                            <div class="absolute top-5 right-10 text-white text-6xl opacity-20">🛍️</div>
                        </div>
                        <div class="relative z-10">
                            <p class="text-white/90 text-sm font-semibold uppercase tracking-wide">Ready to get started?</p>
                            <p class="mt-3 text-white text-xl font-bold">Explore our marketplace and discover amazing products</p>
                            <a href="{{ route('shop.index') }}" class="mt-5 inline-flex items-center gap-2 rounded-full bg-white px-6 py-3 font-bold text-[#d76f49] shadow-lg transition hover:shadow-xl hover:scale-105">
                                Browse Products
                                <svg class="h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 7l5 5m0 0l-5 5m5-5H6"></path>
                                </svg>
                            </a>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Quick Stats -->
            <div class="mb-8 grid gap-6 lg:grid-cols-3">
                <!-- My Orders Stat -->
                <div class="overflow-hidden rounded-2xl bg-white shadow-md hover:shadow-lg transition">
                    <div class="relative px-6 py-8">
                        <div class="flex items-center justify-between">
                            <div>
                                <p class="text-sm font-medium text-gray-600">Your Orders</p>
                                <p class="mt-2 text-3xl font-bold text-gray-900">{{ Auth::user()->orders()->count() }}</p>
                                <p class="mt-1 text-xs text-gray-500">Total purchases made</p>
                            </div>
                            <div class="h-16 w-16 rounded-2xl bg-gradient-to-br from-[#fff0e8] to-[#ffe7dd] flex items-center justify-center text-2xl">
                                📦
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Account Status -->
                <div class="overflow-hidden rounded-2xl bg-white shadow-md hover:shadow-lg transition">
                    <div class="relative px-6 py-8">
                        <div class="flex items-center justify-between">
                            <div>
                                <p class="text-sm font-medium text-gray-600">Account Status</p>
                                <div class="mt-2 flex items-center gap-2">
                                    <span class="h-3 w-3 rounded-full bg-green-500"></span>
                                    <span class="font-bold text-gray-900">Verified</span>
                                </div>
                                <p class="mt-1 text-xs text-gray-500">All systems operational</p>
                            </div>
                            <div class="h-16 w-16 rounded-2xl bg-gradient-to-br from-[#fff0e8] to-[#ffe7dd] flex items-center justify-center text-2xl">
                                ✓
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Member Since -->
                <div class="overflow-hidden rounded-2xl bg-white shadow-md hover:shadow-lg transition">
                    <div class="relative px-6 py-8">
                        <div class="flex items-center justify-between">
                            <div>
                                <p class="text-sm font-medium text-gray-600">Member Since</p>
                                <p class="mt-2 font-bold text-gray-900 text-lg">{{ Auth::user()->created_at->format('M Y') }}</p>
                                <p class="mt-1 text-xs text-gray-500">{{ Auth::user()->created_at->diffForHumans() }}</p>
                            </div>
                            <div class="h-16 w-16 rounded-2xl bg-gradient-to-br from-[#fff0e8] to-[#ffe7dd] flex items-center justify-center text-2xl">
                                ⭐
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Main Actions Grid -->
            <div class="space-y-6">
                <!-- Buyer / General Options -->
                <div>
                    <h3 class="mb-4 text-lg font-bold text-gray-900">Quick Actions</h3>
                    <div class="grid gap-4 md:grid-cols-2">
                        <!-- Browse Products -->
                        <a href="{{ route('shop.index') }}" class="group overflow-hidden rounded-2xl bg-white shadow-md hover:shadow-lg transition">
                            <div class="px-6 py-8">
                                <div class="flex items-start justify-between">
                                    <div>
                                        <h4 class="font-bold text-gray-900 group-hover:text-[#d76f49] transition">Browse Products</h4>
                                        <p class="mt-1 text-sm text-gray-600">Explore our marketplace and find amazing items</p>
                                        <div class="mt-4 inline-block rounded-full bg-[#fff0e8] px-4 py-2 text-xs font-semibold text-[#d76f49] group-hover:bg-[#ffe7dd] transition">
                                            Shop Now →
                                        </div>
                                    </div>
                                    <span class="text-3xl">🛒</span>
                                </div>
                            </div>
                        </a>

                        <!-- My Orders -->
                        <a href="{{ route('orders.index') }}" class="group overflow-hidden rounded-2xl bg-white shadow-md hover:shadow-lg transition">
                            <div class="px-6 py-8">
                                <div class="flex items-start justify-between">
                                    <div>
                                        <h4 class="font-bold text-gray-900 group-hover:text-[#d76f49] transition">My Orders</h4>
                                        <p class="mt-1 text-sm text-gray-600">View and track your purchases</p>
                                        <div class="mt-4 inline-block rounded-full bg-[#fff0e8] px-4 py-2 text-xs font-semibold text-[#d76f49] group-hover:bg-[#ffe7dd] transition">
                                            View Orders →
                                        </div>
                                    </div>
                                    <span class="text-3xl">📋</span>
                                </div>
                            </div>
                        </a>
                    </div>
                </div>

                <!-- Seller Options -->
                @if(Auth::user()->isSeller())
                    <div>
                        <h3 class="mb-4 text-lg font-bold text-gray-900">Seller Tools</h3>
                        <div class="grid gap-4 md:grid-cols-2">
                            <!-- Manage Products -->
                            <a href="{{ route('seller.products.index') }}" class="group overflow-hidden rounded-2xl bg-gradient-to-br from-[#f7b7a1] to-[#e9896d] shadow-md hover:shadow-lg transition">
                                <div class="px-6 py-8">
                                    <div class="flex items-start justify-between">
                                        <div>
                                            <h4 class="font-bold text-white group-hover:text-white transition">Manage Products</h4>
                                            <p class="mt-1 text-sm text-white/90">Add, edit, or remove your products</p>
                                            <div class="mt-4 inline-block rounded-full bg-white px-4 py-2 text-xs font-semibold text-[#d76f49] group-hover:bg-[#ffe7dd] transition">
                                                Manage →
                                            </div>
                                        </div>
                                        <span class="text-3xl">📦</span>
                                    </div>
                                </div>
                            </a>

                            <!-- Seller Orders -->
                            <a href="{{ route('seller.orders.index') }}" class="group overflow-hidden rounded-2xl bg-gradient-to-br from-[#e9896d] to-[#d76f49] shadow-md hover:shadow-lg transition">
                                <div class="px-6 py-8">
                                    <div class="flex items-start justify-between">
                                        <div>
                                            <h4 class="font-bold text-white group-hover:text-white transition">Seller Orders</h4>
                                            <p class="mt-1 text-sm text-white/90">View and manage incoming orders</p>
                                            <div class="mt-4 inline-block rounded-full bg-white px-4 py-2 text-xs font-semibold text-[#d76f49] group-hover:bg-[#ffe7dd] transition">
                                                View Orders →
                                            </div>
                                        </div>
                                        <span class="text-3xl">🎯</span>
                                    </div>
                                </div>
                            </a>
                        </div>
                    </div>
                @endif
            </div>

            <!-- Help Section -->
            <div class="mt-12 rounded-2xl bg-gradient-to-r from-[#fff0e8] to-[#ffe7dd] p-8">
                <h3 class="text-lg font-bold text-gray-900">Need Help?</h3>
                <p class="mt-2 text-sm text-gray-700">Have questions about how to use Jeat'aime? Check out our help center or contact our support team.</p>
                <div class="mt-5 flex gap-3">
                    <button class="rounded-full bg-[#f7b7a1] px-6 py-2 font-semibold text-white shadow-md hover:shadow-lg hover:bg-[#e9896d] transition">
                        Help Center
                    </button>
                    <button class="rounded-full border-2 border-[#d76f49] px-6 py-2 font-semibold text-[#d76f49] hover:bg-[#fff0e8] transition">
                        Contact Support
                    </button>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
