<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center justify-between">
            <h2 class="font-semibold text-xl text-[#d76f49] leading-tight">{{ __('Manage Products') }}</h2>
            <a href="{{ route('seller.products.create') }}" class="inline-flex items-center px-4 py-2 bg-gradient-to-r from-[#d76f49] to-[#e9896d] text-white rounded-lg hover:shadow-lg transition font-semibold">
                <svg class="h-5 w-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path>
                </svg>
                {{ __('Add Product') }}
            </a>
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-[#111b26] overflow-hidden shadow-sm sm:rounded-3xl p-6 border border-[#2c3e50]">
                @if(session('success'))
                    <div class="mb-4 p-4 text-[#1e4629] bg-[#d9fae1] rounded-2xl">{{ session('success') }}</div>
                @endif

                @forelse($products as $product)
                    @if($loop->first)
                        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                    @endif
                    
                    <div class="bg-[#17212c] border border-[#2c3e50] rounded-3xl overflow-hidden hover:shadow-2xl transition duration-300">
                        <!-- Product Image -->
                        <div class="relative product-image-frame h-44">
                            @if($product->image)
                                <img src="{{ asset('storage/' . $product->image) }}" alt="{{ $product->name }}" class="w-full h-full object-contain hover:scale-105 transition duration-300">
                            @else
                                <div class="text-[#9ca3af] text-center">
                                    <svg class="mx-auto h-12 w-12" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                                    </svg>
                                    <p class="text-sm mt-2">No image</p>
                                </div>
                            @endif
                        </div>

                        <!-- Product Details -->
                        <div class="p-5">
                            <h3 class="font-bold text-xl text-black truncate">{{ $product->name }}</h3>
                            <p class="text-[#cfd8e3] text-sm mt-3 line-clamp-2">{{ Str::limit($product->description, 80) }}</p>
                            <div class="flex items-center justify-between mt-5 border-t border-[#2c3e50] pt-4">
                                <div>
                                    <p class="text-[#8b9bb0] text-xs uppercase font-semibold">Price</p>
                                    <p class="text-2xl font-bold text-[#d76f49]">₱{{ number_format($product->price, 2) }}</p>
                                </div>
                                <div>
                                    <p class="text-[#8b9bb0] text-xs uppercase font-semibold">Stock</p>
                                    <p class="text-2xl font-bold text-black">{{ $product->stock }}</p>
                                </div>
                            </div>

                            <!-- Actions -->
                            <div class="flex gap-3 mt-5">
                                <a href="{{ route('seller.products.edit', $product) }}" class="flex-1 text-center px-4 py-2 bg-[#d76f49] text-white rounded-2xl hover:bg-[#e9896d] transition font-semibold text-sm">
                                    Edit
                                </a>
                                <form action="{{ route('seller.products.destroy', $product) }}" method="POST" class="flex-1" onsubmit="return confirm('Are you sure you want to delete this product?');">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="w-full px-4 py-2 bg-[#1f2d3b] text-[#ff7b7b] border border-[#ff7b7b]/20 rounded-2xl hover:bg-[#2a3b4c] transition font-semibold text-sm">
                                        Delete
                                    </button>
                                </form>
                            </div>
                        </div>
                    </div>

                    @if($loop->last)
                        </div>
                    @endif
                @empty
                    <div class="text-center py-8">
                        <p class="text-[#cfd8e3]">No products yet. Start by adding your first product!</p>
                        <a href="{{ route('seller.products.create') }}" class="mt-4 inline-flex items-center px-4 py-2 bg-gradient-to-r from-[#d76f49] to-[#e9896d] text-white rounded-lg hover:shadow-lg transition font-semibold">
                            <svg class="h-5 w-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path>
                            </svg>
                            Add Your First Product
                        </a>
                    </div>
                @endforelse

                @if($products->hasPages())
                    <div class="mt-6">
                        {{ $products->links() }}
                    </div>
                @endif
            </div>
        </div>
    </div>
</x-app-layout>
