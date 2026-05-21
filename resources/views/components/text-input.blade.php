@props(['disabled' => false])

<input @disabled($disabled) {{ $attributes->merge(['class' => 'w-full rounded-xl border-2 border-[#ffd6c8] bg-[#fff0e8] px-4 py-3 font-medium text-gray-900 placeholder-gray-400 transition duration-200 focus:border-[#f7b7a1] focus:outline-none focus:ring-4 focus:ring-[#f7b7a1]/20']) }}>
