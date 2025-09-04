@php($user = auth()->user())
<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    @include('partials.head')
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
            <a href="{{ route('dashboard') }}" class="flex items-center gap-2">
                <x-app-logo class="h-8 w-auto" />
            </a>
        </div>

        <!-- Nav -->
        <nav class="flex-1 overflow-y-auto py-6 px-4 space-y-8 text-sm">
            <div>
                <p class="px-2 mb-2 text-[11px] font-semibold uppercase tracking-wide text-gray-500">Platform</p>
                <ul class="space-y-1">
                    <li>
                        <a href="{{ route('dashboard') }}" @class([
                            'group flex items-center gap-2 rounded-md px-3 py-2 font-medium transition',
                            request()->routeIs('dashboard')
                            ? 'bg-blue-600 text-white shadow ring-1 ring-blue-500/60'
                            : 'text-gray-700 hover:bg-blue-50 hover:text-blue-700'
                        ])>
                            <svg class="w-4 h-4"
                                :class="{'text-white': {{ request()->routeIs('dashboard') ? 'true' : 'false' }}, 'text-blue-500 group-hover:text-blue-600': {{ request()->routeIs('dashboard') ? 'false' : 'true' }}}"
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
                <p class="px-2 mb-2 text-[11px] font-semibold uppercase tracking-wide text-gray-500">Resources</p>
                <ul class="space-y-1">
                    <li>
                        <a href="https://github.com/laravel/livewire-starter-kit" target="_blank"
                            class="flex items-center gap-2 rounded-md px-3 py-2 text-gray-700 hover:bg-blue-50 hover:text-blue-700 transition">
                            <svg class="w-4 h-4 text-gray-500 group-hover:text-blue-600" fill="currentColor"
                                viewBox="0 0 24 24">
                                <path
                                    d="M12 .5C5.37.5 0 5.87 0 12.55c0 5.3 3.44 9.79 8.2 11.38.6.12.82-.27.82-.58 0-.28-.01-1.03-.02-2.02-3.34.74-4.04-1.65-4.04-1.65-.55-1.42-1.34-1.8-1.34-1.8-1.1-.78.08-.76.08-.76 1.22.09 1.87 1.28 1.87 1.28 1.08 1.9 2.83 1.35 3.52 1.03.11-.8.42-1.35.76-1.66-2.67-.31-5.47-1.37-5.47-6.1 0-1.35.47-2.45 1.24-3.31-.12-.31-.54-1.56.12-3.25 0 0 1.01-.33 3.3 1.26a11.1 11.1 0 0 1 3-.42c1.02 0 2.05.14 3 .42 2.28-1.59 3.29-1.26 3.29-1.26.66 1.69.24 2.94.12 3.25.77.86 1.23 1.96 1.23 3.31 0 4.74-2.81 5.78-5.49 6.09.43.38.81 1.11.81 2.24 0 1.62-.02 2.93-.02 3.33 0 .32.22.71.82.58A11.56 11.56 0 0 0 24 12.55C24 5.87 18.63.5 12 .5Z" />
                            </svg>
                            <span>Repository</span>
                        </a>
                    </li>
                    <li>
                        <a href="https://laravel.com/docs" target="_blank"
                            class="flex items-center gap-2 rounded-md px-3 py-2 text-gray-700 hover:bg-blue-50 hover:text-blue-700 transition">
                            <svg class="w-4 h-4 text-gray-500 group-hover:text-blue-600" fill="none"
                                stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round"
                                    d="M12 6v6l4 2m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                            </svg>
                            <span>Documentation</span>
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
</body>

</html>