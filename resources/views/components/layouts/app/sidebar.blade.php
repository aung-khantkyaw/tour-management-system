@php($user = auth()->user())
<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    @include('partials.head')
    @livewireStyles
    <script src="https://unpkg.com/alpinejs@3.x.x/dist/cdn.min.js" defer></script>
</head>

<body x-data="{ open:false, userMenu:false }" class="min-h-screen flex bg-gray-50 text-gray-800">

    <!-- Sidebar -->
    <aside
        class="fixed inset-y-0 left-0 w-64 shrink-0 border-r border-gray-200 bg-white/95 backdrop-blur supports-[backdrop-filter]:bg-white/80 flex flex-col transition-transform duration-200 z-40 shadow-sm"
        :class="open ? 'translate-x-0' : '-translate-x-full lg:translate-x-0'">

        <!-- Top / Brand -->
        <div class="h-16 flex items-center gap-2 px-5 border-b border-gray-200">
            <button class="lg:hidden p-2 rounded-md hover:bg-gray-100" @click="open=false" aria-label="Close sidebar">
                <svg class="w-5 h-5 text-gray-500" fill="none" stroke="currentColor" stroke-width="2"
                    viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12" />
                </svg>
            </button>
            <a href="{{ route('admin.dashboard') }}" class="flex items-center gap-2">
                <x-app-logo class="h-8 w-auto" />
            </a>
        </div>

        <!-- Nav -->
        <nav class="flex-1 overflow-y-auto py-6 px-4 space-y-8 text-sm">
            <div>
                <p class="px-2 mb-2 text-[11px] font-semibold uppercase tracking-wide text-gray-500">Platform</p>
                <ul class="space-y-1">
                    <li>
                        <a href="{{ route('admin.dashboard') }}" @class([
                            'group flex items-center gap-2 rounded-md px-3 py-2 font-medium transition',
                            request()->routeIs('admin.dashboard')
                            ? 'bg-blue-600 text-white shadow ring-1 ring-blue-500/60'
                            : 'text-gray-700 hover:bg-blue-50 hover:text-blue-700'
                        ])>
                            <svg class="w-4 h-4"
                                :class="{'text-white': {{ request()->routeIs('admin.dashboard') ? 'true' : 'false' }}, 'text-blue-500 group-hover:text-blue-600': {{ request()->routeIs('admin.dashboard') ? 'false' : 'true' }}}"
                                fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round"
                                    d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0h6" />
                            </svg>
                            <span>Dashboard</span>
                        </a>
                    </li>
                </ul>
            </div>

            <div>
                <p class="px-2 mb-2 text-[11px] font-semibold uppercase tracking-wide text-gray-500">Tour Management</p>
                <ul class="space-y-1">
                    <li>
                        <a href="{{ route('admin.destinations.index') }}" @class([
                            'group flex items-center gap-2 rounded-md px-3 py-2 font-medium transition',
                            request()->routeIs('admin.destinations.*')
                            ? 'bg-blue-600 text-white shadow ring-1 ring-blue-500/60'
                            : 'text-gray-700 hover:bg-blue-50 hover:text-blue-700'
                        ])>
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round"
                                    d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z" />
                                <path stroke-linecap="round" stroke-linejoin="round"
                                    d="M15 11a3 3 0 11-6 0 3 3 0 016 0z" />
                            </svg>
                            <span>Destinations</span>
                        </a>
                    </li>
                    <li>
                        <a href="{{ route('admin.packages.index') }}" @class([
                            'group flex items-center gap-2 rounded-md px-3 py-2 font-medium transition',
                            request()->routeIs('admin.packages.*')
                            ? 'bg-blue-600 text-white shadow ring-1 ring-blue-500/60'
                            : 'text-gray-700 hover:bg-blue-50 hover:text-blue-700'
                        ])>
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round"
                                    d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M9 10l3-3 3 3" />
                            </svg>
                            <span>Packages</span>
                        </a>
                    </li>
                    <li>
                        <a href="{{ route('admin.schedules.index') }}" @class([
                            'group flex items-center gap-2 rounded-md px-3 py-2 font-medium transition',
                            request()->routeIs('admin.schedules.*')
                            ? 'bg-blue-600 text-white shadow ring-1 ring-blue-500/60'
                            : 'text-gray-700 hover:bg-blue-50 hover:text-blue-700'
                        ])>
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round"
                                    d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" />
                            </svg>
                            <span>Schedules</span>
                        </a>
                    </li>
                    <li>
                        <a href="{{ route('admin.bookings.index') }}" @class([
                            'group flex items-center gap-2 rounded-md px-3 py-2 font-medium transition',
                            request()->routeIs('admin.bookings.*')
                            ? 'bg-blue-600 text-white shadow ring-1 ring-blue-500/60'
                            : 'text-gray-700 hover:bg-blue-50 hover:text-blue-700'
                        ])>
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round"
                                    d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2" />
                            </svg>
                            <span>Bookings</span>
                        </a>
                    </li>
                    <li>
                        <a href="{{ route('admin.hotels.index') }}" @class([
                            'group flex items-center gap-2 rounded-md px-3 py-2 font-medium transition',
                            request()->routeIs('admin.hotels.*')
                            ? 'bg-blue-600 text-white shadow ring-1 ring-blue-500/60'
                            : 'text-gray-700 hover:bg-blue-50 hover:text-blue-700'
                        ])>
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round"
                                    d="M3 21v-4m0 0V5a2 2 0 012-2h6.5l1 1H21l-3 6 3 6h-8.5l-1-1H5a2 2 0 00-2 2zm9-13.5V9" />
                            </svg>
                            <span>Hotels</span>
                        </a>
                    </li>
                    <li>
                        <a href="{{ route('admin.accommodations.index') }}" @class([
                            'group flex items-center gap-2 rounded-md px-3 py-2 font-medium transition',
                            request()->routeIs('admin.accommodations.*')
                            ? 'bg-blue-600 text-white shadow ring-1 ring-blue-500/60'
                            : 'text-gray-700 hover:bg-blue-50 hover:text-blue-700'
                        ])>
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round"
                                    d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4" />
                            </svg>
                            <span>Accommodations</span>
                        </a>
                    </li>
                    <li>
                        <a href="{{ route('admin.guides.index') }}" @class([
                            'group flex items-center gap-2 rounded-md px-3 py-2 font-medium transition',
                            request()->routeIs('admin.guides.*')
                            ? 'bg-blue-600 text-white shadow ring-1 ring-blue-500/60'
                            : 'text-gray-700 hover:bg-blue-50 hover:text-blue-700'
                        ])>
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round"
                                    d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" />
                            </svg>
                            <span>Tour Guides</span>
                        </a>
                    </li>
                </ul>
            </div>
        </nav>

        <!-- User / Footer -->
        <div class="relative border-t border-gray-200 p-4 bg-gradient-to-t from-gray-50 to-white">
            <button @click="userMenu = !userMenu"
                class="w-full flex items-center gap-3 rounded-md px-3 py-2 hover:bg-gray-100 transition text-left">
                <div
                    class="w-9 h-9 rounded-lg bg-blue-100 text-blue-700 flex items-center justify-center font-semibold text-sm">
                    {{ $user?->initials() ?? 'U' }}
                </div>
                <div class="flex-1">
                    <p class="text-sm font-semibold truncate text-gray-800">{{ $user?->name ?? 'User' }}</p>
                    <p class="text-xs text-gray-500 truncate">{{ $user?->email }}</p>
                </div>
                <svg class="w-4 h-4 text-gray-500 transition-transform" :class="userMenu ? 'rotate-180' : ''"
                    fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" d="m6 9 6 6 6-6" />
                </svg>
            </button>

            <!-- Upward dropdown -->
            <div x-cloak x-show="userMenu" x-transition.origin-bottom @click.outside="userMenu=false"
                class="absolute bottom-[calc(100%+0.75rem)] left-4 right-4 z-50 rounded-md border border-gray-200 bg-white shadow-lg divide-y divide-gray-200 overflow-hidden">
                <a href="{{ route('settings.profile') }}" class="block px-4 py-2 text-sm hover:bg-gray-50">Settings</a>
                <form method="POST" action="{{ route('logout') }}">
                    @csrf
                    <button type="submit" class="w-full text-left px-4 py-2 text-sm hover:bg-gray-50">
                        Log Out
                    </button>
                </form>
            </div>
        </div>
    </aside>

    <!-- Mobile top bar -->
    <header
        class="lg:hidden h-14 flex items-center gap-3 px-4 border-b border-gray-200 bg-white/90 backdrop-blur supports-[backdrop-filter]:bg-white/70 w-full fixed top-0 left-0 z-30 shadow-sm">
        <button @click="open = true" class="p-2 rounded-md hover:bg-gray-100" aria-label="Open sidebar">
            <svg class="w-5 h-5 text-gray-600" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" d="M4 6h16M4 12h16M4 18h16" />
            </svg>
        </button>
        <span class="font-semibold text-sm text-gray-700">Menu</span>
        <div class="ml-auto flex items-center gap-3">
            <div
                class="w-8 h-8 rounded-lg bg-blue-100 text-blue-700 flex items-center justify-center text-xs font-semibold">
                {{ $user?->initials() ?? 'U' }}
            </div>
        </div>
    </header>

    <!-- Main content wrapper -->
    <main class="flex-1 w-full lg:pl-64 pt-14 lg:pt-0">
        {{ $slot }}
    </main>
    @livewireScripts
</body>

</html>