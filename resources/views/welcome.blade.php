<x-layouts.guest title="Welcome - Tour Management System">
    <!-- Hero Carousel -->
    <section id="hero" class="relative w-full h-[380px] sm:h-[460px] overflow-hidden group">
        <div class="absolute inset-0">
            <div class="h-full w-full relative" x-data="{ current: 0, imgs: [
                        'https://images.unsplash.com/photo-1507525428034-b723cf961d3e?auto=format&fit=crop&w=1400&q=60',
                        'https://images.unsplash.com/photo-1511739001486-6bfe10ce785f?auto=format&fit=crop&w=1400&q=60',
                        'https://images.unsplash.com/photo-1500530855697-b586d89ba3ee?auto=format&fit=crop&w=1400&q=60'
                    ], advance(){ this.current = (this.current+1)%this.imgs.length } }"
                x-init="setInterval(()=>advance(),5000)">
                <template x-for="(img, idx) in imgs" :key="idx">
                    <div x-show="current===idx" x-transition:fade class="absolute inset-0 bg-center bg-cover"
                        :style="`background-image:url(${img})`"></div>
                </template>
                <div class="absolute inset-0 bg-black/40"></div>
                <div
                    class="relative z-10 max-w-4xl mx-auto px-6 h-full flex flex-col justify-center text-center text-white">
                    <h1 class="text-3xl sm:text-5xl font-bold tracking-tight mb-4">Discover. Explore. Experience.</h1>
                    <p class="text-lg sm:text-xl mb-6">Curated journeys to breathtaking destinations with expert local
                        guides.</p>
                    <div class="flex flex-wrap justify-center gap-4">
                        <a href="#destinations"
                            class="px-5 py-3 rounded-md bg-primary-600 hover:bg-primary-500 text-white font-medium transition">Explore
                            Destinations</a>
                        <a href="#contact"
                            class="px-5 py-3 rounded-md bg-white/10 backdrop-blur border border-white/20 hover:bg-white/20 text-white font-medium transition">Contact
                            Us</a>
                    </div>
                    <div class="absolute bottom-4 left-1/2 -translate-x-1/2 flex space-x-2">
                        <template x-for="(img, idx) in imgs" :key="idx">
                            <button @click="current=idx"
                                :class="current===idx ? 'bg-white' : 'bg-white/40 hover:bg-white/70'"
                                class="w-3 h-3 rounded-full transition"></button>
                        </template>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Intro Paragraph -->
    <section class="py-12 bg-white">
        <div class="max-w-5xl mx-auto px-6">
            <p class="text-lg text-gray-700 leading-relaxed">
                "Let us guide you to new places, new smiles, and new memories because every trip deserves to be
                unforgettable."
            </p>
        </div>
    </section>

    <!-- Destinations Scroll Cards -->
    <section id="destinations" class="py-12 bg-gray-50">
        <div class="max-w-7xl mx-auto px-6 mb-8 flex items-center justify-between">
            <h2 class="text-2xl sm:text-3xl font-bold text-gray-900">Latest Destinations</h2>
            <a href="{{ route('destinations') }}" class="text-sm text-blue-600 hover:underline">View All</a>
        </div>

        <div class="max-w-7xl mx-auto px-6">
            @if(isset($latestDestinations) && $latestDestinations->count())
                <div class="grid gap-8 sm:grid-cols-2 lg:grid-cols-3">
                    @foreach($latestDestinations as $d)
                        <a href="{{ route('destination.packages', $d->destination_id) }}"
                            class="group block relative overflow-hidden rounded-xl bg-white shadow-sm ring-1 ring-gray-200 transition hover:shadow-md focus:outline-none focus:ring-2 focus:ring-blue-500">
                            <div class="relative h-40 overflow-hidden">
                                @if($d->destination_profile)
                                    <img src="{{ asset('storage/' . $d->destination_profile) }}" alt="{{ $d->destination_name }}" class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-300">
                                @else
                                    <div class="h-full bg-gradient-to-br from-blue-500/70 to-indigo-600/70 flex items-center justify-center text-white text-4xl font-semibold">
                                        {{ strtoupper(substr($d->destination_name, 0, 1)) }}
                                    </div>
                                @endif
                                <div class="absolute inset-0 bg-gradient-to-t from-black/20 to-transparent opacity-0 group-hover:opacity-100 transition-opacity duration-300"></div>
                            </div>
                            <div class="p-5 space-y-4">
                                <div class="space-y-1">
                                    <h3 class="text-lg font-bold text-gray-900 group-hover:text-blue-700 transition">
                                        {{ $d->destination_name }}
                                    </h3>
                                    <p class="text-xs font-medium text-blue-600 uppercase tracking-wide">
                                        {{ $d->city }}
                                    </p>
                                </div>
                                <p class="text-sm text-gray-600 line-clamp-3">
                                    {{ $d->description ?: 'No description available.' }}
                                </p>
                                <div
                                    class="flex items-center justify-between text-[11px] uppercase tracking-wide text-gray-500">
                                    <span class="flex items-center gap-1">
                                        <svg class="h-3.5 w-3.5 text-blue-500" fill="none" stroke="currentColor"
                                            stroke-width="2" stroke-linecap="round" stroke-linejoin="round" viewBox="0 0 24 24">
                                            <path d="M21 10c0 7-9 12-9 12s-9-5-9-12a9 9 0 0 1 18 0Z" />
                                            <circle cx="12" cy="10" r="3" />
                                        </svg>
                                        {{ $d->hotels_count ?? '—' }} Hotels
                                    </span>
                                    <span class="flex items-center gap-1">
                                        <svg class="h-3.5 w-3.5 text-indigo-500" fill="none" stroke="currentColor"
                                            stroke-width="2" stroke-linecap="round" stroke-linejoin="round" viewBox="0 0 24 24">
                                            <path d="M3 4h18v4H3z" />
                                            <path d="M8 8v12" />
                                            <path d="M16 8v12" />
                                            <path d="M3 12h18" />
                                        </svg>
                                        {{ $d->tourist_packages_count ?? '—' }} Packages
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
                <div
                    class="rounded-lg border border-dashed border-gray-300 bg-white p-10 text-center text-sm text-gray-500">
                    No destinations found.
                </div>
            @endif
        </div>
    </section>

    <!-- Our Locations Section -->
    <section id="contact" class="py-16 bg-white">
        <div class="max-w-7xl mx-auto px-6">
            <div class="text-center mb-12">
                <h2 class="text-2xl sm:text-3xl font-bold mb-4 text-gray-900">Our Locations</h2>
                <p class="text-gray-600 max-w-2xl mx-auto">Discover our offices and service areas around the world. We're here to help you plan your perfect adventure.</p>
            </div>
            
            <div class="grid lg:grid-cols-3 gap-8 mb-8">
                <!-- Location Cards -->
                <div class="bg-gradient-to-br from-blue-50 to-indigo-50 rounded-2xl p-6 border border-blue-100">
                    <div class="flex items-center mb-4">
                        <div class="w-12 h-12 bg-blue-500 rounded-xl flex items-center justify-center mr-4">
                            <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"/>
                            </svg>
                        </div>
                        <h3 class="text-lg font-bold text-gray-900">Main Office</h3>
                    </div>
                    <div class="space-y-2 text-sm text-gray-700">
                        <p><strong>Address:</strong> 123 Travel Street, Tourism City</p>
                        <p><strong>Phone:</strong> +1 (555) 123-4567</p>
                        <p><strong>Email:</strong> info@tourms.com</p>
                        <p><strong>Hours:</strong> Mon-Fri 9AM-6PM</p>
                    </div>
                </div>
                
                <div class="bg-gradient-to-br from-emerald-50 to-green-50 rounded-2xl p-6 border border-emerald-100">
                    <div class="flex items-center mb-4">
                        <div class="w-12 h-12 bg-emerald-500 rounded-xl flex items-center justify-center mr-4">
                            <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3.055 11H5a2 2 0 012 2v1a2 2 0 002 2 2 2 0 012 2v2.945M8 3.935V5.5A2.5 2.5 0 0010.5 8h.5a2 2 0 012 2 2 2 0 104 0 2 2 0 012-2h1.064M15 20.488V18a2 2 0 012-2h3.064M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                            </svg>
                        </div>
                        <h3 class="text-lg font-bold text-gray-900">Regional Hub</h3>
                    </div>
                    <div class="space-y-2 text-sm text-gray-700">
                        <p><strong>Address:</strong> 456 Adventure Ave, Explorer Bay</p>
                        <p><strong>Phone:</strong> +1 (555) 987-6543</p>
                        <p><strong>Email:</strong> regional@tourms.com</p>
                        <p><strong>Hours:</strong> Mon-Sat 8AM-7PM</p>
                    </div>
                </div>
                
                <div class="bg-gradient-to-br from-purple-50 to-indigo-50 rounded-2xl p-6 border border-purple-100">
                    <div class="flex items-center mb-4">
                        <div class="w-12 h-12 bg-purple-500 rounded-xl flex items-center justify-center mr-4">
                            <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 3v1m0 16v1m9-9h-1M4 12H3m15.364 6.364l-.707-.707M6.343 6.343l-.707-.707m12.728 0l-.707.707M6.343 17.657l-.707.707M16 12a4 4 0 11-8 0 4 4 0 018 0z"/>
                            </svg>
                        </div>
                        <h3 class="text-lg font-bold text-gray-900">Beach Office</h3>
                    </div>
                    <div class="space-y-2 text-sm text-gray-700">
                        <p><strong>Address:</strong> 789 Coastal Road, Sunset Beach</p>
                        <p><strong>Phone:</strong> +1 (555) 456-7890</p>
                        <p><strong>Email:</strong> beach@tourms.com</p>
                        <p><strong>Hours:</strong> Daily 7AM-8PM</p>
                    </div>
                </div>
            </div>
            
            <!-- Interactive Map -->
            <div class="bg-white rounded-2xl shadow-xl border border-gray-100 overflow-hidden">
                <div class="p-6 bg-gradient-to-r from-blue-50 to-indigo-50 border-b border-gray-100">
                    <h3 class="text-xl font-bold text-gray-900 mb-2">Find Us on the Map</h3>
                    <p class="text-gray-600">Click on the markers to view office details and get directions</p>
                </div>
                <div class="relative h-96 bg-gray-100">
                    <!-- Embedded Map Placeholder -->
                    <iframe 
                        src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d2243.4506318938643!2d96.41698163793511!3d18.974759960029623!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x30c5d8ae692c8389%3A0x5e6a5c4f57dd5e05!2sUniversity%20of%20Computer%20Studies%20(Taungoo)!5e0!3m2!1sen!2smm!4v1757161138047!5m2!1sen!2smm"
                        width="100%" 
                        height="100%" 
                        style="border:0;" 
                        allowfullscreen="" 
                        loading="lazy" 
                        referrerpolicy="no-referrer-when-downgrade"
                        class="w-full h-full">
                    </iframe>
                    
                    <!-- Map Overlay Controls -->
                    <div class="absolute top-4 right-4 space-y-2">
                        <button class="bg-white/90 backdrop-blur-sm p-2 rounded-lg shadow-md hover:bg-white transition-colors">
                            <svg class="w-5 h-5 text-gray-700" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"/>
                            </svg>
                        </button>
                        <button class="bg-white/90 backdrop-blur-sm p-2 rounded-lg shadow-md hover:bg-white transition-colors">
                            <svg class="w-5 h-5 text-gray-700" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 12H4"/>
                            </svg>
                        </button>
                        <button class="bg-white/90 backdrop-blur-sm p-2 rounded-lg shadow-md hover:bg-white transition-colors">
                            <svg class="w-5 h-5 text-gray-700" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"/>
                            </svg>
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </section>
</x-layouts.guest>