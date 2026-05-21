<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center justify-between">
            <h2 class="font-semibold text-xl text-[#d76f49] leading-tight">{{ __('My Orders') }}</h2>
            <a href="{{ route('shop.index') }}" class="inline-flex items-center px-4 py-2 rounded-full bg-[#d76f49] text-white font-semibold hover:bg-[#e9896d] transition">{{ __('Continue Shopping') }}</a>
        </div>
    </x-slot>

    <div class="py-12 bg-[#fff4ed]">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-[#fff0e8] overflow-hidden shadow-sm sm:rounded-3xl p-6 border border-[#ffd6c8]">
                @if(session('success'))
                    <div class="mb-4 text-[#d76f49]">{{ session('success') }}</div>
                @endif

                @forelse($orders as $order)
                    <div class="mb-6 border border-[#ffd6c8] rounded-[2rem] p-5 bg-white shadow-sm">
                        <div class="flex justify-between items-center gap-4">
                            <div>
                                <p class="font-semibold text-[#2d1a11]">Order #{{ $order->id }}</p>
                                <p class="text-sm text-[#7b5a4b]">Status: {{ ucfirst($order->status) }}</p>
                            </div>
                            <a href="{{ route('orders.show', $order) }}" class="inline-flex items-center rounded-full bg-[#d76f49] px-4 py-2 text-sm font-semibold text-white shadow-sm hover:bg-[#e9896d] transition">View</a>
                        </div>
                        <div class="mt-4 grid gap-4">
                            @foreach($order->items as $item)
                                <div class="rounded-[1.5rem] bg-[#fff4eb] border border-[#ffe0d0] p-4">
                                    <div class="flex justify-between gap-4">
                                        <div>
                                            <p class="font-medium text-[#2d1a11]">{{ $item->product->name }}</p>
                                            <p class="text-sm text-[#7b5a4b]">Quantity: {{ $item->quantity }}</p>
                                            @if($item->size)
                                                <p class="text-sm text-[#7b5a4b]">Size: <span class="font-semibold">{{ $item->size }}</span></p>
                                            @endif
                                        </div>
                                        <p class="font-semibold text-[#d76f49]">₱{{ number_format($item->total, 2) }}</p>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                        @php
                            $calculatedTotal = $order->items->sum(fn($item) => $item->price * $item->quantity);
                        @endphp
                        <p class="mt-4 text-right text-[#2d1a11] font-semibold">Total: ₱{{ number_format($calculatedTotal, 2) }}</p>
                    </div>
                @empty
                    <p class="text-[#7b5a4b]">You have not placed any orders yet.</p>
                @endforelse

                <div class="mt-6">
                    {{ $orders->links() }}
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
