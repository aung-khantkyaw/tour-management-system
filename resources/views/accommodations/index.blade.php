<x-layouts.app.sidebar>
    <div class="p-6 lg:p-8 space-y-6">
        <!-- Header -->
        <div class="flex justify-between items-center">
            <div>
                <h1 class="text-2xl font-bold text-gray-900">Accommodations</h1>
                <p class="text-sm text-gray-600">View accommodation arrangements for tour packages</p>
            </div>
        </div>

        <!-- Accommodations List -->
        <div class="space-y-4">
            @forelse($accommodations as $accommodation)
                <div class="bg-white rounded-lg shadow-md p-6 hover:shadow-lg transition-shadow duration-200">
                    <div class="flex justify-between items-start">
                        <div class="flex-1">
                            <div class="flex items-center space-x-4 mb-4">
                                <h3 class="text-lg font-semibold text-gray-900">{{ $accommodation->hotel->name }}</h3>
                                <div class="flex items-center">
                                    @for($i = 1; $i <= 5; $i++)
                                        <svg class="w-4 h-4 {{ $i <= $accommodation->hotel->stars ? 'text-yellow-400' : 'text-gray-300' }}" fill="currentColor" viewBox="0 0 20 20">
                                            <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"/>
                                        </svg>
                                    @endfor
                                </div>
                            </div>
                            
                            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-4 mb-4">
                                <div>
                                    <p class="text-sm font-medium text-gray-700">Package</p>
                                    <p class="text-sm text-gray-600">{{ $accommodation->touristPackage->name }}</p>
                                </div>
                                <div>
                                    <p class="text-sm font-medium text-gray-700">Location</p>
                                    <p class="text-sm text-gray-600">{{ $accommodation->hotel->location }}</p>
                                </div>
                                <div>
                                    <p class="text-sm font-medium text-gray-700">Check-in Date</p>
                                    <p class="text-sm text-gray-600">{{ $accommodation->check_in_date ? $accommodation->check_in_date->format('M d, Y') : 'TBD' }}</p>
                                </div>
                                <div>
                                    <p class="text-sm font-medium text-gray-700">Check-out Date</p>
                                    <p class="text-sm text-gray-600">{{ $accommodation->check_out_date ? $accommodation->check_out_date->format('M d, Y') : 'TBD' }}</p>
                                </div>
                                <div>
                                    <p class="text-sm font-medium text-gray-700">Rate per Night</p>
                                    <p class="text-sm text-gray-600">${{ number_format($accommodation->hotel->price_per_night, 2) }}</p>
                                </div>
                                <div>
                                    <p class="text-sm font-medium text-gray-700">Duration</p>
                                    <p class="text-sm text-gray-600">
                                        @if($accommodation->check_in_date && $accommodation->check_out_date)
                                            {{ $accommodation->check_in_date->diffInDays($accommodation->check_out_date) }} night(s)
                                        @else
                                            TBD
                                        @endif
                                    </p>
                                </div>
                            </div>
                            
                            @if($accommodation->hotel->amenities)
                                <div>
                                    <p class="text-sm font-medium text-gray-700 mb-1">Hotel Amenities</p>
                                    <p class="text-sm text-gray-600">{{ $accommodation->hotel->amenities }}</p>
                                </div>
                            @endif
                        </div>
                        
                        <div class="flex-shrink-0 ml-4">
                            <div class="text-right">
                                @if($accommodation->check_in_date && $accommodation->check_out_date)
                                    @php
                                        $nights = $accommodation->check_in_date->diffInDays($accommodation->check_out_date);
                                        $totalCost = $nights * $accommodation->hotel->price_per_night;
                                    @endphp
                                    <p class="text-lg font-bold text-blue-600">${{ number_format($totalCost, 2) }}</p>
                                    <p class="text-xs text-gray-500">total cost</p>
                                @endif
                            </div>
                        </div>
                    </div>
                </div>
            @empty
                <div class="text-center py-12">
                    <svg class="mx-auto h-12 w-12 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4" />
                    </svg>
                    <h3 class="mt-2 text-sm font-medium text-gray-900">No accommodations found</h3>
                    <p class="mt-1 text-sm text-gray-500">There are currently no accommodation arrangements available.</p>
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
