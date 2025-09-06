<x-layouts.guest title="Destination - Tour Management System">
    <div class="max-w-7xl mx-auto px-4 py-16">
        <h1 class="text-4xl font-bold text-center mb-12 text-blue-800">Destinations</h1>

        @if(isset($destinations) && $destinations->count())
            <div class="grid md:grid-cols-2 lg:grid-cols-3 gap-8 mb-14">
                @foreach($destinations as $destination)
                    <a href="{{ route('destination.packages', $destination->destination_id) }}"
                        class="group block relative overflow-hidden rounded-xl bg-white shadow-sm ring-1 ring-gray-200 transition hover:shadow-md focus:outline-none focus:ring-2 focus:ring-blue-500">
                        <div class="relative h-40 overflow-hidden">
                            @if($destination->destination_profile)
                                <img src="{{ asset('storage/' . $destination->destination_profile) }}" alt="{{ $destination->destination_name }}" class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-300">
                            @else
                                <div class="h-full bg-gradient-to-br from-blue-500/70 to-indigo-500/70 flex items-center justify-center text-white text-3xl font-semibold tracking-wide">
                                    {{ strtoupper(substr($destination->destination_name, 0, 1)) }}
                                </div>
                            @endif
                            <div class="absolute inset-0 bg-gradient-to-t from-black/20 to-transparent opacity-0 group-hover:opacity-100 transition-opacity duration-300"></div>
                        </div>
                        <div class="p-5 space-y-4">
                            <div class="space-y-1">
                                <h3 class="text-xl font-bold text-gray-900 capitalize group-hover:text-blue-700 transition">
                                    {{ $destination->destination_name }}
                                </h3>
                                <p class="text-xs font-medium text-blue-600 uppercase tracking-wide">
                                    {{ $destination->city }}
                                </p>
                            </div>
                            <p class="text-sm text-gray-600 line-clamp-3">
                                {{ $destination->description }}
                            </p>
                            <div class="flex items-center justify-between text-[11px] uppercase tracking-wide text-gray-500">
                                <span class="flex items-center gap-1">
                                    <svg class="h-3.5 w-3.5 text-blue-500" fill="none" stroke="currentColor" stroke-width="2"
                                        stroke-linecap="round" stroke-linejoin="round" viewBox="0 0 24 24">
                                        <path d="M21 10c0 7-9 12-9 12s-9-5-9-12a9 9 0 0 1 18 0Z" />
                                        <circle cx="12" cy="10" r="3" />
                                    </svg>
                                    {{ $destination->hotels_count }} Hotels
                                </span>
                                <span class="flex items-center gap-1">
                                    <svg class="h-3.5 w-3.5 text-indigo-500" fill="none" stroke="currentColor" stroke-width="2"
                                        stroke-linecap="round" stroke-linejoin="round" viewBox="0 0 24 24">
                                        <path d="M3 4h18v4H3z" />
                                        <path d="M8 8v12" />
                                        <path d="M16 8v12" />
                                        <path d="M3 12h18" />
                                    </svg>
                                    {{ $destination->tourist_packages_count }} Packages
                                </span>
                            </div>
                        </div>
                        <div
                            class="absolute inset-x-0 bottom-0 h-1 bg-gradient-to-r from-blue-400 via-indigo-400 to-blue-400 opacity-0 group-hover:opacity-100 transition">
                        </div>
                    </a>
                @endforeach
            </div>
        @else
            <div class="mb-14 text-center text-sm text-gray-500">No destinations available.</div>
        @endif
    </div>
</x-layouts.guest>