<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Schedule;
use App\Models\TouristPackage;
use Illuminate\Http\Request;

class ScheduleController extends Controller
{
    public function index()
    {
        $schedules = Schedule::with(['touristPackage.destination', 'touristPackage.guide'])
            ->withCount('bookings')
            ->paginate(10);

        return view('admin.schedules.index', compact('schedules'));
    }

    public function create()
    {
        $packages = TouristPackage::with(['destination', 'guide'])->get();
        
        return view('admin.schedules.create', compact('packages'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'package_id' => 'required|exists:tourist_packages,package_id',
            'from_date' => 'required|date|after_or_equal:today',
            'to_date' => 'required|date|after:from_date',
            'departure_time' => 'required|string|max:50',
            'arrival_time' => 'required|string|max:50',
        ]);

        Schedule::create($request->all());

        return redirect()->route('admin.schedules.index')
            ->with('success', 'Schedule created successfully!');
    }

    public function edit(Schedule $schedule)
    {
        $packages = TouristPackage::with(['destination', 'guide'])->get();
        
        return view('admin.schedules.edit', compact('schedule', 'packages'));
    }

    public function update(Request $request, Schedule $schedule)
    {
        $request->validate([
            'package_id' => 'required|exists:tourist_packages,package_id',
            'from_date' => 'required|date',
            'to_date' => 'required|date|after:from_date',
            'departure_time' => 'required|string|max:50',
            'arrival_time' => 'required|string|max:50',
        ]);

        $schedule->update($request->all());

        return redirect()->route('admin.schedules.index')
            ->with('success', 'Schedule updated successfully!');
    }

    public function destroy(Schedule $schedule)
    {
        try {
            $schedule->delete();
            return redirect()->route('admin.schedules.index')
                ->with('success', 'Schedule deleted successfully!');
        } catch (\Exception $e) {
            return redirect()->route('admin.schedules.index')
                ->with('error', 'Cannot delete schedule. It may have associated bookings.');
        }
    }

    public function delete(Schedule $schedule)
    {
        return view('admin.schedules.delete', compact('schedule'));
    }
}