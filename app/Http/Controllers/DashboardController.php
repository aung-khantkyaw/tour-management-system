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
        $totalBookings     = Booking::count();
        $pendingBookings   = Booking::where('booking_status', 'pending')->count();
        $uniqueTravelers   = Booking::distinct('user_id')->count('user_id');
        $totalHotels       = Hotel::count();
        $totalUsers        = User::count();

        // Upcoming schedules (next 30 days)
        $upcomingSchedules = Schedule::with('touristPackage.destination')
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

        // Basic trend (bookings per day last 7 days)
        $last7 = Booking::whereDate('created_at', '>=', now()->subDays(6)->startOfDay())
            ->selectRaw('DATE(created_at) as d, COUNT(*) c')
            ->groupBy('d')
            ->orderBy('d')
            ->pluck('c', 'd');

        $trendLabels = [];
        $trendValues = [];
        for ($i = 6; $i >= 0; $i--) {
            $day = now()->subDays($i)->format('Y-m-d');
            $trendLabels[] = Carbon::parse($day)->format('d M');
            $trendValues[] = (int)($last7[$day] ?? 0);
        }

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
            'trendLabels',
            'trendValues',
            'topDestinations'
        ));
    }
}