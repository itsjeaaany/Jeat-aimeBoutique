<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center justify-between">
            <h2 class="font-semibold text-xl text-[#d76f49] leading-tight">{{ __('Checkout') }}</h2>
            <a href="{{ route('cart.index') }}" class="inline-flex items-center px-4 py-2 rounded-full bg-gray-200 text-gray-700 font-semibold hover:bg-gray-300 transition">{{ __('Back to Cart') }}</a>
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

                <form method="POST" action="{{ route('cart.process-checkout') }}" id="checkoutForm">
                    @csrf

                    <!-- Products Ordered Section -->
                    <div class="mb-8">
                        <h2 class="text-2xl font-semibold text-gray-800 mb-6">Products Ordered</h2>
                        
                        <div class="overflow-x-auto">
                            <table class="w-full">
                                <thead>
                                    <tr class="border-b-2 border-gray-200">
                                        <th class="px-4 py-4 text-left text-gray-600 font-semibold text-sm">Product</th>
                                        <th class="px-4 py-4 text-center text-gray-600 font-semibold text-sm">Unit Price</th>
                                        <th class="px-4 py-4 text-center text-gray-600 font-semibold text-sm">Quantity</th>
                                        <th class="px-4 py-4 text-right text-gray-600 font-semibold text-sm">Item Subtotal</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($cartItems as $item)
                                        <tr class="border-b border-gray-100 hover:bg-gray-50 transition">
                                            <!-- Hidden field to track selected items -->
                                            <input type="hidden" name="selected_items[]" value="{{ $item->id }}" />
                                            
                                            <td class="px-4 py-6">
                                                <div class="flex items-center gap-4">
                                                    <div class="flex-shrink-0 product-thumbnail-frame w-20 h-20">
                                                        @if($item->product->image)
                                                            <img src="{{ asset('storage/' . $item->product->image) }}" alt="{{ $item->product->name }}" class="w-full h-full object-contain rounded" />
                                                        @else
                                                            <div class="w-20 h-20 rounded bg-gray-200 flex items-center justify-center text-gray-600 font-bold">{{ strtoupper(substr($item->product->name, 0, 2)) }}</div>
                                                        @endif
                                                    </div>
                                                    <div>
                                                        <p class="font-medium text-gray-800 text-sm">{{ $item->product->name }}</p>
                                                        @if($item->size)
                                                            <p class="text-xs text-gray-600 mt-1">Variation: {{ $item->size }}</p>
                                                        @endif
                                                    </div>
                                                </div>
                                            </td>
                                            <td class="px-4 py-6 text-center">
                                                <span class="font-medium text-gray-700 text-sm">₱{{ number_format($item->price, 2) }}</span>
                                            </td>
                                            <td class="px-4 py-6 text-center">
                                                <span class="font-medium text-gray-700 text-sm">{{ $item->quantity }}</span>
                                            </td>
                                            <td class="px-4 py-6 text-right">
                                                <span class="font-medium text-gray-800 text-sm">₱{{ number_format($item->getTotal(), 2) }}</span>
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
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
                                    <span class="text-gray-600">Merchandise Subtotal:</span>
                                    <span class="font-medium text-gray-800">₱{{ number_format($total, 2) }}</span>
                                </div>
                                <div class="flex justify-between text-sm">
                                    <span class="text-gray-600">Shipping Subtotal:</span>
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
