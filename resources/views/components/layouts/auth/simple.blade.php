<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    @include('partials.head')
</head>

<body class="min-h-screen antialiased bg-white">
    <div class="auth-bg min-h-screen flex items-center justify-center p-6">
        <!-- Content Container -->
        <div class="relative z-10 w-full max-w-lg">
            <!-- Logo/Brand -->
            <div class="text-center mb-8">
                <a href="{{ route('welcome') }}" class="inline-block" wire:navigate>
                    <h1 class="text-4xl font-bold text-gray-900 mb-2">{{ config('app.name', 'Tour Management') }}</h1>
                    <p class="text-gray-600 text-sm">Your Gateway to Amazing Adventures</p>
                </a>
            </div>

            <!-- Auth Content -->
            <div class="relative">
                {{ $slot }}
            </div>
        </div>
    </div>
    @fluxScripts
</body>

</html>