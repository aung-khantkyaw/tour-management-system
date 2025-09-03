<!DOCTYPE html>
<html lang="en">

<head>
    @include('partials.head')
</head>

<body class="min-h-screen bg-gray-50 antialiased flex flex-col">
    <header
        class="sticky top-0 z-40 bg-white/90 backdrop-blur supports-[backdrop-filter]:bg-white/80 border-b border-gray-200">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 h-16 flex items-center gap-6">
            <a href="{{ route('welcome') }}" class="flex items-center space-x-2" wire:navigate>
                <x-app-logo class="h-8 w-auto" />
            </a>
            <nav class="hidden md:flex items-center gap-1 text-sm font-medium">
                @php($links = [
                    ['route' => 'welcome', 'label' => 'Home'],
                    ['route' => 'about', 'label' => 'About Us'],
                    ['route' => 'destinations', 'label' => 'Destinations'],
                    ['route' => 'packages', 'label' => 'Packages'],
                    ['route' => 'history', 'label' => 'History'],
                ])
                @foreach($links as $l)
                @php($active = request()->routeIs($l['route']))
                <a href="{{ route($l['route']) }}" wire:navigate aria-current="{{ $active ? 'page' : 'false' }}" class="rounded-full px-4 py-2 transition-colors relative focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-blue-500/50 {{ $active
        ? 'bg-blue-600 text-white shadow-sm'
        : 'text-gray-600 hover:bg-gray-100 hover:text-gray-900' }}">
                    {{ $l['label'] }}
                </a>
                @endforeach
            </nav>
            <div class="md:hidden ml-auto" x-data="{open:false}">
                <button type="button" @click="open=!open" :aria-expanded="open.toString()"
                    aria-label="Toggle navigation"
                    class="inline-flex items-center justify-center h-9 w-9 rounded-md border border-gray-300 text-gray-600 hover:bg-gray-100">
                    <svg x-show="!open" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" stroke="currentColor"
                        fill="none" class="h-5 w-5">
                        <path stroke-width="2" stroke-linecap="round" stroke-linejoin="round"
                            d="M4 6h16M4 12h16M4 18h16" />
                    </svg>
                    <svg x-show="open" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" stroke="currentColor"
                        fill="none" class="h-5 w-5">
                        <path stroke-width="2" stroke-linecap="round" stroke-linejoin="round"
                            d="M6 18L18 6M6 6l12 12" />
                    </svg>
                </button>
                <div x-show="open" x-transition.origin.top.right x-cloak @click.outside="open=false"
                    class="absolute right-4 top-16 w-56 rounded-lg border border-gray-200 bg-white shadow-lg p-3 space-y-1">
                    @foreach($links as $l)
                    @php($active = request()->routeIs($l['route']))
                    <a href="{{ route($l['route']) }}" wire:navigate @click="open=false" class="block rounded-md px-3 py-2 text-sm {{ $active
        ? 'bg-blue-600 text-white'
        : 'text-gray-700 hover:bg-gray-100' }}">{{ $l['label'] }}</a>
                    @endforeach
                    @auth
                    @php($active = request()->routeIs('dashboard'))
                    <a href="{{ route('dashboard') }}" wire:navigate @click="open=false" class="block rounded-md px-3 py-2 text-sm {{ $active
        ? 'bg-blue-600 text-white'
        : 'text-gray-700 hover:bg-gray-100' }}">Dashboard</a>
                    @endauth
                </div>
            </div>
            <div class="flex items-center gap-3 ml-auto">
                @auth
                @php($user = auth()->user())
                @php($isAdmin = isset($user->is_admin) ? (bool) $user->is_admin : (isset($user->role) && $user->role === 'admin'))
                @php($initial = strtoupper(substr(trim($user->name ?? $user->email), 0, 1)))

                    <!-- Avatar -->
                    <div
                        class="h-9 w-9 rounded-full bg-blue-100 text-blue-700 flex items-center justify-center font-semibold text-sm select-none">
                        {{ $initial }}
                    </div>

                    @if($isAdmin)
                        <!-- Admin: show Dashboard button -->
                        <a href="{{ route('dashboard') }}" wire:navigate
                            class="inline-flex items-center rounded-md bg-blue-600 px-4 py-2 text-sm font-medium text-white shadow hover:bg-blue-500 transition focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-blue-500/50">
                            Dashboard
                        </a>
                    @else
                        <!-- Non‑admin: show Logout button -->
                        <form method="POST" action="{{ route('logout') }}">
                            @csrf
                            <button type="submit"
                                class="inline-flex items-center rounded-md border border-gray-300 bg-white px-4 py-2 text-sm font-medium text-gray-700 shadow-sm hover:bg-gray-100 transition focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-blue-500/40">
                                Logout
                            </button>
                        </form>
                    @endif
                @else
                <a href="{{ route('login') }}" wire:navigate
                    class="inline-flex items-center rounded-md border border-gray-300 bg-white px-4 py-2 text-sm font-medium text-gray-700 shadow-sm hover:bg-gray-100 transition focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-blue-500/40">
                    Login
                </a>
                @if (Route::has('register'))
                    <a href="{{ route('register') }}" wire:navigate
                        class="inline-flex items-center rounded-md bg-blue-600 px-4 py-2 text-sm font-medium text-white shadow hover:bg-blue-500 transition focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-blue-500/50">
                        Register
                    </a>
                @endif
                @endauth
            </div>
        </div>
    </header>

    <main class="flex-1">
        {{ $slot }}
    </main>

    <footer class="mt-16 bg-white border-t border-gray-200 text-gray-600">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-14">
            <div class="grid gap-10 md:grid-cols-4">
                <div class="space-y-4 md:col-span-2">
                    <div class="flex items-center space-x-2">
                        <x-app-logo class="h-9 w-auto" />
                    </div>
                    <p class="text-sm leading-relaxed max-w-md">
                        A simple tour management demo showcasing destinations, schedules and essential travel
                        information with a clean, fast interface.
                    </p>
                    <div class="flex items-center gap-3 pt-2">
                        <a href="#" aria-label="Twitter"
                            class="h-9 w-9 flex items-center justify-center rounded-full border border-gray-200 bg-white hover:bg-gray-50 text-gray-500 hover:text-gray-700 transition">
                            <svg viewBox="0 0 24 24" fill="currentColor" class="h-4 w-4">
                                <path
                                    d="M22 5.92c-.77.35-1.6.58-2.46.69a4.19 4.19 0 0 0 1.84-2.31 8.32 8.32 0 0 1-2.64 1.02A4.14 4.14 0 0 0 16.3 4c-2.3 0-4.17 1.9-4.17 4.24 0 .33.03.65.1.96A11.75 11.75 0 0 1 3.15 4.6a4.32 4.32 0 0 0-.56 2.13 4.27 4.27 0 0 0 1.85 3.53 4.07 4.07 0 0 1-1.88-.53v.05c0 2.04 1.42 3.74 3.3 4.13-.35.1-.72.15-1.1.15-.27 0-.53-.03-.78-.08.53 1.7 2.06 2.94 3.88 2.97A8.32 8.32 0 0 1 2 19.54 11.73 11.73 0 0 0 8.29 21.4c7.55 0 11.68-6.38 11.68-11.91 0-.18-.01-.35-.02-.53A8.5 8.5 0 0 0 22 5.92Z" />
                            </svg>
                        </a>
                        <a href="#" aria-label="Facebook"
                            class="h-9 w-9 flex items-center justify-center rounded-full border border-gray-200 bg-white hover:bg-gray-50 text-gray-500 hover:text-gray-700 transition">
                            <svg viewBox="0 0 24 24" fill="currentColor" class="h-4 w-4">
                                <path
                                    d="M13.5 9H16l.5-3h-3V4.5c0-.9.2-1.5 1.5-1.5H16V0h-2.1C11.4 0 10 1.3 10 3.6V6H7v3h3v9h3.5V9Z" />
                            </svg>
                        </a>
                        <a href="#" aria-label="GitHub"
                            class="h-9 w-9 flex items-center justify-center rounded-full border border-gray-200 bg-white hover:bg-gray-50 text-gray-500 hover:text-gray-700 transition">
                            <svg viewBox="0 0 24 24" fill="currentColor" class="h-4 w-4">
                                <path fill-rule="evenodd"
                                    d="M12 0C5.37 0 0 5.42 0 12.11c0 5.35 3.44 9.88 8.2 11.49.6.12.82-.27.82-.58 0-.29-.01-1.05-.02-2.05-3.34.74-4.04-1.63-4.04-1.63-.55-1.42-1.34-1.8-1.34-1.8-1.1-.77.08-.76.08-.76 1.22.09 1.86 1.27 1.86 1.27 1.08 1.88 2.83 1.34 3.52 1.03.11-.8.42-1.34.77-1.65-2.67-.31-5.47-1.37-5.47-6.11 0-1.35.46-2.45 1.23-3.31-.12-.31-.53-1.56.12-3.26 0 0 1-.33 3.3 1.26a11.1 11.1 0 0 1 3-.41c1.02 0 2.05.14 3 .41 2.3-1.59 3.29-1.26 3.29-1.26.66 1.7.25 2.95.13 3.26.77.86 1.23 1.96 1.23 3.31 0 4.76-2.8 5.79-5.48 6.1.43.38.81 1.11.81 2.25 0 1.62-.01 2.92-.01 3.32 0 .32.22.71.83.58A12.04 12.04 0 0 0 24 12.11C24 5.42 18.63 0 12 0Z"
                                    clip-rule="evenodd" />
                            </svg>
                        </a>
                    </div>
                </div>

                <div class="space-y-4 text-sm">
                    <h3 class="text-gray-900 font-semibold tracking-wide">Quick Links</h3>
                    <ul class="space-y-2">
                        <li><a href="{{ route('welcome') }}" wire:navigate
                                class="hover:text-gray-900 transition">Home</a></li>
                        <li><a href="{{ route('about') }}" wire:navigate
                                class="hover:text-gray-900 transition">About</a></li>
                        <li><a href="{{ route('destinations') }}" wire:navigate
                                class="hover:text-gray-900 transition">Destinations</a></li>
                        <li><a href="{{ route('packages') }}" wire:navigate
                                class="hover:text-gray-900 transition">Packages</a></li>
                        <li><a href="{{ route('history') }}" wire:navigate
                                class="hover:text-gray-900 transition">History</a></li>
                        @auth
                            <li><a href="{{ route('dashboard') }}" wire:navigate
                                    class="hover:text-gray-900 transition">Dashboard</a></li>
                        @else
                            <li><a href="{{ route('login') }}" wire:navigate
                                    class="hover:text-gray-900 transition">Login</a></li>
                        @endauth
                    </ul>
                </div>

                <div class="space-y-4 text-sm">
                    <h3 class="text-gray-900 font-semibold tracking-wide">Contact</h3>
                    <ul class="space-y-2">
                        <li>Email: <span class="text-gray-500">info@example.com</span></li>
                        <li>Phone: <span class="text-gray-500">+95 123 456 789</span></li>
                        <li>Hours: <span class="text-gray-500">Mon–Fri 9am-5pm</span></li>
                    </ul>
                </div>
            </div>
            <div
                class="mt-12 pt-6 border-t border-gray-200 flex flex-col md:flex-row items-center justify-between gap-4 text-xs text-gray-500">
                <p>&copy; {{ date('Y') }} {{ config('app.name') }}. All rights reserved.</p>
                <p class="flex items-center gap-1">Built with <span class="text-red-500">❤</span> Laravel & Tailwind</p>
            </div>
        </div>
    </footer>
</body>

</html>