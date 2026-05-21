<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-[#d76f49] leading-tight">{{ __('Add Product') }}</h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-gradient-to-br from-[#2c3e50] to-[#34495e] overflow-hidden shadow-lg rounded-2xl p-8">
                <h1 class="text-2xl font-bold text-white mb-6">{{ __('Add Product') }}</h1>
                <form action="{{ route('seller.products.store') }}" method="POST" enctype="multipart/form-data" class="space-y-6">
                    @csrf

                    <!-- Top Row: Name and Image -->
                    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
                        <!-- Product Name -->
                        <div class="lg:col-span-1">
                            <label for="name" class="block text-sm font-medium text-black mb-2">{{ __('Product Name') }}</label>
                            <x-text-input id="name" name="name" type="text" class="mt-1 block w-full bg-[#ffe7dd] text-gray-900 placeholder-[#6b7280] rounded-lg border-0 focus:ring-2 focus:ring-[#d76f49]" placeholder="Enter product name" value="{{ old('name') }}" required />
                            <x-input-error :messages="$errors->get('name')" class="mt-2" />
                        </div>

                        <!-- Product Image Upload -->
                        <div class="lg:col-span-2">
                            <label for="image" class="block text-sm font-medium text-black mb-2">{{ __('Product Photo') }}</label>
                            <div class="flex items-center justify-center px-6 py-4 border-2 border-dashed border-[#d76f49] rounded-lg bg-[#2c3e50]">
                                <div class="text-center">
                                    <svg class="mx-auto h-10 w-10 text-[#d76f49]" stroke="currentColor" fill="none" viewBox="0 0 48 48">
                                        <path d="M28 8H12a4 4 0 00-4 4v20m32-12v8m0 0v8a4 4 0 01-4 4H12a4 4 0 01-4-4v-4m32-12l-3.172-3.172a4 4 0 00-5.656 0L28 20M9 20l3.172-3.172a4 4 0 015.656 0L28 28" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" />
                                    </svg>
                                    <div class="flex flex-col text-sm text-[#d76f49] mt-2">
                                        <label for="image" class="relative cursor-pointer font-semibold hover:text-[#e9896d]">
                                            <span>Choose a file</span>
                                            <input id="image" name="image" type="file" class="sr-only" accept="image/jpeg,image/png,image/jpg,image/gif" onchange="displayFileName(this)" />
                                        </label>
                                        <p class="text-xs text-gray-400 mt-1">PNG, JPG, GIF up to 2MB</p>
                                    </div>
                                    <p id="fileName" class="mt-2 text-sm text-gray-400"></p>
                                </div>
                            </div>
                            <x-input-error :messages="$errors->get('image')" class="mt-2" />
                        </div>
                    </div>

                    <!-- Middle Row: Description -->
                    <div>
                        <label for="description" class="block text-sm font-medium text-black mb-2">{{ __('Product Description') }}</label>
                        <textarea id="description" name="description" rows="3" class="mt-1 block w-full bg-[#ffe7dd] text-black placeholder-[#6b7280] rounded-lg border border-[#d76f49]/30 focus:ring-2 focus:ring-[#d76f49] focus:border-transparent" placeholder="Describe your product..." required>{{ old('description') }}</textarea>
                        <x-input-error :messages="$errors->get('description')" class="mt-2" />
                    </div>

                    <!-- Category -->
                    <div>
                        <label for="category" class="block text-sm font-medium text-black mb-2">{{ __('Category') }}</label>
                        <select id="category" name="category" class="mt-1 block w-full bg-[#ffe7dd] text-gray-900 rounded-lg border border-[#d76f49]/30 focus:ring-2 focus:ring-[#d76f49] focus:border-transparent" required>
                            <option value="">Select a category</option>
                            <option value="Apparel" {{ old('category') === 'Apparel' ? 'selected' : '' }}>Apparel</option>
                            <option value="Accessories" {{ old('category') === 'Accessories' ? 'selected' : '' }}>Accessories</option>
                            <option value="Footwear" {{ old('category') === 'Footwear' ? 'selected' : '' }}>Footwear</option>
                            <option value="Beauty & Personal Care" {{ old('category') === 'Beauty & Personal Care' ? 'selected' : '' }}>Beauty & Personal Care</option>
                            <option value="Home Decor & Gifts" {{ old('category') === 'Home Decor & Gifts' ? 'selected' : '' }}>Home Decor & Gifts</option>
                            <option value="Unique Finds" {{ old('category') === 'Unique Finds' ? 'selected' : '' }}>Unique Finds</option>
                        </select>
                        <x-input-error :messages="$errors->get('category')" class="mt-2" />
                    </div>

                    <!-- Sizes Section (for Apparel and Footwear) -->
                    <!-- Apparel Sizes -->
                    <div id="apparelSizes" class="hidden">
                        <label class="block text-sm font-medium text-black mb-3">{{ __('Available Sizes') }}</label>
                        <div class="grid grid-cols-2 md:grid-cols-5 gap-3">
                            @foreach(['XS', 'S', 'M', 'L', 'XL'] as $size)
                                <label class="flex items-center p-3 bg-[#ffe7dd] rounded-lg border border-[#d76f49]/30 cursor-pointer hover:bg-[#ffd4c4] transition">
                                    <input type="checkbox" name="sizes[]" value="{{ $size }}" class="rounded border-[#d76f49] text-[#d76f49] focus:ring-[#d76f49]" {{ in_array($size, old('sizes', [])) ? 'checked' : '' }} />
                                    <span class="ml-2 text-gray-900 font-medium">{{ $size }}</span>
                                </label>
                            @endforeach
                        </div>
                    </div>

                    <!-- Footwear Sizes -->
                    <div id="footwearSizes" class="hidden">
                        <label class="block text-sm font-medium text-black mb-3">{{ __('Available Sizes') }}</label>
                        <div class="grid grid-cols-2 md:grid-cols-8 gap-3">
                            @foreach([36, 37, 38, 39, 40, 41, 42, 43] as $size)
                                <label class="flex items-center p-3 bg-[#ffe7dd] rounded-lg border border-[#d76f49]/30 cursor-pointer hover:bg-[#ffd4c4] transition">
                                    <input type="checkbox" name="sizes[]" value="{{ $size }}" class="rounded border-[#d76f49] text-[#d76f49] focus:ring-[#d76f49]" {{ in_array((string)$size, old('sizes', [])) ? 'checked' : '' }} />
                                    <span class="ml-2 text-gray-900 font-medium">{{ $size }}</span>
                                </label>
                            @endforeach
                        </div>
                    </div>

                    <!-- Bottom Row: Price and Stock -->
                    <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
                        <div>
                            <label for="price" class="block text-sm font-medium text-black mb-2">{{ __('Price (₱)') }}</label>
                            <x-text-input id="price" name="price" type="number" step="0.01" class="mt-1 block w-full bg-[#ffe7dd] text-gray-900 placeholder-[#6b7280] rounded-lg border-0 focus:ring-2 focus:ring-[#d76f49]" placeholder="0.00" value="{{ old('price') }}" required />
                            <x-input-error :messages="$errors->get('price')" class="mt-2" />
                        </div>
                        <div>
                            <label for="stock" class="block text-sm font-medium text-black mb-2">{{ __('Stock Quantity') }}</label>
                            <x-text-input id="stock" name="stock" type="number" class="mt-1 block w-full bg-[#ffe7dd] text-gray-900 placeholder-[#6b7280] rounded-lg border-0 focus:ring-2 focus:ring-[#d76f49]" placeholder="0" value="{{ old('stock', 0) }}" required />
                            <x-input-error :messages="$errors->get('stock')" class="mt-2" />
                        </div>
                    </div>

                    <!-- Action Buttons -->
                    <div class="flex items-center gap-4 pt-4">
                        <button type="submit" class="flex-1 px-6 py-3 bg-gradient-to-r from-[#d76f49] to-[#e9896d] text-white font-bold rounded-lg hover:shadow-lg hover:scale-105 transition">
                            {{ __('Add Product') }}
                        </button>
                        <a href="{{ route('seller.products.index') }}" class="px-6 py-3 border border-[#d76f49] text-[#d76f49] font-semibold rounded-lg hover:bg-[#d76f49] hover:text-white transition">
                            Cancel
                        </a>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <script>
        function displayFileName(input) {
            const fileNameEl = document.getElementById('fileName');
            if (input.files && input.files[0]) {
                fileNameEl.textContent = 'Selected: ' + input.files[0].name;
            } else {
                fileNameEl.textContent = '';
            }
        }

        // Handle size visibility based on category
        document.getElementById('category').addEventListener('change', function() {
            const apparelSizes = document.getElementById('apparelSizes');
            const footwearSizes = document.getElementById('footwearSizes');
            
            // Hide all first
            apparelSizes.classList.add('hidden');
            footwearSizes.classList.add('hidden');
            
            // Clear checkboxes
            document.querySelectorAll('input[name="sizes[]"]').forEach(checkbox => {
                checkbox.checked = false;
            });
            
            // Show based on selection
            if (this.value === 'Apparel') {
                apparelSizes.classList.remove('hidden');
            } else if (this.value === 'Footwear') {
                footwearSizes.classList.remove('hidden');
            }
        });

        // Trigger on page load if category is already selected
        document.addEventListener('DOMContentLoaded', function() {
            document.getElementById('category').dispatchEvent(new Event('change'));
        });
    </script>
</x-app-layout>
