<x-layouts.app :title="__('Dashboard')">
    <div class="min-h-screen bg-gradient-to-br from-slate-50 via-blue-50 to-indigo-50">
        <div class="flex h-full w-full flex-1 flex-col gap-8 p-6">

            <!-- Welcome Header -->
            <div class="text-center py-8">
                <h1 class="text-4xl font-bold bg-gradient-to-r from-blue-600 via-purple-600 to-indigo-600 bg-clip-text text-transparent">
                    Tour Management Dashboard
                </h1>
                <p class="text-gray-600 mt-2 text-lg">Monitor your business performance at a glance</p>
            </div>

            <!-- KPI Row -->
            <div class="grid gap-8 sm:grid-cols-2 xl:grid-cols-4">
            @php
                $cards = [
                    ['label'=>'Total Bookings','value'=>$totalBookings,'gradient'=>'from-blue-500 to-cyan-500','iconBg'=>'bg-blue-100','iconColor'=>'text-blue-600','icon'=>'M3 12l2-2 7-7 7 7 2 2v8a1 1 0 01-1 1h-6V9H9v12H4a1 1 0 01-1-1v-8Z','change'=>'+12%'],
                    ['label'=>'Pending Bookings','value'=>$pendingBookings,'gradient'=>'from-amber-500 to-orange-500','iconBg'=>'bg-amber-100','iconColor'=>'text-amber-600','icon'=>'M12 6v6l4 2','change'=>'+5%'],
                    ['label'=>'Unique Travelers','value'=>$uniqueTravelers,'gradient'=>'from-emerald-500 to-teal-500','iconBg'=>'bg-emerald-100','iconColor'=>'text-emerald-600','icon'=>'M5.5 21a6.5 6.5 0 0113 0M12 11a4 4 0 100-8 4 4 0 000 8z','change'=>'+8%'],
                    ['label'=>'Estimated Revenue','value'=>'$'.number_format($estimatedRevenue,0),'gradient'=>'from-purple-500 to-pink-500','iconBg'=>'bg-purple-100','iconColor'=>'text-purple-600','icon'=>'M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z','change'=>'+15%']
                ];
            @endphp
            @foreach($cards as $c)
                <div class="group relative overflow-hidden rounded-2xl bg-white/80 backdrop-blur-sm border border-white/50 shadow-xl hover:shadow-2xl transition-all duration-500 transform hover:-translate-y-2 p-6">
                    <!-- Animated gradient background -->
                    <div class="absolute inset-0 bg-gradient-to-br {{ $c['gradient'] }} opacity-0 group-hover:opacity-5 transition-opacity duration-500"></div>
                    
                    <!-- Floating orbs -->
                    <div class="absolute -top-4 -right-4 w-20 h-20 bg-gradient-to-br {{ $c['gradient'] }} rounded-full opacity-10 group-hover:opacity-20 transition-opacity duration-500"></div>
                    <div class="absolute -bottom-8 -left-8 w-16 h-16 bg-gradient-to-tr {{ $c['gradient'] }} rounded-full opacity-5 group-hover:opacity-15 transition-opacity duration-500"></div>

                    <div class="relative z-10">
                        <div class="flex items-center justify-between mb-4">
                            <div class="p-3 rounded-xl {{ $c['iconBg'] }} {{ $c['iconColor'] }} group-hover:scale-110 transition-transform duration-300">
                                <svg class="w-6 h-6" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="{{ $c['icon'] }}"/>
                                </svg>
                            </div>
                            <span class="text-xs font-semibold text-emerald-600 bg-emerald-50 px-2 py-1 rounded-full">
                                {{ $c['change'] }}
                            </span>
                        </div>
                        
                        <div class="space-y-2">
                            <p class="text-sm font-medium text-gray-600 tracking-wide">{{ $c['label'] }}</p>
                            <p class="text-3xl font-bold text-gray-900 group-hover:text-transparent group-hover:bg-gradient-to-r group-hover:{{ $c['gradient'] }} group-hover:bg-clip-text transition-all duration-300">
                                {{ $c['value'] }}
                            </p>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>

            <!-- Middle Grid -->
            <div class="grid gap-8 lg:grid-cols-3">

                <!-- Daily Booking Count -->
                <div class="lg:col-span-2 rounded-2xl bg-white/80 backdrop-blur-sm border border-white/50 shadow-xl p-8 hover:shadow-2xl transition-all duration-500">
                    <!-- Header -->
                    <div class="flex items-center justify-between mb-6">
                        <div>
                            <h3 class="text-2xl font-bold text-gray-800 mb-2">Daily Booking Analytics</h3>
                            <p class="text-gray-600">Last 7 days performance • <span class="font-semibold text-blue-600">{{ $weeklyTotal }}</span> total bookings</p>
                        </div>
                        <div class="flex items-center gap-3">
                            <div class="px-4 py-2 bg-gradient-to-r from-blue-500 to-cyan-500 text-white rounded-xl shadow-lg">
                                <div class="flex items-center gap-2">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z"/>
                                    </svg>
                                    <span class="font-semibold">Today: {{ $todayCount }}</span>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Daily Bar Chart -->
                    <div class="h-64 relative bg-gradient-to-br from-slate-50 to-blue-50 rounded-2xl p-6 border border-blue-100">
                        @php
                            $maxCount = max($dailyValues) ?: 1;
                            $chartHeight = 80; // Percentage of container for bars
                        @endphp
                        
                        <!-- Chart container with grid -->
                        <div class="relative h-full">
                            <!-- Background grid with subtle lines -->
                            <div class="absolute inset-0 grid grid-cols-7 gap-2">
                                @foreach($dailyData as $data)
                                    <div class="border-r border-blue-200/50 last:border-r-0"></div>
                                @endforeach
                            </div>
                        
                            <!-- Horizontal grid lines -->
                            <div class="absolute inset-0">
                                @for($i = 1; $i <= 4; $i++)
                                    @php $position = 20 * $i; @endphp
                                    <div class="absolute w-full border-t border-blue-200/30" style="bottom: {{ $position }}%">
                                        <span class="absolute -left-12 -top-3 text-sm font-medium text-gray-600 bg-white/80 px-2 py-1 rounded">{{ round(($maxCount * $i) / 4) }}</span>
                                    </div>
                                @endfor
                            </div>
                        
                            <!-- Average line with glow effect -->
                            @if($dailyAverage > 0)
                                @php $avgPosition = ($dailyAverage / $maxCount) * $chartHeight; @endphp
                                <div class="absolute w-full border-t-3 border-dashed border-purple-500 opacity-70 z-10 shadow-lg" 
                                     style="bottom: {{ $avgPosition }}%; filter: drop-shadow(0 0 8px rgba(168, 85, 247, 0.4));">
                                    <span class="absolute right-2 -top-8 text-sm font-bold text-purple-600 bg-white/90 px-3 py-1.5 rounded-lg shadow-md border border-purple-200">
                                        📊 Avg: {{ $dailyAverage }}
                                    </span>
                                </div>
                            @endif
                        
                            <!-- 3D Bars with enhanced styling -->
                            <div class="flex items-end justify-between h-full space-x-3 relative z-20 pb-12">
                                @foreach($dailyData as $data)
                                    @php
                                        $barHeight = $maxCount > 0 ? ($data['count'] / $maxCount) * $chartHeight : 0;
                                        $barStyle = match(true) {
                                            $data['is_today'] => 'bg-gradient-to-t from-emerald-600 via-emerald-500 to-emerald-400 shadow-2xl shadow-emerald-300/50',
                                            $data['count'] === $peakCount && $peakCount > 0 => 'bg-gradient-to-t from-amber-600 via-amber-500 to-amber-400 shadow-2xl shadow-amber-300/50',
                                            $data['is_weekend'] => 'bg-gradient-to-t from-purple-600 via-purple-500 to-purple-400 shadow-2xl shadow-purple-300/50',
                                            $data['count'] > 0 => 'bg-gradient-to-t from-blue-600 via-cyan-500 to-blue-400 shadow-2xl shadow-blue-300/50',
                                            default => 'bg-gradient-to-t from-gray-500 to-gray-400 shadow-lg shadow-gray-300/50'
                                        };
                                        $minHeight = $data['count'] > 0 ? 10 : 6; // Minimum visible height
                                        $glowColor = match(true) {
                                            $data['is_today'] => 'shadow-emerald-400/60',
                                            $data['count'] === $peakCount && $peakCount > 0 => 'shadow-amber-400/60',
                                            $data['is_weekend'] => 'shadow-purple-400/60',
                                            $data['count'] > 0 => 'shadow-blue-400/60',
                                            default => 'shadow-gray-400/40'
                                        };
                                    @endphp
                                
                                    <div class="flex-1 flex flex-col items-center group">
                                        <!-- 3D Bar with enhanced effects -->
                                        <div class="w-full relative cursor-pointer transform transition-all duration-300 hover:scale-110 hover:-translate-y-2">
                                            <div class="w-full {{ $barStyle }} rounded-t-2xl border-b-4 border-gray-900/30 transition-all duration-500 group-hover:{{ $glowColor }} relative overflow-hidden"
                                                 style="height: {{ max($barHeight, $minHeight) }}%;">
                                                
                                                <!-- Shine effect -->
                                                <div class="absolute inset-0 bg-gradient-to-r from-transparent via-white/20 to-transparent -skew-x-12 transform translate-x-full group-hover:-translate-x-full transition-transform duration-1000"></div>
                                                
                                                <!-- Value label on bar -->
                                                @if($data['count'] > 0)
                                                    <div class="absolute -top-8 left-1/2 transform -translate-x-1/2 text-sm font-bold text-gray-800 bg-white/95 px-3 py-1 rounded-lg shadow-lg border border-gray-200 opacity-0 group-hover:opacity-100 transition-all duration-300 scale-95 group-hover:scale-100">
                                                        {{ $data['count'] }}
                                                    </div>
                                                @endif
                                                
                                                <!-- Side shadow for 3D effect -->
                                                <div class="absolute -right-1 top-1 bottom-1 w-1 bg-black/20 rounded-r-lg"></div>
                                                <div class="absolute -bottom-1 left-1 right-1 h-1 bg-black/20 rounded-b-lg"></div>
                                            </div>
                                        
                                            <!-- Floating Tooltip with glass effect -->
                                            <div class="absolute bottom-full left-1/2 transform -translate-x-1/2 mb-4 px-4 py-3 bg-white/95 backdrop-blur-md border border-white/50 shadow-2xl text-gray-800 text-sm rounded-2xl opacity-0 group-hover:opacity-100 transition-all duration-300 whitespace-nowrap z-40 scale-90 group-hover:scale-100">
                                                <div class="font-bold text-center text-lg mb-1">{{ $data['date'] }}</div>
                                                <div class="text-gray-600 text-center text-xs uppercase tracking-wide">{{ $data['day'] }}</div>
                                                <div class="text-center mt-2 py-2 border-t border-gray-200">
                                                    <span class="font-bold text-2xl bg-gradient-to-r from-blue-600 to-purple-600 bg-clip-text text-transparent">{{ $data['count'] }}</span>
                                                    <span class="text-gray-500 text-xs ml-1"> booking{{ $data['count'] !== 1 ? 's' : '' }}</span>
                                                </div>
                                                @if($data['is_today'])
                                                    <div class="text-emerald-600 text-center font-bold text-xs bg-emerald-50 px-2 py-1 rounded-full mt-2">🎯 TODAY</div>
                                                @elseif($data['is_weekend'])
                                                    <div class="text-purple-600 text-center font-bold text-xs bg-purple-50 px-2 py-1 rounded-full mt-2">🎉 WEEKEND</div>
                                                @endif
                                                @if($data['count'] === $peakCount && $peakCount > 0)
                                                    <div class="text-amber-600 text-center font-bold text-xs bg-amber-50 px-2 py-1 rounded-full mt-2">🔥 PEAK DAY!</div>
                                                @endif
                                                <!-- Tooltip arrow with glow -->
                                                <div class="absolute top-full left-1/2 transform -translate-x-1/2 w-0 h-0 border-x-8 border-x-transparent border-t-8 border-t-white/95 filter drop-shadow-sm"></div>
                                            </div>
                                    </div>
                                    
                                    <!-- Bottom label with badge -->
                                    <div class="mt-2 text-center">
                                        <div class="text-xs font-semibold text-gray-700">{{ $data['date'] }}</div>
                                        <div class="text-xs text-gray-500">{{ $data['day'] }}</div>
                                        @if($data['is_today'])
                                            <span class="inline-block mt-1 px-2 py-0.5 bg-emerald-100 text-emerald-700 text-[10px] font-semibold rounded-full">Today</span>
                                        @elseif($data['count'] === $peakCount && $peakCount > 0)
                                            <span class="inline-block mt-1 px-2 py-0.5 bg-amber-100 text-amber-700 text-[10px] font-semibold rounded-full">Peak</span>
                                        @elseif($data['is_weekend'])
                                            <span class="inline-block mt-1 px-2 py-0.5 bg-purple-100 text-purple-700 text-[10px] font-semibold rounded-full">Weekend</span>
                                        @endif
                                    </div>
                                </div>
                            @endforeach
                        </div>
                        
                        <!-- Y-axis labels -->
                        <!-- <div class="absolute left-0 top-0 h-full flex flex-col justify-between py-4 -ml-10">
                            <span class="text-xs text-gray-500">{{ $maxCount }}</span>
                            <span class="text-xs text-gray-500">{{ round($maxCount * 0.75) }}</span>
                            <span class="text-xs text-gray-500">{{ round($maxCount * 0.5) }}</span>
                            <span class="text-xs text-gray-500">{{ round($maxCount * 0.25) }}</span>
                            <span class="text-xs text-gray-500">0</span>
                        </div> -->
                    </div>
                </div>

                <!-- Day labels -->
                <div class="flex justify-between text-[10px] text-gray-500 mt-2">
                    @foreach($dailyData as $data)
                        <div class="text-center flex-1">
                            <div class="font-medium">{{ $data['date'] }}</div>
                            <div class="mt-0.5">{{ $data['day'] }}</div>
                            @if($data['is_today'])
                                <div class="text-emerald-600 text-[8px] font-semibold">Today</div>
                            @elseif($data['is_weekend'])
                                <div class="text-purple-600 text-[8px]">Weekend</div>
                            @endif
                        </div>
                    @endforeach
                </div>

                <!-- Stats footer -->
                <div class="pt-3 border-t border-gray-100 flex justify-between text-xs text-gray-600">
                    <span>Peak: <strong>{{ $peakCount }}</strong> ({{ $peakDay }})</span>
                    <span>Average: <strong>{{ $dailyAverage }}</strong>/day</span>
                    <span>This Week: <strong>{{ $weeklyTotal }}</strong></span>
                </div>
            </div>

                <!-- Upcoming Schedules -->
                <div class="rounded-2xl bg-white/80 backdrop-blur-sm border border-white/50 shadow-xl p-6 hover:shadow-2xl transition-all duration-500">
                    <div class="flex items-center gap-3 mb-6">
                        <div class="p-2 bg-gradient-to-r from-indigo-500 to-purple-500 rounded-xl">
                            <svg class="w-5 h-5 text-white" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M8 7V3m8 4V3M3 11h18M5 5h14a2 2 0 012 2v12a2 2 0 01-2 2H5a2 2 0 01-2-2V7a2 2 0 012-2z"/>
                            </svg>
                        </div>
                        <h3 class="text-xl font-bold text-gray-800">Upcoming Schedules</h3>
                    </div>
                    <div class="space-y-4">
                        @forelse($upcomingSchedules as $s)
                            <div class="group p-4 rounded-xl bg-gradient-to-r from-slate-50 to-blue-50 border border-blue-100 hover:shadow-lg transition-all duration-300 hover:-translate-y-1">
                                @php
                                    $from = \Illuminate\Support\Carbon::parse($s->from_date);
                                    $to = \Illuminate\Support\Carbon::parse($s->to_date);
                                    $days = \Illuminate\Support\Carbon::now()->diffInDays($from, false);
                                    $badge = $days > 0 ? 'bg-gradient-to-r from-emerald-500 to-teal-500 text-white' : ($days === 0 ? 'bg-gradient-to-r from-amber-500 to-orange-500 text-white' : 'bg-gray-400 text-white');
                                    $label = $days > 0 ? '🚀 in '. $days .' days' : ($days === 0 ? '⚡ today' : '✅ started');
                                @endphp
                                <div class="flex items-start justify-between mb-2">
                                    <div class="flex items-center gap-3">
                                        <div class="p-2 bg-white rounded-lg shadow-sm">
                                            <svg class="w-4 h-4 text-indigo-600" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/>
                                            </svg>
                                        </div>
                                        <div>
                                            <span class="font-semibold text-gray-800 text-sm group-hover:text-indigo-600 transition-colors">
                                                {{ $s->touristPackage?->package_name ?? 'Package #'.$s->package_id }}
                                            </span>
                                        </div>
                                    </div>
                                    <span class="inline-flex items-center rounded-full px-3 py-1 text-xs font-bold {{ $badge }} shadow-lg">
                                        {{ $label }}
                                    </span>
                                </div>
                                <div class="text-xs text-gray-600 bg-white/50 rounded-lg px-3 py-2 flex items-center gap-2">
                                    <svg class="w-4 h-4 text-blue-500" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"/>
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"/>
                                    </svg>
                                    <span class="font-medium">{{ $from->format('M d') }} – {{ $to->format('M d') }}</span>
                                    <span class="text-indigo-600">{{ $s->touristPackage?->destination?->destination_name ?? 'Destination' }}</span>
                                </div>
                            </div>
                        @empty
                            <div class="text-center py-8">
                                <div class="p-4 bg-gray-100 rounded-full w-16 h-16 mx-auto mb-4 flex items-center justify-center">
                                    <svg class="w-8 h-8 text-gray-400" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M8 7V3m8 4V3M3 11h18M5 5h14a2 2 0 012 2v12a2 2 0 01-2 2H5a2 2 0 01-2-2V7a2 2 0 012-2z"/>
                                    </svg>
                                </div>
                                <p class="text-gray-500 text-sm">No upcoming schedules</p>
                            </div>
                        @endforelse
                    </div>
            </div>

                <!-- Top Destinations -->
                <div class="rounded-2xl bg-white/80 backdrop-blur-sm border border-white/50 shadow-xl p-6 hover:shadow-2xl transition-all duration-500">
                    <div class="flex items-center gap-3 mb-6">
                        <div class="p-2 bg-gradient-to-r from-pink-500 to-rose-500 rounded-xl">
                            <svg class="w-5 h-5 text-white" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"/>
                                <path stroke-linecap="round" stroke-linejoin="round" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"/>
                            </svg>
                        </div>
                        <h3 class="text-xl font-bold text-gray-800">Top Destinations</h3>
                    </div>
                    <div class="space-y-4">
                        @forelse($topDestinations as $dest => $cnt)
                            @php 
                                $pct = $totalBookings ? round(($cnt / $totalBookings) * 100) : 0; 
                                $barGradient = $pct >= 60 ? 'from-blue-500 to-cyan-500' : ($pct >= 30 ? 'from-indigo-500 to-purple-500' : 'from-gray-400 to-gray-500');
                                $iconColor = $pct >= 60 ? 'text-blue-500' : ($pct >= 30 ? 'text-indigo-500' : 'text-gray-500');
                            @endphp
                            <div class="group p-4 rounded-xl bg-gradient-to-r from-slate-50 to-blue-50 border border-blue-100 hover:shadow-lg transition-all duration-300 hover:-translate-y-1">
                                <div class="flex items-center justify-between mb-3">
                                    <div class="flex items-center gap-3">
                                        <div class="p-2 bg-white rounded-lg shadow-sm">
                                            <svg class="w-4 h-4 {{ $iconColor }}" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"/>
                                                <path stroke-linecap="round" stroke-linejoin="round" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"/>
                                            </svg>
                                        </div>
                                        <span class="font-semibold text-gray-800 group-hover:text-indigo-600 transition-colors">{{ $dest }}</span>
                                    </div>
                                    <div class="text-right">
                                        <div class="text-lg font-bold text-gray-800">{{ $cnt }}</div>
                                        <div class="text-xs text-gray-500">{{ $pct }}%</div>
                                    </div>
                                </div>
                                <div class="relative">
                                    <div class="h-3 rounded-full bg-gray-200 overflow-hidden">
                                        <div class="h-full rounded-full bg-gradient-to-r {{ $barGradient }} transition-all duration-1000 ease-out shadow-lg" 
                                             style="width: {{ $pct }}%"></div>
                                    </div>
                                    <div class="absolute inset-0 rounded-full bg-gradient-to-r from-white/20 to-transparent"></div>
                                </div>
                            </div>
                        @empty
                            <div class="text-center py-8">
                                <div class="p-4 bg-gray-100 rounded-full w-16 h-16 mx-auto mb-4 flex items-center justify-center">
                                    <svg class="w-8 h-8 text-gray-400" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M9.663 17h4.673M12 3v1m6.364 1.636l-.707.707M21 12h-1M4 12H3m3.343-5.657l-.707-.707m2.828 9.9a5 5 0 117.072 0l-.548.547A3.374 3.374 0 0014 18.469V19a2 2 0 11-4 0v-.531c0-.895-.356-1.754-.988-2.386l-.548-.547z"/>
                                    </svg>
                                </div>
                                <p class="text-gray-500 text-sm">No destination data yet</p>
                            </div>
                        @endforelse
                    </div>
            </div>
        </div>

            <!-- Latest Bookings Table -->
            <div class="rounded-2xl bg-white/80 backdrop-blur-sm border border-white/50 shadow-xl hover:shadow-2xl transition-all duration-500">
                <div class="p-8 flex items-center justify-between border-b border-gray-100">
                    <div class="flex items-center gap-4">
                        <div class="p-3 bg-gradient-to-r from-green-500 to-emerald-500 rounded-xl">
                            <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-3 7h3m-3 4h3m-6-4h.01M9 16h.01"/>
                            </svg>
                        </div>
                        <div>
                            <h3 class="text-2xl font-bold text-gray-800">Latest Bookings</h3>
                            <p class="text-gray-600">Recent activity overview</p>
                        </div>
                    </div>
                </div>
                <div class="overflow-x-auto">
                    <table class="min-w-full">
                        <thead class="bg-gradient-to-r from-slate-100 to-blue-100 backdrop-blur border-b border-blue-200">
                            <tr>
                                <th class="px-6 py-4 text-left text-sm font-bold text-gray-700 uppercase tracking-wider">Booking ID</th>
                                <th class="px-6 py-4 text-left text-sm font-bold text-gray-700 uppercase tracking-wider">Traveler</th>
                                <th class="px-6 py-4 text-left text-sm font-bold text-gray-700 uppercase tracking-wider">Package</th>
                                <th class="px-6 py-4 text-left text-sm font-bold text-gray-700 uppercase tracking-wider">Destination</th>
                                <th class="px-6 py-4 text-left text-sm font-bold text-gray-700 uppercase tracking-wider">Payment</th>
                                <th class="px-6 py-4 text-left text-sm font-bold text-gray-700 uppercase tracking-wider">Status</th>
                                <th class="px-6 py-4 text-left text-sm font-bold text-gray-700 uppercase tracking-wider">Created</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-blue-100/50">
                            @forelse($latestBookings as $b)
                                @php
                                    $nm = trim($b->user?->name ?? '');
                                    if($nm===''||$nm==='_'){
                                        $nm = $b->user?->email ? strtok($b->user->email,'@') : 'Traveler';
                                    }
                                @endphp
                                <tr class="group hover:bg-gradient-to-r hover:from-blue-50 hover:to-indigo-50 transition-all duration-300 hover:shadow-lg">
                                    <td class="px-6 py-4">
                                        <div class="flex items-center gap-3">
                                            <div class="p-2 bg-gradient-to-r from-blue-500 to-cyan-500 rounded-lg shadow-sm">
                                                <svg class="w-4 h-4 text-white" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"/>
                                                </svg>
                                            </div>
                                            <span class="font-bold text-gray-800 group-hover:text-blue-600 transition-colors">
                                                BK-{{ str_pad($b->booking_id,6,'0',STR_PAD_LEFT) }}
                                            </span>
                                        </div>
                                    </td>
                                    <td class="px-6 py-4">
                                        <div class="flex items-center gap-3">
                                            <div class="w-8 h-8 bg-gradient-to-r from-purple-500 to-pink-500 rounded-full flex items-center justify-center text-white font-bold text-sm">
                                                {{ strtoupper(substr($nm, 0, 1)) }}
                                            </div>
                                            <span class="font-medium text-gray-800">{{ ucfirst($nm) }}</span>
                                        </div>
                                    </td>
                                    <td class="px-6 py-4 text-gray-700 font-medium">
                                        {{ $b->schedule->touristPackage?->package_name ?? '—' }}
                                    </td>
                                    <td class="px-6 py-4">
                                        <div class="flex items-center gap-2 text-gray-600">
                                            <svg class="w-4 h-4 text-rose-500" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"/>
                                                <path stroke-linecap="round" stroke-linejoin="round" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"/>
                                            </svg>
                                            {{ $b->schedule->touristPackage?->destination?->destination_name ?? '—' }}
                                        </div>
                                    </td>
                                    <td class="px-6 py-4">
                                        <span class="inline-flex items-center rounded-full bg-gradient-to-r from-blue-100 to-cyan-100 px-3 py-1 text-sm font-semibold text-blue-800 shadow-sm">
                                            <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" d="M3 10h18M7 15h1m4 0h1m-7 4h12a3 3 0 003-3V8a3 3 0 00-3-3H6a3 3 0 00-3 3v8a3 3 0 003 3z"/>
                                            </svg>
                                            {{ $b->payment_method ?? '—' }}
                                        </span>
                                    </td>
                                    <td class="px-6 py-4">
                                        @php
                                            $statusConfig = match($b->booking_status){
                                                'pending' => ['gradient' => 'from-amber-500 to-orange-500', 'icon' => 'M12 6v6l4 2'],
                                                'approved' => ['gradient' => 'from-emerald-500 to-teal-500', 'icon' => 'M5 13l4 4L19 7'],
                                                'cancelled' => ['gradient' => 'from-rose-500 to-red-500', 'icon' => 'M6 18L18 6M6 6l12 12'],
                                                default => ['gradient' => 'from-gray-500 to-gray-400', 'icon' => 'M12 6v6l4 2']
                                            };
                                        @endphp
                                        <span class="inline-flex items-center rounded-full bg-gradient-to-r {{ $statusConfig['gradient'] }} px-3 py-1 text-sm font-bold text-white shadow-lg">
                                            <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" d="{{ $statusConfig['icon'] }}"/>
                                            </svg>
                                            {{ ucfirst($b->booking_status ?? '—') }}
                                        </span>
                                    </td>
                                    <td class="px-6 py-4 text-gray-500 text-sm">
                                        <div class="flex items-center gap-2">
                                            <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/>
                                            </svg>
                                            {{ $b->created_at?->diffForHumans() }}
                                        </div>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="7" class="px-6 py-16 text-center">
                                        <div class="flex flex-col items-center gap-4">
                                            <div class="p-6 bg-gray-100 rounded-full">
                                                <svg class="w-12 h-12 text-gray-400" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"/>
                                                </svg>
                                            </div>
                                            <div>
                                                <h3 class="text-lg font-semibold text-gray-600">No bookings yet</h3>
                                                <p class="text-gray-500 text-sm">Your recent bookings will appear here</p>
                                            </div>
                                        </div>
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>

        </div>
    </div>
</x-layouts.app>