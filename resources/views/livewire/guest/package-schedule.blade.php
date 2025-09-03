<x-layouts.guest :title="$package->package_name . ' - Package Details & Schedule - Tour Management System'">
    <div class="max-w-7xl mx-auto px-4 py-16 space-y-14">
        @php($destination = $package->destination)
        @php($hotels = $destination?->hotels ?? collect())

        <!-- Unified Details Card -->
        <div class="rounded-xl border border-gray-200 bg-white shadow-sm overflow-hidden">
            <div class="flex flex-col md:flex-row">
                <!-- Destination Image / Initial -->
                <div class="md:w-1/3 h-56 md:h-auto relative">
                    @if($destination?->image_path)
                        <img src="{{ asset($destination->image_path) }}" alt="{{ $destination->destination_name }}"
                            class="h-full w-full object-cover">
                    @else
                        <div
                            class="h-full w-full flex items-center justify-center bg-gradient-to-br from-blue-500/70 to-indigo-600/70 text-white text-6xl font-semibold">
                            {{ strtoupper(substr($destination->destination_name ?? $package->package_name, 0, 1)) }}
                        </div>
                    @endif
                </div>

                <!-- Details Body -->
                <div class="flex-1 p-8">
                    <div class="flex flex-col lg:flex-row lg:items-start lg:justify-between gap-6">
                        <div class="space-y-3">
                            <h1 class="text-3xl font-bold text-gray-900">{{ $package->package_name }}</h1>
                            <p class="text-sm text-gray-600 leading-relaxed">
                                {{ $destination?->description ?: 'No destination description available.' }}
                            </p>
                        </div>
                        <div class="flex gap-3">
                            <a href="{{ route('packages') }}"
                                class="inline-flex items-center rounded-md border border-gray-300 bg-white px-4 py-2 text-sm font-medium text-gray-700 shadow-sm hover:bg-gray-100 transition">
                                All Packages
                            </a>
                            <a href="{{ route('schedules') }}"
                                class="inline-flex items-center rounded-md bg-blue-600 px-4 py-2 text-sm font-medium text-white shadow hover:bg-blue-500 transition">
                                All Schedules
                            </a>
                        </div>
                    </div>

                    <!-- Meta Sections -->
                    <div class="mt-8 grid md:grid-cols-3 gap-8">
                        <!-- Destination -->
                        <div>
                            <h2 class="text-sm font-semibold tracking-wide text-gray-900 mb-3 uppercase">Destination
                            </h2>
                            <dl class="space-y-1.5 text-sm">
                                <div class="flex justify-between">
                                    <dt class="text-gray-500">Name</dt>
                                    <dd class="font-medium text-gray-900">{{ $destination?->destination_name ?? '—' }}
                                    </dd>
                                </div>
                                <div class="flex justify-between">
                                    <dt class="text-gray-500">City</dt>
                                    <dd class="font-medium text-gray-900 capitalize">{{ $destination?->city ?? '—' }}
                                    </dd>
                                </div>
                                <div class="flex justify-between">
                                    <dt class="text-gray-500">Hotels</dt>
                                    <dd class="font-medium text-gray-900">{{ $hotels->count() }}</dd>
                                </div>
                                <div class="flex justify-between">
                                    <dt class="text-gray-500">Packages</dt>
                                    <dd class="font-medium text-gray-900">
                                        {{ $destination?->touristPackages?->count() ?? 0 }}
                                    </dd>
                                </div>
                            </dl>
                        </div>

                        <!-- Guide -->
                        <div>
                            <h2 class="text-sm font-semibold tracking-wide text-gray-900 mb-3 uppercase">Guide</h2>
                            @if($package->guide)
                                <dl class="space-y-1.5 text-sm">
                                    <div class="flex justify-between">
                                        <dt class="text-gray-500">Name</dt>
                                        <dd class="font-medium text-gray-900">
                                            {{ $package->guide->gname ?? $package->guide->name }}
                                        </dd>
                                    </div>
                                    <div class="flex justify-between">
                                        <dt class="text-gray-500">Phone</dt>
                                        <dd class="font-medium text-gray-900">
                                            {{ $package->guide->phone ?? 'N/A' }}
                                        </dd>
                                    </div>
                                    <div class="flex justify-between">
                                        <dt class="text-gray-500">Email</dt>
                                        <dd class="font-medium text-gray-900">
                                            {{ $package->guide->email ?? 'N/A' }}
                                        </dd>
                                    </div>
                                </dl>
                            @else
                                <p class="text-sm text-gray-500">No guide assigned.</p>
                            @endif
                        </div>

                        <!-- Package -->
                        <div>
                            <h2 class="text-sm font-semibold tracking-wide text-gray-900 mb-3 uppercase">Package</h2>
                            <dl class="space-y-1.5 text-sm">
                                <div class="flex justify-between">
                                    <dt class="text-gray-500">Duration</dt>
                                    <dd class="font-medium text-gray-900">{{ $package->duration_days }} days</dd>
                                </div>
                                <div class="flex justify-between">
                                    <dt class="text-gray-500">Capacity</dt>
                                    <dd class="font-medium text-gray-900">{{ $package->no_of_people }}</dd>
                                </div>
                                <div class="flex justify-between">
                                    <dt class="text-gray-500">Vehicle</dt>
                                    <dd class="font-medium text-gray-900">{{ $package->vehicle_type ?? 'N/A' }}</dd>
                                </div>
                                <div class="flex justify-between">
                                    <dt class="text-gray-500">Single Fee</dt>
                                    <dd class="font-semibold text-gray-900">
                                        ${{ number_format($package->singlepackage_fee, 2) }}</dd>
                                </div>
                                <div class="flex justify-between">
                                    <dt class="text-gray-500">Group Fee</dt>
                                    <dd class="font-semibold text-gray-900">
                                        ${{ number_format($package->fullpackage_fee, 2) }}</dd>
                                </div>
                            </dl>
                        </div>
                    </div>

                    <!-- Hotels Inline -->
                    <div class="mt-10">
                        <h2 class="text-sm font-semibold tracking-wide text-gray-900 mb-4 uppercase">Hotels</h2>
                        @if($hotels->isEmpty())
                            <p class="text-sm text-gray-500">No hotels linked to this destination.</p>
                        @else
                        <div class="grid sm:grid-cols-2 lg:grid-cols-3 gap-4">
                            @foreach($hotels->take(6) as $hotel)
                            <div
                                class="rounded-lg border border-gray-200 bg-white p-4 shadow-sm hover:shadow transition">
                                <h3 class="font-medium text-gray-900 text-sm">
                                    {{ $hotel->hotel_name ?? $hotel->name }}
                                </h3>

                                @php($rating = (float) ($hotel->rating ?? 0))
                                <div class="mt-2 flex items-center gap-2">
                                    <div class="flex">
                                        @for($i = 1; $i <= 5; $i++)
                                            <svg class="h-4 w-4 {{ $rating >= $i ? 'text-yellow-400' : 'text-gray-300' }}"
                                                viewBox="0 0 20 20" fill="currentColor" aria-hidden="true">
                                                <path
                                                    d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 0 0 .95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.802 2.038a1 1 0 0 0-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118L11 14.347a1 1 0 0 0-1.175 0L7.615 16.285c-.785.57-1.84-.197-1.54-1.118l1.07-3.292a1 1 0 0 0-.364-1.118L3.98 8.72c-.783-.57-.38-1.81.588-1.81H8.03a1 1 0 0 0 .95-.69l1.07-3.292Z" />
                                            </svg>
                                        @endfor
                                    </div>
                                    <span class="text-xs text-gray-600">
                                        {{ $rating > 0 ? number_format($rating, 1) : 'No rating' }}
                                    </span>
                                </div>

                                <p class="mt-2 text-xs text-gray-500">
                                    {{ $hotel->contact_no ?? $hotel->phone ?? '—' }}
                                </p>
                            </div>
                            @endforeach
                        </div>
                        @if($hotels->count() > 6)
                            <p class="mt-3 text-xs text-gray-500">
                                Showing 6 of {{ $hotels->count() }} hotels.
                            </p>
                        @endif
                        @endif
                    </div>
                </div>
            </div>
        </div>

        <!-- Available Schedules -->
        <div id="available-schedules" class="scroll-mt-20">
            <h2 class="text-2xl font-bold text-blue-800 mb-6">Available Schedules</h2>
            @if($schedules->isEmpty())
                <p class="text-sm text-gray-500">No upcoming schedules for this package.</p>
            @else
                <div class="grid md:grid-cols-2 xl:grid-cols-3 gap-6">
                    @foreach($schedules as $schedule)
                        <div
                            class="rounded-lg border border-gray-200 bg-white p-5 shadow-sm hover:shadow transition flex flex-col">
                            <div class="space-y-1">
                                <h3 class="font-semibold text-gray-900">
                                    {{ \Illuminate\Support\Carbon::parse($schedule->from_date)->format('M d, Y') }}
                                </h3>
                                <p class="text-xs text-gray-600">
                                    {{ \Illuminate\Support\Carbon::parse($schedule->from_date)->format('M d') }} –
                                    {{ \Illuminate\Support\Carbon::parse($schedule->to_date)->format('M d, Y') }}
                                </p>
                                <div class="flex flex-wrap gap-1.5 mt-2 text-[11px]">
                                    @if($schedule->departure_time)
                                        <span class="px-2 py-0.5 rounded-full bg-gray-100 text-gray-700">
                                            Dep {{ \Illuminate\Support\Carbon::parse($schedule->departure_time)->format('H:i') }}
                                        </span>
                                    @endif
                                    @if($schedule->arrival_time)
                                        <span class="px-2 py-0.5 rounded-full bg-gray-100 text-gray-700">
                                            Arr {{ \Illuminate\Support\Carbon::parse($schedule->arrival_time)->format('H:i') }}
                                        </span>
                                    @endif
                                    <span class="px-2 py-0.5 rounded-full bg-green-100 text-green-700">
                                        Open
                                    </span>
                                    <span class="px-2 py-0.5 rounded-full bg-gray-100 text-gray-600">
                                        #{{ $schedule->schedule_id }}
                                    </span>
                                </div>
                            </div>
                            <div class="mt-4 pt-4 border-t border-gray-100">
                                @auth
                                    <a href="{{ route('schedule.book', $schedule->schedule_id) }}"
                                        class="inline-flex items-center rounded-md bg-blue-600 px-3 py-2 text-xs font-medium text-white shadow hover:bg-blue-500 transition">
                                        Book
                                    </a>
                                @else
                                    <a href="{{ route('login') }}"
                                        class="inline-flex items-center rounded-md bg-blue-600 px-3 py-2 text-xs font-medium text-white shadow hover:bg-blue-500 transition">
                                        Login to Book
                                    </a>
                                @endauth
                            </div>
                        </div>
                    @endforeach
                </div>
            @endif
        </div>
    </div>
</x-layouts.guest>