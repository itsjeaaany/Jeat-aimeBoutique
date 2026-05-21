<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center justify-between">
            <h2 class="font-semibold text-xl text-[#d76f49] leading-tight">{{ __('Shopping Cart') }}</h2>
            <a href="{{ route('shop.index') }}" class="inline-flex items-center px-4 py-2 rounded-full bg-[#d76f49] text-white font-semibold hover:bg-[#e9896d] transition">{{ __('Continue Shopping') }}</a>
        </div>
    </x-slot>

    <div class="py-12 bg-[#fff4ed]">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-[#fff0e8] overflow-hidden shadow-sm sm:rounded-3xl p-6 border border-[#ffd6c8]">
                @if(session('success'))
                    <div class="mb-4 p-4 rounded-lg bg-green-50 text-green-700">{{ session('success') }}</div>
                @endif

                @if($errors->any())
                    <div class="mb-4 p-4 rounded-lg bg-red-50 text-red-700">
                        <ul>
                            @foreach($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif

                @if($cartItems->isEmpty())
                    <div class="text-center py-12">
                        <p class="text-[#7b5a4b] text-lg mb-6">Your cart is empty</p>
                        <a href="{{ route('shop.index') }}" class="inline-flex items-center rounded-full bg-[#d76f49] px-6 py-3 text-sm font-semibold text-white shadow-sm hover:bg-[#e9896d] transition">Start Shopping</a>
                    </div>
                @else
                    <form method="GET" action="{{ route('cart.checkout') }}" id="checkoutForm">
                        <div class="grid gap-6 lg:grid-cols-3">
                            <!-- Cart Items -->
                            <div class="lg:col-span-2 space-y-4">
                                @foreach($cartItems as $item)
                                    <div class="rounded-[1.5rem] bg-white border border-[#ffe0d0] p-4 shadow-sm cart-item h-[140px]" data-total="{{ $item->getTotal() }}">
                                        <div class="flex gap-4 h-full items-center">
                                            <!-- Checkbox -->
                                            <div class="flex items-start pt-1">
                                                <input type="checkbox" name="selected_items[]" value="{{ $item->id }}" class="cart-checkbox w-4 h-4 rounded border-[#d76f49] text-[#d76f49] cursor-pointer" onchange="updateTotal()" />
                                            </div>

                                            <!-- Product Image & Info -->
                                            <div class="flex-1 min-w-0">
                                                <div class="flex gap-3 items-center h-full">
                                                    <!-- Link wrapping image and basic details (excludes quantity form) -->
                                                    <a href="{{ route('shop.show', $item->product) }}" class="flex gap-3 items-center min-w-0 flex-1 no-underline">
                                                        <!-- Image -->
                                                        <div class="flex-shrink-0 w-20 h-20 rounded-3xl bg-[#fff0e8] flex items-center justify-center overflow-hidden">
                                                            @if($item->product->image)
                                                                <img src="{{ asset('storage/' . $item->product->image) }}" alt="{{ $item->product->name }}" class="max-w-full max-h-full object-contain" />
                                                            @else
                                                                <div class="w-full h-full flex items-center justify-center text-[#d76f49] font-bold text-[10px] text-center">{{ strtoupper(substr($item->product->name, 0, 2)) }}</div>
                                                            @endif
                                                        </div>

                                                        <!-- Details (linkable portion) -->
                                                        <div class="flex-1 min-w-0 h-full flex flex-col justify-center gap-0.5">
                                                            <p class="font-semibold text-sm text-[#2d1a11] truncate">{{ $item->product->name }}</p>
                                                            <p class="text-xs text-[#7b5a4b]">₱{{ number_format($item->price, 2) }} each</p>
                                                            @if($item->size)
                                                                <p class="text-xs text-[#7b5a4b]">Size: <span class="font-semibold">{{ $item->size }}</span></p>
                                                            @endif
                                                        </div>
                                                    </a>
                                                </div>
                                            </div>

                                            <!-- Price, Qty & Remove -->
                                            <div class="flex flex-col items-end justify-center w-36 h-full text-right gap-2">
                                                <div class="flex items-center gap-2">
                                                    <label class="text-xs font-medium text-[#2d1a11]">Qty:</label>
                                                    <form method="POST" action="{{ route('cart.update', $item) }}" class="inline-flex items-center gap-1">
                                                        @csrf
                                                        @method('PATCH')
                                                        <input type="number" name="quantity" value="{{ $item->quantity }}" min="1" max="{{ $item->product->stock }}" class="w-14 px-2 py-1 border border-[#d76f49] rounded text-center text-xs" onchange="this.form.submit()" />
                                                    </form>
                                                </div>

                                                <p class="font-semibold text-[#d76f49] text-base item-price">₱{{ number_format($item->getTotal(), 2) }}</p>
                                                <form method="POST" action="{{ route('cart.remove', $item) }}" onsubmit="return confirm('Remove this item from cart?')">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="submit" class="text-red-600 text-xs font-medium hover:text-red-700 transition">Remove</button>
                                                </form>
                                            </div>
                                        </div>
                                    </div>
                                @endforeach
                            </div>

                            <!-- Order Summary -->
                            <div class="lg:col-span-1">
                                <div class="rounded-[1.5rem] bg-white border border-[#ffe0d0] p-6 shadow-sm sticky top-4 space-y-4">
                                    <h3 class="font-semibold text-[#2d1a11] text-lg">Order Summary</h3>

                                    <div class="space-y-2 pb-4 border-b border-[#ffd6c8]">
                                        <div class="flex justify-between text-sm">
                                            <span class="text-[#7b5a4b]">Subtotal:</span>
                                            <span class="font-medium text-[#2d1a11]">₱<span id="subtotal">0.00</span></span>
                                        </div>
                                        <div class="flex justify-between text-sm">
                                            <span class="text-[#7b5a4b]">Items selected:</span>
                                            <span class="font-medium text-[#2d1a11]"><span id="itemCount">0</span>/<span id="totalItems">{{ $cartItems->count() }}</span></span>
                                        </div>
                                    </div>

                                    <div class="flex justify-between text-lg font-semibold">
                                        <span class="text-[#2d1a11]">Total:</span>
                                        <span class="text-[#d76f49]">₱<span id="totalPrice">0.00</span></span>
                                    </div>

                                    <button type="submit" class="w-full bg-[#d76f49] text-white font-semibold py-3 rounded-full hover:bg-[#e9896d] transition disabled:opacity-50 disabled:cursor-not-allowed" id="checkoutBtn" disabled>
                                        Checkout Selected
                                    </button>

                                    <a href="{{ route('shop.index') }}" class="w-full block text-center bg-gray-200 text-gray-700 font-semibold py-3 rounded-full hover:bg-gray-300 transition">Continue Shopping</a>
                                </div>
                            </div>
                        </div>
                    </form>
                @endif
            </div>
        </div>
    </div>

    <script>
        function updateTotal() {
            const checkboxes = document.querySelectorAll('.cart-checkbox');
            const checkedCheckboxes = document.querySelectorAll('.cart-checkbox:checked');
            let total = 0;
            let itemCount = checkedCheckboxes.length;

            checkedCheckboxes.forEach(checkbox => {
                const cartItem = checkbox.closest('.cart-item');
                const itemTotal = parseFloat(cartItem.dataset.total);
                total += itemTotal;
            });

            document.getElementById('totalPrice').textContent = total.toFixed(2);
            document.getElementById('subtotal').textContent = total.toFixed(2);
            document.getElementById('itemCount').textContent = itemCount;
            document.getElementById('checkoutBtn').disabled = itemCount === 0;
        }

        document.addEventListener('DOMContentLoaded', function() {
            updateTotal();
        });

        document.getElementById('checkoutForm').addEventListener('submit', function(e) {
            const checkedItems = document.querySelectorAll('.cart-checkbox:checked');
            if (checkedItems.length === 0) {
                e.preventDefault();
                alert('Please select at least one item to checkout');
                return false;
            }
        });
    </script>
</x-app-layout>
