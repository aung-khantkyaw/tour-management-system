<x-layouts.guest :title="($package?->package_name ?? 'Schedule') . ' - Tour Management System'">
    <div class="max-w-7xl mx-auto px-4 py-16">
        <div class="flex flex-col md:flex-row md:items-center md:justify-between gap-4 mb-10">
            <div>
                <h1 class="text-4xl font-bold text-blue-800">
                    {{ $package ? $package->package_name . ' Schedules' : 'Schedule' }}
                </h1>
                @if($package)
                    <p class="text-sm text-gray-600 mt-1">
                        Destination:
                        <span class="font-medium text-gray-800">
                            {{ $package->destination?->destination_name ?? 'Unknown' }}
                        </span>
                        | Duration: {{ $package->duration_days }} days | Capacity: {{ $package->no_of_people }}
                    </p>
                @else
                    <p class="text-sm text-gray-600 mt-1">
                        Upcoming tour departures (next 30 entries). Select a package to filter.
                    </p>
                @endif
            </div>
            <div class="flex gap-3">
                <a href="{{ route('packages') }}"
                    class="inline-flex items-center rounded-md border border-gray-300 bg-white px-4 py-2 text-sm font-medium text-gray-700 shadow-sm hover:bg-gray-100 transition">
                    Packages
                </a>
                @if($package)
                    <a href="{{ route('schedules') }}"
                        class="inline-flex items-center rounded-md bg-blue-600 px-4 py-2 text-sm font-medium text-white shadow hover:bg-blue-500 transition">
                        All Schedules
                    </a>
                @endif
            </div>
        </div>

        <div class="rounded-lg border border-gray-200 bg-white shadow-sm p-6">
            <h2 class="text-2xl font-bold text-blue-700 mb-6">
                {{ $package ? 'Departures for this Package' : 'Upcoming Tours' }}
            </h2>

            <div class="space-y-6">
                @forelse($schedules as $schedule)
                @php($pkg = $schedule->touristPackage)
                <div class="rounded-lg border border-gray-200 p-5 hover:shadow-sm transition bg-white">
                    <div class="flex flex-col md:flex-row md:items-start md:justify-between gap-4">
                        <div class="space-y-1.5">
                            <div class="flex justify-between items-center gap-4">
                                <div>
                                    <h3 class="font-semibold text-lg text-gray-900">
                                        {{ $pkg?->package_name ?? 'Package #' . $schedule->package_id }}
                                    </h3>
                                    <p class="text-blue-600 font-medium text-sm">
                                        {{ \Illuminate\Support\Carbon::parse($schedule->from_date)->format('M d') }} –
                                        {{ \Illuminate\Support\Carbon::parse($schedule->to_date)->format('M d, Y') }}
                                    </p>
                                </div>
                                <div class="text-sm text-gray-500">
                                    {{ $schedule->available_places }} / {{ $pkg?->no_of_people ?? 'N/A' }} places
                                    available
                                </div>
                            </div>
                            <p class="text-gray-600 text-sm">
                                Duration: {{ $pkg?->duration_days ?? 'N/A' }} days ·
                                Capacity: {{ $pkg?->no_of_people ?? 'N/A' }} ·
                                Vehicle: {{ $pkg?->vehicle_type ?? 'N/A' }}
                            </p>
                            <div class="mt-2 flex items-center gap-2 flex-wrap text-xs text-gray-500">
                                @if($schedule->departure_time)
                                    <span
                                        class="inline-flex items-center px-2 py-0.5 rounded-full bg-gray-100 text-gray-700">
                                        Dep:
                                        {{ \Illuminate\Support\Carbon::parse($schedule->departure_time)->format('H:i') }}
                                    </span>
                                @endif
                                @if($schedule->arrival_time)
                                    <span
                                        class="inline-flex items-center px-2 py-0.5 rounded-full bg-gray-100 text-gray-700">
                                        Arr: {{ \Illuminate\Support\Carbon::parse($schedule->arrival_time)->format('H:i') }}
                                    </span>
                                @endif
                                <span
                                    class="inline-flex items-center px-2 py-0.5 rounded-full bg-green-100 text-green-700">
                                    Open
                                </span>
                            </div>
                        </div>
                        <div class="md:text-right flex md:flex-col items-center gap-3">
                            <div class="text-xs text-gray-500">
                                ID: {{ $schedule->schedule_id }}
                            </div>
                            @auth
                                <a href="{{ route('schedule.book', $schedule->schedule_id) }}"
                                    class="inline-flex items-center rounded-md bg-blue-600 px-4 py-2 text-sm font-medium text-white shadow hover:bg-blue-500 transition">
                                    Book
                                </a>
                            @else
                                <a href="{{ route('login') }}"
                                    class="inline-flex items-center rounded-md bg-blue-600 px-4 py-2 text-sm font-medium text-white shadow hover:bg-blue-500 transition">
                                    Login to Book
                                </a>
                            @endauth
                        </div>
                    </div>
                </div>
                @empty
                <p class="text-sm text-gray-500">
                    {{ $package ? 'No schedules for this package yet.' : 'No upcoming schedules found.' }}
                </p>
                @endforelse
            </div>
        </div>
    </div>
</x-layouts.guest>