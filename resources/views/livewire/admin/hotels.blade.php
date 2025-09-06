<x-layouts.app.sidebar>
    <div class="p-6 lg:p-8 space-y-6">
        <!-- Header -->
        <div class="flex justify-between items-center">
            <div>
                <h1 class="text-2xl font-bold text-gray-900">Hotels</h1>
                <p class="text-sm text-gray-600">Browse available hotels for your stay</p>
            </div>
        </div>

        <!-- Hotels Grid -->
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
            @forelse($hotels as $hotel)
                <div class="bg-white rounded-lg shadow-md overflow-hidden hover:shadow-lg transition-shadow duration-200">
                    <div class="aspect-w-16 aspect-h-9 bg-gray-200">
                        <div class="flex items-center justify-center text-gray-400">
                            <svg class="w-12 h-12" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4" />
                            </svg>
                        </div>
                    </div>
                    
                    <div class="p-6">
                        <h3 class="text-lg font-semibold text-gray-900 mb-2">{{ $hotel->name }}</h3>
                        <p class="text-sm text-gray-600 mb-4">{{ $hotel->location }}</p>
                        
                        <!-- Star Rating -->
                        <div class="flex items-center mb-3">
                            @for($i = 1; $i <= 5; $i++)
                                <svg class="w-4 h-4 {{ $i <= $hotel->stars ? 'text-yellow-400' : 'text-gray-300' }}" fill="currentColor" viewBox="0 0 20 20">
                                    <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"/>
                                </svg>
                            @endfor
                            <span class="ml-2 text-sm text-gray-600">{{ $hotel->stars }} Star Hotel</span>
                        </div>
                        
                        <!-- Amenities -->
                        @if($hotel->amenities)
                            <div class="mb-4">
                                <p class="text-sm text-gray-700 font-medium mb-1">Amenities:</p>
                                <p class="text-xs text-gray-600">{{ $hotel->amenities }}</p>
                            </div>
                        @endif
                        
                        <!-- Room Count -->
                        <div class="flex items-center justify-between">
                            <span class="text-sm text-gray-600">
                                {{ $hotel->rooms_count }} room{{ $hotel->rooms_count !== 1 ? 's' : '' }} available
                            </span>
                            <div class="text-right">
                                <p class="text-lg font-bold text-blue-600">${{ number_format($hotel->price_per_night, 2) }}</p>
                                <p class="text-xs text-gray-500">per night</p>
                            </div>
                        </div>
                    </div>
                </div>
            @empty
                <div class="col-span-full text-center py-12">
                    <svg class="mx-auto h-12 w-12 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4" />
                    </svg>
                    <h3 class="mt-2 text-sm font-medium text-gray-900">No hotels found</h3>
                    <p class="mt-1 text-sm text-gray-500">There are currently no hotels available.</p>
                </div>
            @endforelse
        </div>

        <!-- Pagination -->
        @if($hotels->hasPages())
            <div class="mt-8">
                {{ $hotels->links() }}
            </div>
        @endif
    </div>
</x-layouts.app.sidebar>
