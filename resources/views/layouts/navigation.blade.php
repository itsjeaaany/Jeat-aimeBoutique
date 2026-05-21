<nav x-data="{ open: false }" class="bg-white dark:bg-gray-900 shadow-sm">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex h-16 items-center justify-between">
            <div class="flex items-center gap-4">
                <a href="{{ route('shop.index') }}" class="flex items-center gap-2 text-[#d76f49] font-bold text-xl">
                    <x-application-logo class="h-8 w-auto fill-current text-[#d76f49]" />
                    <span>Jeat’aime</span>
                </a>

                <form action="{{ route('shop.index') }}" method="GET" class="hidden lg:flex items-center gap-2">
                    <input type="text" name="search" value="{{ request('search') }}" placeholder="Search for products, brands and more" class="shopee-input w-80" />
                    <button type="submit" class="shopee-btn">Search</button>
                </form>
            </div>

            <div class="hidden sm:flex sm:items-center sm:space-x-3">
                <x-nav-link :href="route('shop.index')" :active="request()->routeIs('shop.*') || request()->routeIs('/')">
                    {{ __('Shop') }}
                </x-nav-link>

                @auth
                    <x-nav-link :href="route('dashboard')" :active="request()->routeIs('dashboard')">
                        {{ __('Dashboard') }}
                    </x-nav-link>

                    @if(Auth::user()->isBuyer())
                        <x-nav-link :href="route('cart.index')" :active="request()->routeIs('cart.*')">
                            {{ __('Cart') }}
                        </x-nav-link>
                    @endif

                    @if(Auth::user()->isSeller())
                        <x-nav-link :href="route('seller.orders.index')" :active="request()->routeIs('seller.orders.*')">
                            {{ __('Seller Orders') }}
                        </x-nav-link>
                    @else
                        <x-nav-link :href="route('orders.index')" :active="request()->routeIs('orders.*')">
                            {{ __('Orders') }}
                        </x-nav-link>
                    @endif

                    @if(Auth::user()->isSeller())
                        <x-nav-link :href="route('seller.products.index')" :active="request()->routeIs('seller.products.*')">
                            {{ __('My Products') }}
                        </x-nav-link>
                    @endif

                    <x-dropdown align="right" width="48">
                        <x-slot name="trigger">
                            <button class="inline-flex items-center px-3 py-2 border border-transparent text-sm font-medium rounded-full text-gray-700 bg-gray-100 hover:bg-gray-200 focus:outline-none focus:ring-2" style="--tw-ring-color: rgba(247, 183, 161, 0.55);">
                                {{ Auth::user()->name }}
                                <svg class="ms-2 h-4 w-4" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7" />
                                </svg>
                            </button>
                        </x-slot>

                        <x-slot name="content">
                            <x-dropdown-link :href="route('profile.edit')">{{ __('Profile') }}</x-dropdown-link>
                            <form method="POST" action="{{ route('logout') }}">
                                @csrf
                                <x-dropdown-link :href="route('logout')" onclick="event.preventDefault(); this.closest('form').submit();">{{ __('Log Out') }}</x-dropdown-link>
                            </form>
                        </x-slot>
                    </x-dropdown>
                @else
                    <a href="{{ route('login') }}" class="text-gray-700 hover:text-gray-900">{{ __('Login') }}</a>
                    <a href="{{ route('register') }}" class="shopee-btn">{{ __('Register') }}</a>
                @endauth
            </div>

            <div class="-mr-2 flex items-center sm:hidden">
                <button @click="open = ! open" class="inline-flex items-center justify-center rounded-md p-2 text-gray-500 hover:bg-gray-100 hover:text-gray-700 focus:outline-none focus:ring-2" style="--tw-ring-color: rgba(247, 183, 161, 0.55);">
                    <svg class="h-6 w-6" stroke="currentColor" fill="none" viewBox="0 0 24 24">
                        <path :class="{'hidden': open, 'inline-flex': ! open }" class="inline-flex" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16" />
                        <path :class="{'hidden': ! open, 'inline-flex': open }" class="hidden" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                    </svg>
                </button>
            </div>
        </div>
    </div>

    <div :class="{'block': open, 'hidden': ! open}" class="hidden sm:hidden">
        <div class="pt-2 pb-3 space-y-1">
            <x-responsive-nav-link :href="route('shop.index')" :active="request()->routeIs('shop.*') || request()->routeIs('/')">
                {{ __('Shop') }}
            </x-responsive-nav-link>

            @auth
                <x-responsive-nav-link :href="route('dashboard')" :active="request()->routeIs('dashboard')">
                    {{ __('Dashboard') }}
                </x-responsive-nav-link>

                @if(Auth::user()->isBuyer())
                    <x-responsive-nav-link :href="route('cart.index')" :active="request()->routeIs('cart.*')">
                        {{ __('Cart') }}
                    </x-responsive-nav-link>
                @endif

                @if(Auth::user()->isSeller())
                    <x-responsive-nav-link :href="route('seller.orders.index')" :active="request()->routeIs('seller.orders.*')">
                        {{ __('Seller Orders') }}
                    </x-responsive-nav-link>
                @else
                    <x-responsive-nav-link :href="route('orders.index')" :active="request()->routeIs('orders.*')">
                        {{ __('Orders') }}
                    </x-responsive-nav-link>
                @endif

                @if(Auth::user()->isSeller())
                    <x-responsive-nav-link :href="route('seller.products.index')" :active="request()->routeIs('seller.products.*')">
                        {{ __('My Products') }}
                    </x-responsive-nav-link>
                @endif
            @else
                <x-responsive-nav-link :href="route('login')" :active="request()->routeIs('login')">
                    {{ __('Login') }}
                </x-responsive-nav-link>
                <x-responsive-nav-link :href="route('register')" :active="request()->routeIs('register')">
                    {{ __('Register') }}
                </x-responsive-nav-link>
            @endauth
        </div>

        @auth
            <div class="pt-4 pb-1 border-t border-gray-200 dark:border-gray-700">
                <div class="px-4">
                    <div class="font-medium text-base text-gray-800 dark:text-gray-200">{{ Auth::user()->name }}</div>
                    <div class="font-medium text-sm text-gray-500">{{ Auth::user()->email }}</div>
                </div>

                <div class="mt-3 space-y-1">
                    <x-responsive-nav-link :href="route('profile.edit')">
                        {{ __('Profile') }}
                    </x-responsive-nav-link>

                    <form method="POST" action="{{ route('logout') }}">
                        @csrf

                        <x-responsive-nav-link :href="route('logout')" onclick="event.preventDefault(); this.closest('form').submit();">
                            {{ __('Log Out') }}
                        </x-responsive-nav-link>
                    </form>
                </div>
            </div>
        @endauth
    </div>
</nav>
