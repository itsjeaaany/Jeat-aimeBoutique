<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>{{ config('app.name', 'Laravel') }}</title>

        <!-- Fonts -->
        <link rel="preconnect" href="https://fonts.bunny.net">
        <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />

        <!-- Scripts -->
        @vite(['resources/css/app.css', 'resources/js/app.js'])
    </head>
    <body class="font-sans text-gray-900 antialiased">
        <div class="min-h-screen flex flex-col sm:justify-center items-center pt-6 sm:pt-0 bg-gradient-to-br from-[#fff0e8] via-white to-[#ffe7dd]">
            <!-- Decorative Elements -->
            <div class="absolute inset-0 overflow-hidden pointer-events-none">
                <div class="absolute top-0 right-0 w-96 h-96 bg-[#f7b7a1] rounded-full mix-blend-multiply filter blur-3xl opacity-10 animate-blob"></div>
                <div class="absolute -bottom-8 left-20 w-96 h-96 bg-[#d76f49] rounded-full mix-blend-multiply filter blur-3xl opacity-10 animate-blob animation-delay-2000"></div>
                <div class="absolute top-1/2 left-1/2 w-96 h-96 bg-[#e9896d] rounded-full mix-blend-multiply filter blur-3xl opacity-10 animate-blob animation-delay-4000"></div>
            </div>

            <!-- Logo and Branding -->
            <div class="relative z-10 mb-8">
                <a href="/" class="flex flex-col items-center gap-3">
                    <div class="relative">
                        <div class="absolute inset-0 bg-gradient-to-r from-[#f7b7a1] to-[#e9896d] rounded-full blur-lg opacity-50"></div>
                        <x-application-logo class="relative w-20 h-20 fill-current text-[#d76f49]" />
                    </div>
                    <span class="text-2xl font-bold bg-gradient-to-r from-[#d76f49] to-[#e9896d] bg-clip-text text-transparent">Jeat'aime</span>
                </a>
            </div>

            <!-- Main Card -->
            <div class="relative z-10 w-full sm:max-w-md mt-6 px-6 py-8 bg-white drop-shadow-lg overflow-hidden rounded-3xl">
                <!-- Card Top Accent Bar -->
                <div class="absolute top-0 left-0 right-0 h-1 bg-gradient-to-r from-[#f7b7a1] via-[#e9896d] to-[#d76f49]"></div>

                {{ $slot }}

                <!-- Footer Links -->
                <div class="mt-6 pt-6 border-t border-[#ffe7dd] text-center text-xs text-gray-500">
                    <p>Jeat'aime Boutique - Your Trusted Marketplace</p>
                </div>
            </div>
        </div>

        <style>
            @keyframes blob {
                0%, 100% { transform: translate(0, 0) scale(1); }
                33% { transform: translate(30px, -50px) scale(1.1); }
                66% { transform: translate(-20px, 20px) scale(0.9); }
            }
            .animate-blob {
                animation: blob 7s infinite;
            }
            .animation-delay-2000 {
                animation-delay: 2s;
            }
            .animation-delay-4000 {
                animation-delay: 4s;
            }
        </style>
    </body>
</html>
