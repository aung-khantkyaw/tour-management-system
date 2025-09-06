<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Booking;
use App\Models\Schedule;
use Illuminate\Http\Request;

class BookingController extends Controller
{
    public function index()
    {
        $bookings = Booking::with(['user', 'schedule.touristPackage.destination', 'schedule.touristPackage.guide'])
            ->latest()
            ->paginate(10);

        return view('admin.bookings.index', compact('bookings'));
    }

    public function show(Booking $booking)
    {
        $booking->load(['user', 'schedule.touristPackage.destination', 'schedule.touristPackage.guide', 'roomChoices']);
        return view('admin.bookings.show', compact('booking'));
    }

    public function updateStatus(Request $request, Booking $booking)
    {
        $request->validate([
            'payment_status' => 'required|in:pending,confirmed,cancelled,refunded',
            'package_status' => 'required|in:pending,confirmed,in_progress,completed,cancelled',
        ]);

        $booking->update([
            'payment_status' => $request->payment_status,
            'package_status' => $request->package_status,
        ]);

        return redirect()->route('admin.bookings.index')
            ->with('success', 'Booking status updated successfully!');
    }

    public function destroy(Booking $booking)
    {
        try {
            $booking->delete();
            return redirect()->route('admin.bookings.index')
                ->with('success', 'Booking deleted successfully!');
        } catch (\Exception $e) {
            return redirect()->route('admin.bookings.index')
                ->with('error', 'Cannot delete booking.');
        }
    }

    public function delete(Booking $booking)
    {
        return view('admin.bookings.delete', compact('booking'));
    }
}