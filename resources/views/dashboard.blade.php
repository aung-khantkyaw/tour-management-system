<x-layouts.app :title="__('Dashboard')">
    <div class="flex h-full w-full flex-1 flex-col gap-8">

        <!-- KPI Row -->
        <div class="grid gap-6 sm:grid-cols-2 xl:grid-cols-4">
            @php
                $cards = [
                    ['label'=>'Total Bookings','value'=>$totalBookings,'accent'=>'bg-blue-50 text-blue-700','icon'=>'M3 12l2-2 7-7 7 7 2 2v8a1 1 0 01-1 1h-6V9H9v12H4a1 1 0 01-1-1v-8Z'],
                    ['label'=>'Pending Packages','value'=>$pendingPackages,'accent'=>'bg-amber-50 text-amber-700','icon'=>'M12 6v6l4 2'],
                    ['label'=>'Unique Travelers','value'=>$uniqueTravelers,'accent'=>'bg-emerald-50 text-emerald-700','icon'=>'M5.5 21a6.5 6.5 0 0113 0M12 11a4 4 0 100-8 4 4 0 000 8z'],
                    ['label'=>'Estimated Revenue','value'=>'$'.number_format($estimatedRevenue,0),'accent'=>'bg-indigo-50 text-indigo-700','icon'=>'M3 12h18M3 6h18M3 18h18']
                ];
            @endphp
            @foreach($cards as $c)
                <div class="relative overflow-hidden rounded-xl border border-gray-200 bg-white shadow-sm p-5 flex flex-col gap-4">
                    <div class="flex items-center justify-between">
                        <p class="text-xs font-medium uppercase tracking-wide text-gray-500">{{ $c['label'] }}</p>
                        <span class="inline-flex items-center justify-center rounded-md {{ $c['accent'] }} px-2 py-1 text-[10px] font-semibold">
                            <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" d="{{ $c['icon'] }}"/>
                            </svg>
                        </span>
                    </div>
                    <div class="text-2xl font-semibold text-gray-800">
                        {{ $c['value'] }}
                    </div>
                </div>
            @endforeach
        </div>

        <!-- Middle Grid -->
        <div class="grid gap-6 lg:grid-cols-3">

            <!-- Bookings Trend -->
            <div class="rounded-xl border border-gray-200 bg-white shadow-sm p-6 flex flex-col gap-4">
                <div class="flex items-center justify-between">
                    <h3 class="text-sm font-semibold text-gray-800">Bookings (7 Days)</h3>
                </div>
                <div class="h-32">
                    @php
                        $max = max($trendValues) ?: 1;
                        $points = [];
                        $w = 100; $h = 60; $step = $w / (max(count($trendValues)-1,1));
                        foreach($trendValues as $i=>$v){
                            $x = $i * $step;
                            $y = $h - ($v / $max) * $h;
                            $points[] = $x.','.$y;
                        }
                        $polyline = implode(' ', $points);
                        $lastPoint = last($points);          // last() works on arrays in Laravel
                    @endphp
                    <svg viewBox="0 0 100 60" class="w-full h-full stroke-blue-500 fill-blue-200/40">
                        @if(count($points) > 1)
                            <polyline points="{{ $polyline }}" stroke-width="2" fill="none" stroke-linejoin="round" stroke-linecap="round"/>
                            <polygon points="{{ $polyline }} {{ $lastPoint }} 100,60 0,60" opacity=".35"/>
                        @endif
                    </svg>
                    <div class="mt-2 flex justify-between text-[10px] text-gray-500">
                        @foreach($trendLabels as $l)
                            <span>{{ $l }}</span>
                        @endforeach
                    </div>
                </div>
            </div>

            <!-- Upcoming Schedules -->
            <div class="rounded-xl border border-gray-200 bg-white shadow-sm p-6 flex flex-col gap-4">
                <h3 class="text-sm font-semibold text-gray-800">Upcoming Schedules</h3>
                <ul class="divide-y divide-gray-200 text-sm">
                    @forelse($upcomingSchedules as $s)
                        <li class="py-3 flex flex-col">
                            <span class="font-medium text-gray-800">
                                {{ $s->touristPackage?->package_name ?? 'Package #'.$s->package_id }}
                            </span>
                            <span class="text-xs text-gray-500">
                                {{ \Illuminate\Support\Carbon::parse($s->from_date)->format('M d') }} – {{ \Illuminate\Support\Carbon::parse($s->to_date)->format('M d') }}
                                · {{ $s->touristPackage?->destination?->destination_name ?? 'Destination' }}
                            </span>
                        </li>
                    @empty
                        <li class="py-3 text-xs text-gray-500">No upcoming schedules.</li>
                    @endforelse
                </ul>
            </div>

            <!-- Top Destinations -->
            <div class="rounded-xl border border-gray-200 bg-white shadow-sm p-6 flex flex-col gap-4">
                <h3 class="text-sm font-semibold text-gray-800">Top Destinations</h3>
                <ul class="space-y-3 text-sm">
                    @forelse($topDestinations as $dest => $cnt)
                        @php $pct = $totalBookings ? round(($cnt / $totalBookings) * 100) : 0; @endphp
                        <li>
                            <div class="flex items-center justify-between">
                                <span class="font-medium text-gray-700">{{ $dest }}</span>
                                <span class="text-xs text-gray-500">{{ $cnt }} ({{ $pct }}%)</span>
                            </div>
                            <div class="mt-1 h-1.5 rounded bg-gray-100">
                                <div class="h-full rounded bg-blue-500" style="width: {{ $pct }}%"></div>
                            </div>
                        </li>
                    @empty
                        <li class="text-xs text-gray-500">No data.</li>
                    @endforelse
                </ul>
            </div>
        </div>

        <!-- Latest Bookings Table -->
        <div class="rounded-xl border border-gray-200 bg-white shadow-sm">
            <div class="p-6 flex items-center justify-between">
                <h3 class="text-sm font-semibold text-gray-800">Latest Bookings</h3>
            </div>
            <div class="overflow-x-auto">
                <table class="min-w-full text-sm">
                    <thead class="bg-gray-50 text-xs uppercase text-gray-500 tracking-wide">
                        <tr>
                            <th class="px-4 py-2 text-left font-medium">Booking #</th>
                            <th class="px-4 py-2 text-left font-medium">Traveler</th>
                            <th class="px-4 py-2 text-left font-medium">Package</th>
                            <th class="px-4 py-2 text-left font-medium">Destination</th>
                            <th class="px-4 py-2 text-left font-medium">Payment</th>
                            <th class="px-4 py-2 text-left font-medium">Status</th>
                            <th class="px-4 py-2 text-left font-medium">Created</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-200">
                        @forelse($latestBookings as $b)
                            @php
                                $nm = trim($b->user?->name ?? '');
                                if($nm===''||$nm==='_'){
                                    $nm = $b->user?->email ? strtok($b->user->email,'@') : 'Traveler';
                                }
                            @endphp
                            <tr class="hover:bg-gray-50">
                                <td class="px-4 py-2 font-medium text-gray-800">BK-{{ str_pad($b->booking_id,6,'0',STR_PAD_LEFT) }}</td>
                                <td class="px-4 py-2 text-gray-700">{{ ucfirst($nm) }}</td>
                                <td class="px-4 py-2 text-gray-700">
                                    {{ $b->schedule->touristPackage?->package_name ?? '—' }}
                                </td>
                                <td class="px-4 py-2 text-gray-500">
                                    {{ $b->schedule->touristPackage?->destination?->destination_name ?? '—' }}
                                </td>
                                <td class="px-4 py-2">
                                    <span class="inline-flex items-center rounded-md bg-blue-50 px-2 py-0.5 text-[11px] font-medium text-blue-700">
                                        {{ $b->payment_status ?? '—' }}
                                    </span>
                                </td>
                                <td class="px-4 py-2">
                                    @php
                                        $clr = match($b->package_status){
                                            'pending'=>'bg-amber-50 text-amber-700',
                                            'approved'=>'bg-emerald-50 text-emerald-700',
                                            'cancelled'=>'bg-rose-50 text-rose-700',
                                            default=>'bg-gray-100 text-gray-600'
                                        };
                                    @endphp
                                    <span class="inline-flex items-center rounded-md px-2 py-0.5 text-[11px] font-medium {{ $clr }}">
                                        {{ $b->package_status ?? '—' }}
                                    </span>
                                </td>
                                <td class="px-4 py-2 text-gray-500">
                                    {{ $b->created_at?->diffForHumans() }}
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="7" class="px-4 py-8 text-center text-xs text-gray-500">
                                    No bookings yet.
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>

    </div>
</x-layouts.app>