<x-layouts.app.sidebar>
    <div class="min-h-screen bg-gradient-to-br from-slate-50 to-green-50">
        <div class="p-6 lg:p-8 space-y-8" x-data="{ searchQuery: '' }">
            @if (session('success'))
                <div class="bg-emerald-50 border-l-4 border-emerald-400 text-emerald-700 px-6 py-4 rounded-r-lg shadow-sm"
                    role="alert">
                    <div class="flex items-center">
                        <svg class="w-5 h-5 mr-3" fill="currentColor" viewBox="0 0 20 20">
                            <path fill-rule="evenodd"
                                d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z"
                                clip-rule="evenodd" />
                        </svg>
                        <span class="font-medium">{{ session('success') }}</span>
                    </div>
                </div>
            @endif
            @if (session('error'))
                <div class="bg-red-50 border-l-4 border-red-400 text-red-700 px-6 py-4 rounded-r-lg shadow-sm" role="alert">
                    <div class="flex items-center">
                        <svg class="w-5 h-5 mr-3" fill="currentColor" viewBox="0 0 20 20">
                            <path fill-rule="evenodd"
                                d="M10 18a8 8 0 100-16 8 8 0 000 16zM8.707 7.293a1 1 0 00-1.414 1.414L8.586 10l-1.293 1.293a1 1 0 101.414 1.414L10 11.414l1.293 1.293a1 1 0 001.414-1.414L11.414 10l1.293-1.293a1 1 0 00-1.414-1.414L10 8.586 8.707 7.293z"
                                clip-rule="evenodd" />
                        </svg>
                        <span class="font-medium">{{ session('error') }}</span>
                    </div>
                </div>
            @endif

            <!-- Enhanced Header -->
            <div class="bg-white rounded-2xl shadow-lg border border-gray-100 p-8">
                <div class="flex flex-col lg:flex-row lg:items-center lg:justify-between gap-6">
                    <div class="space-y-2">
                        <div class="flex items-center gap-3">
                            <div class="p-3 bg-gradient-to-r from-green-500 to-emerald-600 rounded-xl">
                                <svg class="w-8 h-8 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" />
                                </svg>
                            </div>
                            <div>
                                <h1
                                    class="text-3xl font-bold bg-gradient-to-r from-gray-900 to-gray-700 bg-clip-text text-transparent">
                                    Schedules Management</h1>
                                <p class="text-gray-600 font-medium">Manage and oversee all tour schedules</p>
                            </div>
                        </div>
                    </div>
                    <div class="flex flex-col sm:flex-row gap-4 w-full lg:w-auto">
                        <div class="relative flex-1 min-w-[280px]">
                            <input type="search" x-model.debounce.200ms="searchQuery"
                                placeholder="Search schedules, packages, or dates..."
                                class="w-full rounded-xl border-2 border-gray-200 pl-12 pr-4 py-3 text-sm focus:outline-none focus:ring-2 focus:ring-green-500 focus:border-green-500 transition-all duration-200 bg-gray-50 hover:bg-white"
                                aria-label="Search schedules" />
                            <span class="absolute left-4 inset-y-0 flex items-center text-gray-400">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M21 21l-4.35-4.35M10 18a8 8 0 100-16 8 8 0 000 16z" />
                                </svg>
                            </span>
                        </div>
                        <a href="{{ route('admin.schedules.create') }}"
                            class="inline-flex items-center justify-center px-6 py-3 bg-gradient-to-r from-green-600 to-emerald-600 text-white rounded-xl hover:from-green-700 hover:to-emerald-700 transition-all duration-200 shadow-lg hover:shadow-xl transform hover:-translate-y-0.5 font-medium">
                            <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M12 4v16m8-8H3"></path>
                            </svg>
                            Add New Schedule
                        </a>
                    </div>
                </div>
            </div>

            <!-- Enhanced Stats Cards -->
            <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                <div
                    class="bg-white rounded-2xl shadow-lg border border-gray-100 p-6 hover:shadow-xl transition-all duration-300 transform hover:-translate-y-1">
                    <div class="flex items-center justify-between">
                        <div class="flex items-center">
                            <div class="p-4 rounded-2xl bg-gradient-to-r from-green-500 to-green-600 shadow-lg">
                                <svg class="w-7 h-7 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" />
                                </svg>
                            </div>
                            <div class="ml-5">
                                <p class="text-sm font-semibold text-gray-500 uppercase tracking-wide">Total Schedules
                                </p>
                                <p class="text-3xl font-bold text-gray-900 mt-1">{{ $schedules->total() }}</p>
                            </div>
                        </div>
                    </div>
                </div>

                <div
                    class="bg-white rounded-2xl shadow-lg border border-gray-100 p-6 hover:shadow-xl transition-all duration-300 transform hover:-translate-y-1">
                    <div class="flex items-center justify-between">
                        <div class="flex items-center">
                            <div class="p-4 rounded-2xl bg-gradient-to-r from-blue-500 to-blue-600 shadow-lg">
                                <svg class="w-7 h-7 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M9 5H7a2 2 0 00-2 2v10a2 2 0 002 2h8a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2" />
                                </svg>
                            </div>
                            <div class="ml-5">
                                <p class="text-sm font-semibold text-gray-500 uppercase tracking-wide">Total Bookings
                                </p>
                                <p class="text-3xl font-bold text-gray-900 mt-1">{{ $schedules->sum('bookings_count') }}
                                </p>
                            </div>
                        </div>
                    </div>
                </div>

                <div
                    class="bg-white rounded-2xl shadow-lg border border-gray-100 p-6 hover:shadow-xl transition-all duration-300 transform hover:-translate-y-1">
                    <div class="flex items-center justify-between">
                        <div class="flex items-center">
                            <div class="p-4 rounded-2xl bg-gradient-to-r from-purple-500 to-purple-600 shadow-lg">
                                <svg class="w-7 h-7 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" />
                                </svg>
                            </div>
                            <div class="ml-5">
                                <p class="text-sm font-semibold text-gray-500 uppercase tracking-wide">Active Today</p>
                                <p class="text-3xl font-bold text-gray-900 mt-1">
                                    {{ $schedules->where('from_date', '<=', now())->where('to_date', '>=', now())->count() }}
                                </p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Enhanced Schedules Grid -->
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
                @forelse($schedules as $schedule)
                    <div class="bg-white rounded-2xl border border-gray-100 shadow-lg overflow-hidden hover:shadow-2xl hover:border-green-200 transition-all duration-300 transform hover:-translate-y-2 group"
                        x-show="!searchQuery || [$el.dataset.package, $el.dataset.destination].some(v => v && v.toLowerCase().includes(searchQuery.toLowerCase()))"
                        x-cloak data-package="{{ $schedule->touristPackage->package_name ?? '' }}"
                        data-destination="{{ $schedule->touristPackage->destination->destination_name ?? '' }}">

                        <!-- Schedule Header -->
                        <div
                            class="relative h-48 bg-gradient-to-br from-green-100 via-emerald-100 to-teal-100 overflow-hidden">
                            <div class="absolute inset-0 bg-gradient-to-t from-black/20 to-transparent"></div>
                            <div class="flex items-center justify-center h-full text-green-500">
                                <div class="text-center">
                                    <svg class="w-16 h-16 mx-auto mb-2 opacity-60" fill="none" stroke="currentColor"
                                        viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5"
                                            d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" />
                                    </svg>
                                    <p class="text-sm font-medium opacity-60">Tour Schedule</p>
                                </div>
                            </div>

                            <!-- Status Badge -->
                            <div class="absolute top-4 right-4">
                                @php
                                    $isActive = now()->between($schedule->from_date, $schedule->to_date);
                                    $isPast = now()->gt($schedule->to_date);
                                @endphp
                                <span
                                    class="inline-flex items-center px-3 py-1 rounded-full text-xs font-semibold 
                                        {{ $isActive ? 'bg-green-100 text-green-800' : ($isPast ? 'bg-gray-100 text-gray-800' : 'bg-blue-100 text-blue-800') }} shadow-sm">
                                    <span
                                        class="w-2 h-2 {{ $isActive ? 'bg-green-400' : ($isPast ? 'bg-gray-400' : 'bg-blue-400') }} rounded-full mr-2 animate-pulse"></span>
                                    {{ $isActive ? 'Active' : ($isPast ? 'Completed' : 'Upcoming') }}
                                </span>
                            </div>

                            <!-- Duration Badge -->
                            <div class="absolute top-4 left-4">
                                <span
                                    class="inline-flex items-center px-3 py-1 rounded-full text-xs font-semibold bg-white/90 text-gray-800 shadow-sm">
                                    <svg class="w-3 h-3 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" />
                                    </svg>
                                    {{ \Carbon\Carbon::parse($schedule->from_date)->diffInDays($schedule->to_date) + 1 }}
                                    Days
                                </span>
                            </div>
                        </div>

                        <div class="p-6">
                            <!-- Title Section -->
                            <div class="mb-4">
                                <h3
                                    class="text-xl font-bold text-gray-900 mb-2 group-hover:text-green-600 transition-colors duration-200">
                                    {{ $schedule->touristPackage->package_name ?? 'Unknown Package' }}
                                </h3>
                                <div class="space-y-2">
                                    <div class="flex items-center text-gray-600">
                                        <svg class="w-4 h-4 mr-2 text-gray-400" fill="none" stroke="currentColor"
                                            viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M17.657 16.657L13.414 20.9a2 2 0 01-2.828 0l-4.243-4.243a8 8 0 1111.314 0z" />
                                        </svg>
                                        <span
                                            class="text-sm font-medium">{{ $schedule->touristPackage->destination->destination_name ?? 'No destination' }}</span>
                                    </div>
                                    <div class="flex items-center text-gray-600">
                                        <svg class="w-4 h-4 mr-2 text-gray-400" fill="none" stroke="currentColor"
                                            viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" />
                                        </svg>
                                        <span
                                            class="text-sm font-medium">{{ $schedule->touristPackage->guide->gname ?? 'No guide assigned' }}</span>
                                    </div>
                                </div>
                            </div>

                            <!-- Date Range -->
                            <div class="mb-4 p-4 bg-gradient-to-r from-gray-50 to-gray-100 rounded-xl">
                                <div class="flex justify-between items-center">
                                    <div>
                                        <p class="text-sm text-gray-600">From</p>
                                        <p class="text-lg font-bold text-gray-900">
                                            {{ \Carbon\Carbon::parse($schedule->from_date)->format('M d, Y') }}</p>
                                    </div>
                                    <div class="text-right">
                                        <p class="text-sm text-gray-600">To</p>
                                        <p class="text-lg font-bold text-gray-900">
                                            {{ \Carbon\Carbon::parse($schedule->to_date)->format('M d, Y') }}</p>
                                    </div>
                                </div>
                            </div>

                            <!-- Time Details -->
                            <div class="grid grid-cols-2 gap-4 mb-6">
                                <div class="text-center p-3 bg-green-50 rounded-xl border border-green-100">
                                    <p class="text-lg font-bold text-green-600">{{ $schedule->departure_time }}</p>
                                    <p class="text-xs font-semibold text-green-500 uppercase tracking-wide">Departure</p>
                                </div>
                                <div class="text-center p-3 bg-blue-50 rounded-xl border border-blue-100">
                                    <p class="text-lg font-bold text-blue-600">{{ $schedule->arrival_time }}</p>
                                    <p class="text-xs font-semibold text-blue-500 uppercase tracking-wide">Arrival</p>
                                </div>
                            </div>

                            <!-- Bookings Count -->
                            <div class="mb-4 space-y-2">
                                <span
                                    class="inline-flex items-center px-3 py-1 rounded-full text-xs font-semibold bg-purple-100 text-purple-700">
                                    <svg class="w-3 h-3 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M9 5H7a2 2 0 00-2 2v10a2 2 0 002 2h8a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2" />
                                    </svg>
                                    {{ $schedule->bookings_count }} Bookings
                                </span>
                                <span class="inline-flex items-center px-3 py-1 rounded-full text-xs font-semibold 
                        {{ $schedule->available_places > 0 ? 'bg-green-100 text-green-700' : 'bg-red-100 text-red-700' }}">
                                    <svg class="w-3 h-3 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z" />
                                    </svg>
                                    {{ $schedule->available_places }} Available Places
                                </span>
                            </div> <!-- Enhanced Action Buttons -->
                            <div class="flex items-center gap-2">
                                <a href="{{ route('admin.schedules.edit', $schedule) }}"
                                    class="flex-1 inline-flex items-center justify-center gap-2 px-3 py-2.5 rounded-xl text-sm font-medium bg-gradient-to-r from-green-500 to-green-600 text-white hover:from-green-600 hover:to-green-700 transition-all duration-200 shadow-md hover:shadow-lg transform hover:-translate-y-0.5">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5M18.5 2.5a2.121 2.121 0 013 3L12 15l-4 1 1-4 9.5-9.5z" />
                                    </svg>
                                    Edit
                                </a>
                                <a href="{{ route('admin.schedules.delete', $schedule) }}"
                                    class="flex-1 inline-flex items-center justify-center gap-2 px-3 py-2.5 rounded-xl text-sm font-medium bg-gradient-to-r from-red-500 to-red-600 text-white hover:from-red-600 hover:to-red-700 transition-all duration-200 shadow-md hover:shadow-lg transform hover:-translate-y-0.5"
                                    onclick="return confirm('Are you sure you want to delete this schedule?')">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6M9 7h6m-7 0V5a2 2 0 012-2h3a2 2 0 012 2v2" />
                                    </svg>
                                    Delete
                                </a>
                            </div>
                        </div>
                    </div>
                @empty
                    <div class="col-span-full">
                        <div class="bg-white rounded-2xl shadow-lg border border-gray-100 p-12 text-center">
                            <div
                                class="mx-auto w-24 h-24 bg-gradient-to-br from-gray-100 to-gray-200 rounded-full flex items-center justify-center mb-6">
                                <svg class="w-12 h-12 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5"
                                        d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" />
                                </svg>
                            </div>
                            <h3 class="text-xl font-bold text-gray-900 mb-2">No schedules found</h3>
                            <p class="text-gray-600 mb-8 max-w-md mx-auto">Get started by creating your first schedule. Set
                                up tour dates and times for your packages.</p>
                            <a href="{{ route('admin.schedules.create') }}"
                                class="inline-flex items-center px-6 py-3 bg-gradient-to-r from-green-600 to-emerald-600 text-white rounded-xl hover:from-green-700 hover:to-emerald-700 transition-all duration-200 shadow-lg hover:shadow-xl transform hover:-translate-y-0.5 font-medium">
                                <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M12 4v16m8-8H3" />
                                </svg>
                                Create First Schedule
                            </a>
                        </div>
                    </div>
                @endforelse
            </div>

            <!-- Enhanced Pagination -->
            @if($schedules->hasPages())
                <div class="mt-8 flex justify-center">
                    <div class="bg-white rounded-2xl shadow-lg border border-gray-100 p-4">
                        {{ $schedules->links() }}
                    </div>
                </div>
            @endif
        </div>
    </div>
</x-layouts.app.sidebar>