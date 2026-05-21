<x-app-layout>
    <div class="relative overflow-hidden bg-[#f7b7a1] text-white py-12">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex flex-col gap-4 sm:flex-row sm:items-center sm:justify-between">
                <div>
                    <p class="uppercase tracking-[0.3em] text-sm font-bold">Product Detail</p>
                    <h1 class="mt-3 text-4xl font-extrabold">{{ $product->name }}</h1>
                    <p class="mt-2 max-w-2xl text-[#fff0e8]">Shop safely with local sellers, enjoy simple checkout, and fast order tracking.</p>
                </div>
                <div class="rounded-full bg-white/15 px-5 py-3 text-sm font-semibold text-white inline-flex items-center gap-2">
                    <span>Seller:</span> {{ $product->seller->name }}
                </div>
            </div>
        </div>
    </div>

    <div class="py-10 bg-[#fff0e8]">
        <div class="max-w-6xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="grid gap-8 lg:grid-cols-3">
                <div class="lg:col-span-2 shopee-card p-6 bg-white shadow-sm">
                    <div class="rounded-[2rem] bg-[#fff0e8] p-6 flex items-center justify-center">
                        @if($product->image)
                            <img src="{{ asset('storage/' . $product->image) }}" alt="{{ $product->name }}" class="h-72 object-contain" />
                        @else
                            <div class="h-72 w-full rounded-[2rem] bg-[#ffe7dd] flex items-center justify-center text-[#d76f49] font-bold text-4xl">{{ strtoupper(substr($product->name, 0, 2)) }}</div>
                        @endif
                    </div>

                    <div class="mt-6 space-y-4">
                        <p class="text-black font-medium">{{ $product->description }}</p>
                        <div class="grid gap-4 sm:grid-cols-2">
                            <div class="rounded-3xl bg-[#FFB7AC] p-4 shadow-sm">
                                <p class="text-sm text-gray-600 font-medium">Category</p>
                                <p class="mt-2 font-semibold text-gray-900">Trending</p>
                            </div>
                            <div class="rounded-3xl bg-white p-4 shadow-sm">
                                <p class="text-sm text-gray-600 font-medium">Stock</p>
                                <p class="mt-2 font-semibold text-gray-900">{{ $product->stock }}</p>
                            </div>
                        </div>
                    </div>
                </div>

                <aside class="space-y-6">
                    <div class="shopee-card p-6 bg-white shadow-sm">
                        <p class="text-sm uppercase tracking-[0.3em] text-[#d76f49] font-bold">Price</p>
                        <p class="mt-4 text-4xl font-bold text-gray">₱{{ number_format($product->price, 2) }}</p>
                        <p class="mt-2 text-sm text-gray-600 font-medium">Secure checkout and seller protection included.</p>
                    </div>

                    <div class="shopee-card p-6 bg-white shadow-sm">
                        @auth
                            @if(auth()->user()->isBuyer())
                                @if($product->stock > 0)
                                    <form action="{{ route('orders.checkout.direct', $product) }}" method="GET" class="space-y-4" id="orderForm">
                                    
                                    @if(in_array($product->category, ['Apparel', 'Footwear']))
                                        <div>
                                            <label for="size" class="block text-sm font-medium text-gray-700">{{ __('Size') }}</label>
                                            <div class="mt-3 grid gap-3 {{ $product->category === 'Apparel' ? 'grid-cols-5' : 'grid-cols-4' }}">
                                                @if($product->category === 'Apparel')
                                                    @foreach(['XS', 'S', 'M', 'L', 'XL'] as $size)
                                                        <label class="flex items-center justify-center p-2 border-2 rounded-lg cursor-pointer transition {{ $loop->first ? 'border-[#d76f49] bg-[#ffe7dd]' : 'border-gray-300 hover:border-[#d76f49]' }}">
                                                            <input type="radio" name="size" value="{{ $size }}" class="hidden" required {{ $loop->first ? 'checked' : '' }} onchange="updateSizeUI(this)" />
                                                            <span class="font-semibold text-gray-900">{{ $size }}</span>
                                                        </label>
                                                    @endforeach
                                                @elseif($product->category === 'Footwear')
                                                    @foreach([36, 37, 38, 39, 40, 41, 42, 43] as $size)
                                                        <label class="flex items-center justify-center p-2 border-2 rounded-lg cursor-pointer transition {{ $loop->first ? 'border-[#d76f49] bg-[#ffe7dd]' : 'border-gray-300 hover:border-[#d76f49]' }}">
                                                            <input type="radio" name="size" value="{{ $size }}" class="hidden" required {{ $loop->first ? 'checked' : '' }} onchange="updateSizeUI(this)" />
                                                            <span class="font-semibold text-gray-900">{{ $size }}</span>
                                                        </label>
                                                    @endforeach
                                                @endif
                                            </div>
                                            <x-input-error :messages="$errors->get('size')" class="mt-2" />
                                        </div>
                                    @endif

                                    <div>
                                        <label for="quantity" class="block text-sm font-medium text-gray-700">Quantity</label>
                                        <input id="quantity" name="quantity" type="number" min="1" max="{{ $product->stock }}" value="1" class="mt-1 w-full shopee-input" />
                                        <x-input-error :messages="$errors->get('quantity')" class="mt-2" />
                                    </div>

                                    <div class="flex gap-3">
                                        <button type="submit" class="flex-1 shopee-btn">Place order</button>
                                        <button type="button" onclick="addToCart()" class="flex-1 bg-white border-2 border-[#d76f49] text-[#d76f49] font-semibold py-2 rounded-full hover:bg-[#fff0e8] transition">Add to cart</button>
                                    </div>
                                    </form>
                                @else
                                    <p class="text-red-600">Out of stock.</p>
                                @endif
                            @else
                                <div class="rounded-lg bg-amber-50 border-2 border-amber-200 p-4">
                                    <p class="text-amber-800 font-medium">{{ auth()->user()->isSeller() ? 'Sellers can only sell products, not buy them. Visit your seller dashboard to manage your products.' : 'Only buyers can purchase products.' }}</p>
                                </div>
                            @endif
                        @else
                            <p class="text-gray-700">Please <a href="{{ route('login') }}" class="text-[#d76f49] font-semibold">log in</a> to place an order.</p>
                        @endauth
                    </div>
                </aside>
            </div>
        </div>
    </div>
