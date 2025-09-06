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

    <!-- Contact Us Section -->
    <section id="contact" class="py-16 bg-white">
        <div class="max-w-5xl mx-auto px-6 grid md:grid-cols-2 gap-12">
            <div>
                <h2 class="text-2xl sm:text-3xl font-bold mb-4 text-gray-900">Contact Us</h2>
                <p class="text-gray-600 mb-6">Got questions about a destination, package, or custom
                    itinerary? Send us a message and our team will get back to you shortly.</p>
                <ul class="space-y-2 text-gray-700 text-sm mb-6">
                    <li><strong>Email:</strong> info@tourms.com</li>
                    <li><strong>Phone:</strong> +1 (555) 123-4567</li>
                    <li><strong>Address:</strong> 123 Travel St, City</li>
                </ul>
            </div>
            <div>
                <form class="space-y-4" method="post" action="#"
                    onsubmit="event.preventDefault(); this.reset(); alert('Demo only.');">
                    <div class="grid sm:grid-cols-2 gap-4">
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-1">Name</label>
                            <input type="text"
                                class="w-full rounded-md border-gray-300 focus:ring-blue-500 focus:border-blue-500"
                                placeholder="Your Name" required>
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-1">Email</label>
                            <input type="email"
                                class="w-full rounded-md border-gray-300 focus:ring-blue-500 focus:border-blue-500"
                                placeholder="you@example.com" required>
                        </div>
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">Message</label>
                        <textarea rows="4"
                            class="w-full rounded-md border-gray-300 focus:ring-blue-500 focus:border-blue-500"
                            placeholder="How can we help?" required></textarea>
                    </div>
                    <div>
                        <button type="submit"
                            class="px-6 py-3 rounded-md bg-blue-600 hover:bg-blue-500 text-white font-medium transition w-full sm:w-auto">Send
                            Message</button>
                    </div>
                </form>
            </div>
        </div>
    </section>
</x-layouts.guest>