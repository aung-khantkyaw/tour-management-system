<x-layouts.guest :title="$destination->destination_name . ' Packages - Tour Management System'">
    <div class="max-w-7xl mx-auto px-4 py-16">
        <div class="mb-10">
            <a href="{{ route('destinations') }}" class="text-sm text-blue-600 hover:underline">&larr; All
                Destinations</a>
            <h1 class="text-4xl font-bold text-blue-800 mt-2">
                {{ $destination->destination_name }} Packages
            </h1>
            <p class="text-sm text-gray-600 mt-2">
                City: <span class="font-medium text-gray-800">{{ $destination->city }}</span> ·
                Hotels: {{ $destination->hotels_count }} ·
                Packages: {{ $destination->tourist_packages_count }}
            </p>
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
                                    <span class="font-medium text-gray-900">{{ $p->schedules()->count() }}</span>
                                </p>
                            </div>
                            <div class="mt-auto pt-4 border-t border-gray-100">
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