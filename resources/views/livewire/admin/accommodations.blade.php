<x-layouts.app.sidebar>
    <div class="p-6 lg:p-8 space-y-6">
        <!-- Header -->
        <div class="flex justify-between items-center">
            <div>
                <h1 class="text-2xl font-bold text-gray-900">Accommodations</h1>
                <p class="text-sm text-gray-600">Discover comfortable accommodations for your journey</p>
            </div>
        </div>

        <!-- Accommodations Grid -->
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
            @forelse($accommodations as $accommodation)
                <div class="bg-white rounded-lg shadow-md overflow-hidden hover:shadow-lg transition-shadow duration-200">
                    <!-- Image Placeholder -->
                    <div class="aspect-w-16 aspect-h-9 bg-gray-200">
                        <div class="flex items-center justify-center text-gray-400">
                            <svg class="w-12 h-12" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M3 7v10a2 2 0 002 2h14a2 2 0 002-2V9a2 2 0 00-2-2H5a2 2 0 00-2 2v0" />
                            </svg>
                        </div>
                    </div>

                    <div class="p-6">
                        <div class="flex justify-between items-start mb-2">
                            <h3 class="text-lg font-semibold text-gray-900">{{ $accommodation->name }}</h3>
                            <span class="inline-block bg-blue-100 text-blue-800 text-xs px-2 py-1 rounded-full">
                                {{ ucfirst($accommodation->type) }}
                            </span>
                        </div>

                        <p class="text-sm text-gray-600 mb-3">{{ $accommodation->location }}</p>

                        <!-- Amenities -->
                        @if($accommodation->amenities)
                            <div class="mb-4">
                                <p class="text-sm text-gray-700 font-medium mb-1">Amenities:</p>
                                <div class="flex flex-wrap gap-1">
                                    @foreach(explode(',', $accommodation->amenities) as $amenity)
                                        <span class="inline-block bg-gray-100 text-gray-700 text-xs px-2 py-1 rounded">
                                            {{ trim($amenity) }}
                                        </span>
                                    @endforeach
                                </div>
                            </div>
                        @endif

                        <!-- Description -->
                        @if($accommodation->description)
                            <div class="mb-4">
                                <p class="text-sm text-gray-600">{{ Str::limit($accommodation->description, 100) }}</p>
                            </div>
                        @endif

                        <!-- Capacity and Price -->
                        <div class="flex items-center justify-between border-t pt-3">
                            <div class="flex items-center text-sm text-gray-600">
                                <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z" />
                                </svg>
                                Up to {{ $accommodation->capacity }} guests
                            </div>
                            <div class="text-right">
                                <p class="text-lg font-bold text-purple-600">
                                    ${{ number_format($accommodation->price_per_night, 2) }}</p>
                                <p class="text-xs text-gray-500">per night</p>
                            </div>
                        </div>
                    </div>
                </div>
            @empty
                <div class="col-span-full text-center py-12">
                    <svg class="mx-auto h-12 w-12 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M3 7v10a2 2 0 002 2h14a2 2 0 002-2V9a2 2 0 00-2-2H5a2 2 0 00-2 2v0" />
                    </svg>
                    <h3 class="mt-2 text-sm font-medium text-gray-900">No accommodations found</h3>
                    <p class="mt-1 text-sm text-gray-500">There are currently no accommodations available.</p>
                </div>
            @endforelse
        </div>

        <!-- Pagination -->
        @if($accommodations->hasPages())
            <div class="mt-8">
                {{ $accommodations->links() }}
            </div>
        @endif
    </div>
</x-layouts.app.sidebar>