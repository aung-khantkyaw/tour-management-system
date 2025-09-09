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
            ->orderBy('booking_id', 'desc')
            ->paginate(10);

        return view('admin.bookings.index', compact('bookings'));
    }

    public function show(Booking $booking)
    {
        $booking->load(['user', 'schedule.touristPackage.destination', 'schedule.touristPackage.guide', 'roomChoices.accommodation.hotel', 'roomChoices.accommodation.room']);
        return view('admin.bookings.show', compact('booking'));
    }

    public function updateStatus(Request $request, Booking $booking)
    {
        $request->validate([
            'booking_status' => 'required|in:pending,confirmed,in_progress,completed,cancelled,refunded',
        ]);

        $oldBookingStatus = $booking->booking_status;

        $booking->update([
            'booking_status' => $request->booking_status,
        ]);

        // Restore available places if booking is cancelled
        if ($oldBookingStatus !== 'cancelled' && $request->booking_status === 'cancelled') {
            $this->restoreAvailablePlaces($booking);
        }

        // Reduce available places if booking is reactivated from cancelled state
        if ($oldBookingStatus === 'cancelled' && $request->booking_status !== 'cancelled') {
            $this->reduceAvailablePlaces($booking);
        }

        return redirect()->route('admin.bookings.index')
            ->with('success', 'Booking status updated successfully!');
    }

    private function restoreAvailablePlaces(Booking $booking)
    {
        $schedule = $booking->schedule;

        if ($booking->package_type === 'single') {
            $schedule->increaseAvailablePlaces(1);
        } else { // full package - need to calculate what to restore
            // For full package, restore to the package capacity
            $packageCapacity = $schedule->touristPackage->no_of_people ?? 0;
            $schedule->update(['available_places' => $packageCapacity]);
        }
    }

    private function reduceAvailablePlaces(Booking $booking)
    {
        $schedule = $booking->schedule;

        if ($booking->package_type === 'single') {
            if ($schedule->hasAvailablePlaces(1)) {
                $schedule->reduceAvailablePlaces(1);
            }
        } else { // full package
            $schedule->update(['available_places' => 0]);
        }
    }

    public function destroy(Booking $booking)
    {
        try {
            // Restore available places before deleting
            if ($booking->booking_status !== 'cancelled') {
                $this->restoreAvailablePlaces($booking);
            }

            $booking->roomChoices()->delete();
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