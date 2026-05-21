<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center justify-between">
            <h2 class="font-semibold text-xl text-[#d76f49] leading-tight">{{ __('Checkout') }}</h2>
            <a href="{{ route('shop.show', $product) }}" class="inline-flex items-center px-4 py-2 rounded-full bg-gray-200 text-gray-700 font-semibold hover:bg-gray-300 transition">{{ __('Back') }}</a>
        </div>
    </x-slot>

    <div class="py-8 bg-gray-100 min-h-screen">
        <div class="max-w-6xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm p-8">
                @if($errors->any())
                    <div class="mb-4 p-4 rounded-lg bg-red-50 text-red-700">
                        <ul>
                            @foreach($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif

                <form method="POST" action="{{ route('orders.process-checkout-direct') }}" id="checkoutForm">
                    @csrf

                    <!-- Product Summary -->
                    <div class="mb-8">
                        <h2 class="text-2xl font-semibold text-gray-800 mb-6">Product Details</h2>
                        
                        <div class="rounded-lg bg-gray-50 p-6 border border-gray-200">
                            <div class="flex gap-6">
                                <div class="flex-shrink-0 product-thumbnail-frame w-24 h-24">
                                    @if($product->image)
                                        <img src="{{ asset('storage/' . $product->image) }}" alt="{{ $product->name }}" class="w-full h-full object-contain rounded" />
                                    @else
                                        <div class="w-24 h-24 rounded bg-gray-200 flex items-center justify-center text-gray-600 font-bold">{{ strtoupper(substr($product->name, 0, 2)) }}</div>
                                    @endif
                                </div>
                                <div class="flex-1">
                                    <p class="font-semibold text-gray-800 text-lg">{{ $product->name }}</p>
                                    <p class="text-gray-600 mt-1">{{ $product->description }}</p>
                                    <div class="mt-4 space-y-2">
                                        <p class="text-sm text-gray-700">
                                            <span class="font-medium">Quantity:</span> {{ $quantity }}
                                        </p>
                                        @if($size)
                                            <p class="text-sm text-gray-700">
                                                <span class="font-medium">Size:</span> {{ $size }}
                                            </p>
                                        @endif
                                        <p class="text-sm text-gray-700">
                                            <span class="font-medium">Unit Price:</span> ₱{{ number_format($product->price, 2) }}
                                        </p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Payment Method and Order Total Section -->
                    <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
                        <!-- Payment Method Section -->
                        <div class="lg:col-span-2">
                            <h3 class="text-lg font-semibold text-gray-800 mb-6">Payment Method</h3>
                            
                            <div class="space-y-3 mb-8">
                                @foreach($paymentMethods as $key => $method)
                                    <label class="flex items-center p-4 border-2 rounded-lg cursor-pointer transition {{ $loop->first ? 'border-[#d76f49] bg-orange-50' : 'border-gray-200 hover:border-[#d76f49]' }}">
                                        <input 
                                            type="radio" 
                                            name="payment_method" 
                                            value="{{ $key }}" 
                                            class="w-5 h-5 accent-[#d76f49] payment-method-radio"
                                            {{ $loop->first ? 'checked' : '' }}
                                            required
                                        />
                                        <span class="ml-3 font-medium text-gray-800">{{ $method }}</span>
                                    </label>
                                @endforeach
                            </div>
                            @error('payment_method')
                                <p class="text-red-600 text-sm">{{ $message }}</p>
                            @enderror

                            <!-- Conditional Payment Details -->
                            <div class="space-y-4 mt-6 pt-6 border-t border-gray-200">
                                <!-- Credit/Debit Card -->
                                <div id="credit_card_field" class="hidden">
                                    <label for="card_number" class="block text-sm font-medium text-gray-700 mb-2">Card Number</label>
                                    <input 
                                        type="text" 
                                        name="card_number" 
                                        id="card_number"
                                        placeholder="1234 5678 9012 3456"
                                        class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-[#d76f49] focus:border-[#d76f49]"
                                        maxlength="19"
                                    />
                                    @error('card_number')
                                        <p class="text-red-600 text-sm mt-1">{{ $message }}</p>
                                    @enderror
                                </div>

                                <!-- GCash -->
                                <div id="gcash_field" class="hidden">
                                    <label for="gcash_number" class="block text-sm font-medium text-gray-700 mb-2">GCash Phone Number</label>
                                    <input 
                                        type="text" 
                                        name="gcash_number" 
                                        id="gcash_number"
                                        placeholder="+63 9XX XXXX XXX"
                                        class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-[#d76f49] focus:border-[#d76f49]"
                                    />
                                    @error('gcash_number')
                                        <p class="text-red-600 text-sm mt-1">{{ $message }}</p>
                                    @enderror
                                </div>

                                <!-- PayPal -->
                                <div id="paypal_field" class="hidden">
                                    <label for="paypal_email" class="block text-sm font-medium text-gray-700 mb-2">PayPal Email</label>
                                    <input 
                                        type="email" 
                                        name="paypal_email" 
                                        id="paypal_email"
                                        placeholder="your@email.com"
                                        class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-[#d76f49] focus:border-[#d76f49]"
                                    />
                                    @error('paypal_email')
                                        <p class="text-red-600 text-sm mt-1">{{ $message }}</p>
                                    @enderror
                                </div>

                                <!-- Cash on Delivery - No field needed -->
                                <div id="cod_field" class="hidden text-gray-700 text-sm p-3 bg-blue-50 rounded-lg">
                                    <p class="font-medium">Payment will be collected upon delivery</p>
                                </div>
                            </div>
                        </div>

                        <!-- Order Total Section -->
                        <div>
                            <h3 class="text-lg font-semibold text-gray-800 mb-6">Order Total</h3>
                            
                            <div class="bg-gray-50 rounded-lg p-6 space-y-4">
                                <div class="flex justify-between text-sm">
                                    <span class="text-gray-600">Unit Price:</span>
                                    <span class="font-medium text-gray-800">₱{{ number_format($product->price, 2) }}</span>
                                </div>
                                <div class="flex justify-between text-sm">
                                    <span class="text-gray-600">Quantity:</span>
                                    <span class="font-medium text-gray-800">{{ $quantity }}</span>
                                </div>
                                <div class="flex justify-between text-sm">
                                    <span class="text-gray-600">Shipping:</span>
                                    <span class="font-medium text-gray-800">₱0.00</span>
                                </div>
                                <div class="border-t border-gray-200 pt-4 flex justify-between">
                                    <span class="font-semibold text-gray-800">Total Payment:</span>
                                    <span class="font-bold text-2xl text-[#d76f49]">₱{{ number_format($total, 2) }}</span>
                                </div>

                                <!-- Place Order Button -->
                                <button 
                                    type="submit" 
                                    class="w-full mt-6 bg-[#d76f49] text-white font-bold py-4 rounded hover:bg-[#e9896d] transition"
                                >
                                    Place Order
                                </button>
                            </div>
                        </div>
                    </div>

                    <!-- Hidden fields to preserve product details -->
                    <input type="hidden" name="product_id" value="{{ $product->id }}" />
                    <input type="hidden" name="quantity" value="{{ $quantity }}" />
                    @if($size)
                        <input type="hidden" name="size" value="{{ $size }}" />
                    @endif
                </form>

                <script>
                    const paymentMethodRadios = document.querySelectorAll('.payment-method-radio');
                    const paymentFields = {
                        'credit_card': document.getElementById('credit_card_field'),
                        'gcash': document.getElementById('gcash_field'),
                        'paypal': document.getElementById('paypal_field'),
                        'cod': document.getElementById('cod_field')
                    };

                    const paymentInputs = {
                        'credit_card': document.getElementById('card_number'),
                        'gcash': document.getElementById('gcash_number'),
                        'paypal': document.getElementById('paypal_email'),
                    };

                    function updatePaymentFields() {
                        const selectedPayment = document.querySelector('.payment-method-radio:checked').value;

                        // Hide all fields first
                        Object.values(paymentFields).forEach(field => {
                            if (field) field.classList.add('hidden');
                        });

                        // Remove required attribute from all inputs
                        Object.values(paymentInputs).forEach(input => {
                            if (input) input.removeAttribute('required');
                        });

                        // Show selected field and make input required (except for COD)
                        if (paymentFields[selectedPayment]) {
                            paymentFields[selectedPayment].classList.remove('hidden');
                        }
                        if (paymentInputs[selectedPayment]) {
                            paymentInputs[selectedPayment].setAttribute('required', 'required');
                        }
                    }

                    // Add event listeners to all payment method radios
                    paymentMethodRadios.forEach(radio => {
                        radio.addEventListener('change', updatePaymentFields);
                    });

                    // Initialize on page load
                    document.addEventListener('DOMContentLoaded', updatePaymentFields);
                </script>
            </div>
        </div>
    </div>
</x-app-layout>
