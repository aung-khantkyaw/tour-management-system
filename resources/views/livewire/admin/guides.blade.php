<x-layouts.app.sidebar>
    <div class="p-6 lg:p-8 space-y-6">
        <!-- Header -->
        <div class="flex justify-between items-center">
            <div>
                <h1 class="text-2xl font-bold text-gray-900">Tour Guides</h1>
                <p class="text-sm text-gray-600">Meet our experienced and professional tour guides</p>
            </div>
        </div>

        <!-- Guides Grid -->
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
            @forelse($guides as $guide)
                <div class="bg-white rounded-lg shadow-md overflow-hidden hover:shadow-lg transition-shadow duration-200">
                    <!-- Profile Image -->
                    <div class="aspect-w-16 aspect-h-12 bg-gray-200">
                        <div class="flex items-center justify-center text-gray-400">
                            <svg class="w-16 h-16" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" />
                            </svg>
                        </div>
                    </div>

                    <div class="p-6">
                        <h3 class="text-lg font-semibold text-gray-900 mb-1">{{ $guide->name }}</h3>
                        <p class="text-sm text-blue-600 mb-3">{{ $guide->specialization }}</p>

                        <!-- Experience -->
                        <div class="mb-3">
                            <div class="flex items-center text-sm text-gray-600">
                                <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" />
                                </svg>
                                {{ $guide->experience_years }} years of experience
                            </div>
                        </div>

                        <!-- Languages -->
                        @if($guide->languages)
                            <div class="mb-3">
                                <p class="text-sm text-gray-700 font-medium mb-1">Languages:</p>
                                <div class="flex flex-wrap gap-1">
                                    @foreach(explode(',', $guide->languages) as $language)
                                        <span class="inline-block bg-blue-100 text-blue-800 text-xs px-2 py-1 rounded-full">
                                            {{ trim($language) }}
                                        </span>
                                    @endforeach
                                </div>
                            </div>
                        @endif

                        <!-- Bio -->
                        @if($guide->bio)
                            <div class="mb-4">
                                <p class="text-sm text-gray-600">{{ Str::limit($guide->bio, 100) }}</p>
                            </div>
                        @endif

                        <!-- Pricing -->
                        <div class="flex items-center justify-between border-t pt-3">
                            <div class="flex items-center text-sm text-gray-600">
                                <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1" />
                                </svg>
                                Available
                            </div>
                            <div class="text-right">
                                <p class="text-lg font-bold text-green-600">${{ number_format($guide->rate_per_day, 2) }}
                                </p>
                                <p class="text-xs text-gray-500">per day</p>
                            </div>
                        </div>
                    </div>
                </div>
            @empty
                <div class="col-span-full text-center py-12">
                    <svg class="mx-auto h-12 w-12 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" />
                    </svg>
                    <h3 class="mt-2 text-sm font-medium text-gray-900">No guides available</h3>
                    <p class="mt-1 text-sm text-gray-500">There are currently no tour guides available.</p>
                </div>
            @endforelse
        </div>

        <!-- Pagination -->
        @if($guides->hasPages())
            <div class="mt-8">
                {{ $guides->links() }}
            </div>
        @endif
    </div>
</x-layouts.app.sidebar>