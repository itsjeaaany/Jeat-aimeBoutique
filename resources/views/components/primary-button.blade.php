<button {{ $attributes->merge(['type' => 'submit', 'class' => 'inline-flex w-full items-center justify-center rounded-xl bg-gradient-to-r from-[#f7b7a1] to-[#e9896d] px-6 py-3 font-semibold text-white shadow-lg shadow-[#f7b7a1]/30 transition duration-200 hover:shadow-xl hover:shadow-[#e9896d]/40 active:scale-95 focus:outline-none focus:ring-4 focus:ring-[#f7b7a1]/30']) }}>
    {{ $slot }}
</button>
