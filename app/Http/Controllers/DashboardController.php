<?php

namespace App\Http\Controllers;

use App\Models\Booking;
use App\Models\Schedule;
use App\Models\Hotel;
use App\Models\User;
use Illuminate\Support\Carbon;

class DashboardController extends Controller
{
    public function __invoke()
    {
        $totalBookings = Booking::count();
        $pendingBookings = Booking::where('booking_status', 'pending')->count();
        $uniqueTravelers = Booking::distinct('user_id')->count('user_id');
        $totalHotels = Hotel::count();
        $totalUsers = User::count();

        // Upcoming schedules (next 30 days)
        $upcomingSchedules = Schedule::with('touristPackage.destination')
            ->where('available_places', '>', 0)
            ->whereDate('from_date', '>=', today())
            ->orderBy('from_date')
            ->limit(5)
            ->get();

        // Latest bookings
        $latestBookings = Booking::with([
            'user',
            'schedule.touristPackage.destination',
            'roomChoices.accommodation.hotel'
        ])->latest('booking_id')->limit(8)->get();

        // Daily booking counts (last 7 days)
        $dailyBookings = Booking::whereDate('created_at', '>=', now()->subDays(6)->startOfDay())
            ->selectRaw('DATE(created_at) as date, COUNT(*) as count')
            ->groupBy('date')
            ->orderBy('date')
            ->pluck('count', 'date');

        $dailyLabels = [];
        $dailyValues = [];
        $dailyData = [];

        for ($i = 6; $i >= 0; $i--) {
            $date = now()->subDays($i)->format('Y-m-d');
            $dayName = Carbon::parse($date)->format('D');
            $dayShort = Carbon::parse($date)->format('d M');
            $count = (int) ($dailyBookings[$date] ?? 0);

            $dailyLabels[] = $dayShort;
            $dailyValues[] = $count;
            $dailyData[] = [
                'day' => $dayName,
                'date' => $dayShort,
                'full_date' => $date,
                'count' => $count,
                'is_today' => $date === now()->format('Y-m-d'),
                'is_weekend' => in_array(Carbon::parse($date)->dayOfWeek, [0, 6])
            ];
        }

        // Calculate basic stats
        $weeklyTotal = array_sum($dailyValues);
        $dailyAverage = $weeklyTotal > 0 ? round($weeklyTotal / count($dailyValues), 1) : 0;
        $peakCount = max($dailyValues);
        $peakDay = $peakCount > 0 ? $dailyData[array_search($peakCount, $dailyValues)]['day'] ?? 'N/A' : 'N/A';
        $todayCount = $dailyData[array_search(true, array_column($dailyData, 'is_today'))]['count'] ?? 0;

        // Estimated revenue (lightweight; adjust if large dataset)
        $estimatedRevenue = Booking::with(['schedule.touristPackage', 'roomChoices.accommodation'])
            ->get()
            ->sum(function ($b) {
                $pkg = $b->schedule->touristPackage;
                $packageFee = $pkg?->singlepackage_fee ?? $pkg?->fullpackage_fee ?? 0;
                $roomFee = $b->roomChoices->first()?->accommodation?->price
                    ?? $b->roomChoices->first()?->accommodation?->rate
                    ?? 0;
                return $packageFee + $roomFee;
            });

        // Top destinations (by bookings)
        $topDestinations = Booking::with('schedule.touristPackage.destination')
            ->get()
            ->groupBy(fn($b) => $b->schedule->touristPackage?->destination?->destination_name ?? 'Unknown')
            ->map->count()
            ->sortDesc()
            ->take(5);

        return view('dashboard', compact(
            'totalBookings',
            'pendingBookings',
            'uniqueTravelers',
            'totalHotels',
            'totalUsers',
            'estimatedRevenue',
            'upcomingSchedules',
            'latestBookings',
            'dailyLabels',
            'dailyValues',
            'dailyData',
            'weeklyTotal',
            'dailyAverage',
            'peakCount',
            'peakDay',
            'todayCount',
            'topDestinations'
        ));
    }
}