</x-app-layout>

<script>
    function updateSizeUI(radioButton) {
        // Remove all selections
        document.querySelectorAll('input[name="size"]').forEach(input => {
            input.parentElement.classList.remove('border-[#d76f49]', 'bg-[#ffe7dd]');
            input.parentElement.classList.add('border-gray-300');
        });
        
        // Add selection to clicked
        radioButton.parentElement.classList.remove('border-gray-300');
        radioButton.parentElement.classList.add('border-[#d76f49]', 'bg-[#ffe7dd]');
    }

    function addToCart() {
        // Get form data
        const form = document.getElementById('orderForm');
        
        // Create a new form for cart submission
        const cartForm = document.createElement('form');
        cartForm.method = 'POST';
        cartForm.action = '{{ route("cart.add", $product) }}';
        
        // Create CSRF token input
        const csrfInput = document.createElement('input');
        csrfInput.type = 'hidden';
        csrfInput.name = '_token';
        csrfInput.value = '{{ csrf_token() }}';
        cartForm.appendChild(csrfInput);
        
        // Copy quantity
        const quantityInput = form.querySelector('input[name="quantity"]');
        const cartQuantityInput = document.createElement('input');
        cartQuantityInput.type = 'hidden';
        cartQuantityInput.name = 'quantity';
        cartQuantityInput.value = quantityInput.value;
        cartForm.appendChild(cartQuantityInput);
        
        // Copy size if exists
        const sizeInput = form.querySelector('input[name="size"]:checked');
        if (sizeInput) {
            const cartSizeInput = document.createElement('input');
            cartSizeInput.type = 'hidden';
            cartSizeInput.name = 'size';
            cartSizeInput.value = sizeInput.value;
            cartForm.appendChild(cartSizeInput);
        }
        
        // Submit form
        document.body.appendChild(cartForm);
        cartForm.submit();
    }
</script>
