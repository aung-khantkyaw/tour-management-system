<x-layouts.guest :title="$destination->destination_name . ' Packages - Tour Management System'">
    <div class="max-w-7xl mx-auto px-4 py-16">
        <!-- Navigation -->
        <div class="mb-6">
            <a href="{{ route('destinations') }}"
                class="inline-flex items-center text-sm text-blue-600 hover:text-blue-800 transition-colors">
                <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M10 19l-7-7m0 0l7-7m-7 7h18" />
                </svg>
                All Destinations
            </a>
        </div>

        <!-- Destination Hero Section -->
        <div class="relative h-96 rounded-2xl overflow-hidden mb-10 shadow-2xl">
            @if($destination->destination_profile)
                <img src="{{ asset('storage/' . $destination->destination_profile) }}"
                    alt="{{ $destination->destination_name }}" class="w-full h-full object-cover">
            @else
                <div class="w-full h-full bg-gradient-to-br from-blue-500 via-indigo-600 to-purple-700"></div>
            @endif
            <div class="absolute inset-0 bg-gradient-to-t from-black/70 via-black/20 to-transparent"></div>
            <div class="absolute bottom-0 left-0 right-0 p-8 text-white">
                <h1 class="text-5xl font-bold mb-4">{{ $destination->destination_name }}</h1>
                <p class="text-xl text-gray-200 mb-4">{{ $destination->city }}</p>
                <div class="flex items-center space-x-6 text-sm">
                    <span class="flex items-center">
                        <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4" />
                        </svg>
                        {{ $destination->hotels_count }} Hotels
                    </span>
                    <span class="flex items-center">
                        <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M9 10l3-3 3 3" />
                        </svg>
                        {{ $destination->tourist_packages_count }} Packages
                    </span>
                </div>
            </div>
        </div>

        <!-- Destination Details Card -->
        <div class="bg-white rounded-2xl shadow-lg border border-gray-100 overflow-hidden mb-10">
            <div class="bg-gradient-to-r from-blue-500 to-indigo-600 px-8 py-6">
                <h2 class="text-2xl font-bold text-white mb-2">About {{ $destination->destination_name }}</h2>
                <p class="text-blue-100">Discover what makes this destination special</p>
            </div>

            <div class="p-8">
                <!-- Description Section -->
                @if($destination->description)
                    <div class="mb-8">
                        <h3 class="text-xl font-semibold text-gray-900 mb-4">Description</h3>
                        <div class="prose prose-gray max-w-none">
                            <p class="text-gray-700 leading-relaxed">{{ $destination->description }}</p>
                        </div>
                    </div>
                @endif

                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6 mb-8">
                    <div class="text-center p-4 bg-blue-50 rounded-xl border border-blue-100">
                        <div class="w-12 h-12 bg-blue-500 rounded-full flex items-center justify-center mx-auto mb-3">
                            <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M17.657 16.657L13.414 20.9a2 2 0 01-2.828 0l-4.243-4.243a8 8 0 1111.314 0z" />
                            </svg>
                        </div>
                        <h3 class="font-semibold text-gray-900 mb-1">Location</h3>
                        <p class="text-blue-600 font-medium">{{ $destination->city }}</p>
                    </div>

                    <div class="text-center p-4 bg-green-50 rounded-xl border border-green-100">
                        <div class="w-12 h-12 bg-green-500 rounded-full flex items-center justify-center mx-auto mb-3">
                            <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4" />
                            </svg>
                        </div>
                        <h3 class="font-semibold text-gray-900 mb-1">Hotels</h3>
                        <p class="text-green-600 font-medium">{{ $destination->hotels_count }} Available</p>
                    </div>

                    <div class="text-center p-4 bg-purple-50 rounded-xl border border-purple-100">
                        <div class="w-12 h-12 bg-purple-500 rounded-full flex items-center justify-center mx-auto mb-3">
                            <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M9 10l3-3 3 3" />
                            </svg>
                        </div>
                        <h3 class="font-semibold text-gray-900 mb-1">Tour Packages</h3>
                        <p class="text-purple-600 font-medium">{{ $destination->tourist_packages_count }} Options</p>
                    </div>

                    <div class="text-center p-4 bg-orange-50 rounded-xl border border-orange-100">
                        <div class="w-12 h-12 bg-orange-500 rounded-full flex items-center justify-center mx-auto mb-3">
                            <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" />
                            </svg>
                        </div>
                        <h3 class="font-semibold text-gray-900 mb-1">Best Time</h3>
                        <p class="text-orange-600 font-medium">Year Round</p>
                    </div>
                </div>

                @if($destination->hotels->count() > 0)
                    <div class="border-t border-gray-200 pt-6">
                        <h3 class="text-lg font-semibold text-gray-900 mb-4">Top Rated Hotels</h3>
                        <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                            @foreach($destination->hotels as $hotel)
                                <div class="bg-gray-50 rounded-lg p-4 border border-gray-200">
                                    <h4 class="font-medium text-gray-900 mb-2">{{ $hotel->name }}</h4>
                                    <div class="flex items-center">
                                        @for($i = 1; $i <= 5; $i++)
                                            <svg class="w-4 h-4 {{ $i <= $hotel->rating ? 'text-yellow-400' : 'text-gray-300' }}"
                                                fill="currentColor" viewBox="0 0 20 20">
                                                <path
                                                    d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z" />
                                            </svg>
                                        @endfor
                                        <span class="ml-2 text-sm text-gray-600">{{ $hotel->rating }}/5</span>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    </div>
                @endif
            </div>
        </div>

        <!-- Packages Section -->
        <div class="mb-6">
            <h2 class="text-2xl font-bold text-gray-900 mb-2">Available Tour Packages</h2>
            <p class="text-gray-600">Choose from {{ $destination->tourist_packages_count }} carefully curated tour
                packages</p>
        </div>

        @if($packages->isEmpty())
            <div class="rounded-lg border border-gray-200 bg-white p-10 text-center text-gray-500">
                No packages for this destination yet.
            </div>
        @else
            <div class="grid gap-8 md:grid-cols-2 lg:grid-cols-3">
                @foreach($packages as $p)
                    <div
                        class="group relative flex flex-col overflow-hidden rounded-lg border border-gray-200 bg-white shadow-sm hover:shadow-md transition">
                        <div
                            class="h-32 bg-gradient-to-br from-blue-500 via-indigo-600 to-blue-600 text-white flex items-center justify-center px-4">
                            <span class="text-lg font-semibold tracking-wide text-center leading-snug">
                                {{ $p->package_name }}
                            </span>
                        </div>
                        <div class="p-5 flex-1 flex flex-col">
                            <div class="mb-3 space-y-1.5 text-sm">
                                <p class="flex justify-between">
                                    <span class="text-gray-500">Duration:</span>
                                    <span class="font-medium text-gray-900">{{ $p->duration_days }} days</span>
                                </p>
                                <p class="flex justify-between">
                                    <span class="text-gray-500">Capacity:</span>
                                    <span class="font-medium text-gray-900">{{ $p->no_of_people }} ppl</span>
                                </p>
                                <p class="flex justify-between">
                                    <span class="text-gray-500">Vehicle:</span>
                                    <span class="font-medium text-gray-900">{{ $p->vehicle_type ?? 'N/A' }}</span>
                                </p>
                                <p class="flex justify-between">
                                    <span class="text-gray-500">Guide:</span>
                                    <span class="font-medium text-gray-900">
                                        {{ $p->guide?->guide_name ?? $p->guide?->gname ?? '—' }}
                                    </span>
                                </p>
                                <p class="flex justify-between">
                                    <span class="text-gray-500">Schedules:</span>
                                    <span class="font-medium text-gray-900">{{ $p->schedules_count }}</span>
                                </p>
                            </div>
                            <div class="mt-auto pt-4 border-t border-gray-100">
                                @if ($p->schedules_count > 0)
                                    <div class="flex items-end justify-between">
                                        <div class="text-xs text-gray-500 space-y-0.5">
                                            <div>Single:
                                                <span class="text-gray-800 font-semibold">
                                                    ${{ number_format($p->singlepackage_fee, 2) }}
                                                </span>
                                            </div>
                                            <div>Group:
                                                <span class="text-gray-800 font-semibold">
                                                    ${{ number_format($p->fullpackage_fee, 2) }}
                                                </span>
                                            </div>
                                        </div>
                                        <a href="{{ route('package.schedule', $p->package_id) }}"
                                            class="inline-flex items-center rounded-md bg-blue-600 px-3 py-1.5 text-xs font-medium text-white shadow hover:bg-blue-500 transition">
                                            View Schedule
                                        </a>
                                    </div>
                                @else
                                    <span class="text-sm text-red-500 font-medium">No available schedules</span>
                                @endif
                            </div>
                        </div>
                        <div
                            class="absolute inset-x-0 top-0 h-1 bg-gradient-to-r from-transparent via-white/30 to-transparent opacity-0 group-hover:opacity-100 transition">
                        </div>
                    </div>
                @endforeach
            </div>
        @endif
    </div>
</x-layouts.guest>