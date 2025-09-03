<?php

namespace App\Http\Controllers;

use App\Models\Schedule;
use App\Models\TouristPackage;
use Illuminate\Http\Request;

class ScheduleController extends Controller
{
    public function index()
    {
        $package = null;
        $schedules = Schedule::with('touristPackage')
            ->whereDate('from_date', '>=', now()->toDateString())
            ->orderBy('from_date')
            ->limit(30)
            ->get();

        return view('livewire.guest.schedule', compact('schedules', 'package'));
    }

    // Schedules for a specific package
    public function package(TouristPackage $package)
    {
        $package->load([
            'destination.hotels',   // hotels for this destination
            'guide',
            'schedules' => fn($q) => $q->orderBy('from_date')
        ]);

        // Upcoming (filter out past)
        $schedules = $package->schedules
            ->filter(fn($s) => \Illuminate\Support\Carbon::parse($s->from_date)->isToday() || \Illuminate\Support\Carbon::parse($s->from_date)->isFuture());

        return view('livewire.guest.package-schedule', [
            'package' => $package,
            'schedules' => $schedules,
        ]);
    }
}