<x-app-layout>
    <div class="relative overflow-hidden bg-white text-gray-900">
        <div class="max-w-7xl mx-auto px-4 py-12 sm:px-6 lg:px-8">
            <div class="grid gap-8 lg:grid-cols-2 items-center">
                <div class="space-y-6">
                    <p class="uppercase tracking-[0.3em] text-sm font-bold text-black">Jeat'aime Boutique</p>
                    <h1 class="text-4xl font-extrabold sm:text-5xl text-gray-900">Shop the latest fashion, beauty, and lifestyle finds.</h1>
                    <p class="max-w-xl text-lg text-gray-700 font-medium">Browse curated collections from local sellers and discover daily deals inspired by modern e-commerce design.</p>
                    <form action="{{ route('shop.index') }}" method="GET" class="flex flex-col gap-3 sm:flex-row">
                        <input type="text" name="search" value="{{ request('search') }}" placeholder="Search for products, brands and more" class="shopee-input w-full text-gray-700" />
                        <button type="submit" class="shopee-btn w-full sm:w-auto">Search</button>
                    </form>
                </div>

                <div class="grid grid-cols-2 gap-4">
                    <div class="rounded-[2rem] bg-[#fff0e8] p-6 border-2 border-[#ffd6c8]">
                        <p class="text-sm uppercase tracking-[0.2em] text-black font-bold">Daily Deals</p>
                        <p class="mt-4 text-2xl font-semibold text-gray-900">Up to 50% off</p>
                        <p class="mt-2 text-sm text-gray-800">Catch exclusive sale items from top sellers.</p>
                    </div>
                    <div class="rounded-[2rem] bg-[#fff0e8] p-6 border-2 border-[#ffd6c8]">
                        <p class="text-sm uppercase tracking-[0.2em] text-black font-bold">Trending</p>
                        <p class="mt-4 text-2xl font-semibold text-gray-900">Shop the bestseller list</p>
                        <p class="mt-2 text-sm text-gray-800">Explore curated picks that shoppers love.</p>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="py-10 bg-[#fff0e8]">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="mb-8 flex flex-wrap gap-3">
                @foreach($categories as $category)
                    @php $isActive = request('category') === $category; @endphp
                    <a href="{{ route('shop.index', array_merge(request()->query(), ['category' => $category])) }}"
                       class="inline-flex items-center justify-center rounded-full border px-5 py-2 text-sm font-semibold transition focus:outline-none focus:ring-2 focus:ring-[#d76f49] {{ $isActive ? 'border-[#d76f49] bg-white text-[#d76f49] shadow-sm' : 'border-[#fdc2b2] bg-[#fff1ea] text-[#b94a2a] hover:bg-[#ffe4d7]' }}">
                        {{ $category }}
                    </a>
                @endforeach
            </div>

            @if(request('category'))
                <p class="mb-4 text-sm text-[#8f4e36]">Showing products in the “{{ request('category') }}” category.</p>
            @endif

            <h2 class="text-2xl font-bold text-gray-900">Popular Products</h2>
            <p class="mt-2 text-gray-600">Shop the newest arrivals from sellers across the marketplace.</p>

            <div class="mt-8 grid gap-6 sm:grid-cols-2 lg:grid-cols-3">
                @forelse($products as $product)
                    <div class="shopee-card p-5 bg-[#fff0e8] rounded-3xl border-2 border-[#ffd6c8]">
                        <div class="mb-4 product-image-frame">
                            @if($product->image)
                                <img src="{{ asset('storage/' . $product->image) }}" alt="{{ $product->name }}" class="h-36 object-contain mx-auto" />
                            @else
                                <div class="h-36 w-full rounded-3xl bg-[#ffe7dd] flex items-center justify-center text-[#d76f49] font-bold">{{ strtoupper(substr($product->name, 0, 2)) }}</div>
                            @endif
                        </div>
                        <div class="space-y-3">
                            @php $sold = (int) ($product->total_sold ?? 0); @endphp
                            @if($sold >= 5)
                                <p class="text-sm text-[#d76f49] font-semibold inline-block px-3 py-1 rounded-full bg-white/60" title="{{ $sold }} sold">Best seller</p>
                            @endif
                            <h3 class="text-lg font-semibold text-white-900">{{ $product->name }}</h3>
                            <p class="text-sm text-gray-500">{{ \Illuminate\Support\Str::limit($product->description, 100) }}</p>
                            <div class="flex items-center justify-between gap-3">
                                <div>
                                    <p class="text-xl font-bold text-[#d76f49]">₱{{ number_format($product->price, 2) }}</p>
                                    <p class="text-xs text-gray-500">Stock: {{ $product->stock }}</p>
                                </div>
                                <a href="{{ route('shop.show', $product) }}" class="shopee-btn">View</a>
                            </div>
                        </div>
                    </div>
                @empty
                    <div class="col-span-3 rounded-3xl bg-white p-6">
                        <p class="text-gray-700">No products found.</p>
                    </div>
                @endforelse
            </div>

            <div class="mt-10">
                {{ $products->links() }}
            </div>
        </div>
    </div>
</x-app-layout>
