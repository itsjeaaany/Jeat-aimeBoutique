<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center justify-between">
            <h2 class="font-semibold text-xl text-[#d76f49] leading-tight">{{ __('Order Details') }}</h2>
            <a href="{{ Auth::user()->isSeller() ? route('seller.orders.index') : route('orders.index') }}" class="inline-flex items-center px-5 py-2 rounded-full bg-[#d76f49] text-white font-semibold shadow-sm hover:bg-[#e9896d] transition">{{ __('Back') }}</a>
        </div>
    </x-slot>

    <div class="py-12 bg-[#fff4ed]">
        <div class="max-w-4xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-[#fff0e8] overflow-hidden shadow-sm sm:rounded-3xl p-6 border border-[#ffd6c8] space-y-6">
                <div>
                    <p class="text-sm text-[#7b5a4b]">Order #{{ $order->id }}</p>
                    <p class="text-lg font-semibold text-[#2d1a11]">Status: {{ ucfirst($order->status) }}</p>
                    <p class="text-sm text-[#7b5a4b]">Buyer: {{ $order->user->name }}</p>
                </div>

                <div class="space-y-4">
                    @foreach($order->items as $item)
                        <div class="rounded-[1.5rem] bg-white border border-[#ffe0d0] p-4">
                            <div class="flex items-center justify-between gap-4">
                                <div class="flex items-center gap-4">
                                    <a href="{{ route('shop.show', $item->product) }}" class="block shrink-0">
                                        @if($item->product->image)
                                            <div class="w-20 h-20 rounded-2xl bg-[#fff0e8] overflow-hidden">
                                                <img src="{{ asset('storage/' . $item->product->image) }}" alt="{{ $item->product->name }}" class="w-full h-full object-contain" />
                                            </div>
                                        @else
                                            <div class="w-20 h-20 rounded-2xl bg-[#ffe7dd] flex items-center justify-center text-[#d76f49] font-bold">{{ strtoupper(substr($item->product->name, 0, 2)) }}</div>
                                        @endif
                                    </a>
                                    <div>
                                        <a href="{{ route('shop.show', $item->product) }}" class="font-semibold text-[#2d1a11] hover:text-[#d76f49] transition">{{ $item->product->name }}</a>
                                        <p class="text-sm text-[#7b5a4b]">Quantity: {{ $item->quantity }}</p>
                                        @if($item->size)
                                            <p class="text-sm text-[#7b5a4b]">Size: <span class="font-semibold">{{ $item->size }}</span></p>
                                        @endif
                                    </div>
                                </div>
                                <p class="font-semibold text-[#d76f49]">₱{{ number_format($item->total, 2) }}</p>
                            </div>
                        </div>
                    @endforeach
                </div>

                <div class="flex justify-between items-center">
                    <div>
                        @if(!Auth::user()->isSeller() && !in_array($order->status, ['confirmed', 'shipped', 'completed', 'cancelled']))
                            <form action="{{ route('orders.cancel', $order) }}" method="POST" class="inline" onsubmit="return confirm('Are you sure you want to cancel this order?');">
                                @csrf
                                @method('PATCH')
                                <button type="submit" class="inline-flex items-center px-4 py-2 rounded-full bg-red-600 text-white font-semibold hover:bg-red-700 transition">
                                    Cancel Order
                                </button>
                            </form>
                        @endif
                    </div>
                    <div>
                        @php
                            $calculatedTotal = $order->items->sum(fn($item) => $item->price * $item->quantity);
                        @endphp
                        <p class="text-lg font-semibold text-[#2d1a11]">Total: ₱{{ number_format($calculatedTotal, 2) }}</p>
                    </div>
                </div>

                @if(Auth::user()->isSeller() && $order->items->contains(fn($item) => $item->product->user_id === Auth::id()))
                    <form action="{{ route('seller.orders.update', $order) }}" method="POST" class="space-y-4">
                        @csrf
                        @method('PUT')

                        <div>
                            <label for="status" class="block text-sm font-medium text-[#7b5a4b]">{{ __('Update Status') }}</label>
                            <select id="status" name="status" class="mt-1 block w-full rounded-lg border border-[#ffd6c8] bg-white text-[#2d1a11] focus:border-[#d76f49] focus:ring-[#d76f49]/30">
                                @foreach(['pending', 'confirmed', 'shipped', 'completed', 'cancelled'] as $status)
                                    <option value="{{ $status }}" {{ $order->status === $status ? 'selected' : '' }}>{{ ucfirst($status) }}</option>
                                @endforeach
                            </select>
                        </div>

                        <x-primary-button class="bg-[#d76f49] hover:bg-[#e9896d]">{{ __('Save Status') }}</x-primary-button>
                    </form>
                @endif
            </div>
        </div>
    </div>
</x-app-layout>
