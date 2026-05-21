<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-[#d76f49] leading-tight">{{ __('Seller Orders') }}</h2>
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
                                <p class="text-sm text-[#7b5a4b]">Buyer: {{ $order->user->name }}</p>
                            </div>
                            <a href="{{ route('seller.orders.show', $order) }}" class="inline-flex items-center rounded-full bg-[#d76f49] px-4 py-2 text-sm font-semibold text-white shadow-sm hover:bg-[#e9896d] transition">Details</a>
                        </div>
                        <p class="mt-2 text-[#7b5a4b]">Status: {{ ucfirst($order->status) }}</p>
                    </div>
                @empty
                    <p class="text-[#7b5a4b]">No orders for your products yet.</p>
                @endforelse

                <div class="mt-6">
                    {{ $orders->links() }}
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
