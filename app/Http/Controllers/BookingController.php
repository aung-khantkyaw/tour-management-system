<?php

namespace App\Http\Controllers;

use App\Models\Booking;
use App\Models\Schedule;
use App\Models\Hotel;
use App\Models\RoomChoice;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class BookingController extends Controller
{
    public function create(Schedule $schedule)
    {
        // Check if schedule has available places
        if ($schedule->available_places <= 0) {
            return redirect()->route('schedules')
                ->with('error', 'This schedule is fully booked and no longer accepting new bookings.');
        }

        $schedule->load('touristPackage.destination');

        $destinationId = optional($schedule->touristPackage?->destination)->destination_id;

        $hotels = Hotel::with(['accommodations.room'])
            ->where('destination_id', $destinationId)
            ->orderBy('name')
            ->get();

        $packagePrice = $schedule->touristPackage?->singlepackage_fee
            ?? $schedule->touristPackage?->fullpackage_fee
            ?? 0;
        return view('livewire.guest.booking', compact('schedule', 'hotels', 'packagePrice'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'schedule_id' => 'required|exists:schedules,schedule_id',
            'hotel_id' => 'required|exists:hotels,hotel_id',
            'accom_id' => 'required|exists:accommodations,accom_id',
            'phone' => 'required|string|max:50',
            'nationality' => 'nullable|string|max:100',
            'address' => 'nullable|string|max:255',
            'special_request' => 'nullable|string|max:500',
            'payment_method' => 'required|in:KBZPay,AyarPay,UABPay',
            'payment_transaction_id' => 'required|string|regex:/^[0-9]{20}$/',
            'calculated_total' => 'required|numeric|min:0',
            'package_type' => 'required|in:single,full',
        ]);

        // Get the schedule and check available places
        $schedule = Schedule::findOrFail($validated['schedule_id']);

        // Check capacity based on package type
        if ($validated['package_type'] === 'single') {
            if (!$schedule->hasAvailablePlaces(1)) {
                return back()->withErrors(['package_type' => 'No available places for single package booking.']);
            }
        } else { // full package
            if ($schedule->available_places <= 0) {
                return back()->withErrors(['package_type' => 'No available places for full package booking.']);
            }
        }

        $booking = Booking::create([
            'user_id' => Auth::id(),
            'schedule_id' => $validated['schedule_id'],
            'booking_date' => now(),
            'payment_method' => $validated['payment_method'],
            'booking_status' => 'pending',
            'phone' => $validated['phone'],
            'nationality' => $validated['nationality'] ?? null,
            'address' => $validated['address'] ?? null,
            'special_request' => $validated['special_request'] ?? null,
            'payment_transaction_id' => $validated['payment_transaction_id'],
            'total_amount' => $validated['calculated_total'],
            'package_type' => $validated['package_type'],
        ]);

        RoomChoice::create([
            'booking_id' => $booking->booking_id,
            'accom_id' => $validated['accom_id'],
        ]);

        // Update available places based on package type
        if ($validated['package_type'] === 'single') {
            $schedule->reduceAvailablePlaces(1);
        } else { // full package - set to 0
            $schedule->update(['available_places' => 0]);
        }

        $eticket = 'BK-' . str_pad($booking->booking_id, 6, '0', STR_PAD_LEFT);

        return redirect()
            ->route('booking.ticket', $booking->booking_id)
            ->with('eticket', $eticket);
    }

    public function ticket(Booking $booking)
    {
        $booking->load([
            'schedule.touristPackage.destination',
            'roomChoices.accommodation.hotel',
        ]);

        // Fetch user explicitly by booking->user_id (not relying on loaded relation)
        $user = User::find($booking->user_id);

        $eticket = session('eticket') ??
            'BK-' . str_pad($booking->booking_id, 6, '0', STR_PAD_LEFT);

        $rawName = trim($user->name ?? '');
        $email = $user->email ?? '';
        $phone = $booking->phone ?? '';

        if ($rawName !== '' && $rawName !== '_') {
            $displayName = $rawName;
        } elseif ($email) {
            $displayName = ucfirst(strtok($email, '@'));
        } elseif ($phone) {
            $displayName = 'Traveler (' . preg_replace('/\d(?=\d{3})/', '*', $phone) . ')';
        } else {
            $displayName = 'Traveler';
        }

        $packagePrice = $booking->schedule->touristPackage?->singlepackage_fee
            ?? $booking->schedule->touristPackage?->fullpackage_fee
            ?? 0;

        $roomChoice = $booking->roomChoices->first();
        // Try common column names for accommodation price
        $roomPrice = $roomChoice?->accommodation?->price
            ?? $roomChoice?->accommodation?->rate
            ?? $roomChoice?->accommodation?->room_price
            ?? 0;

        $totalPrice = $packagePrice + $roomPrice;

        return view('livewire.guest.booking-ticket', compact(
            'booking',
            'eticket',
            'displayName',
            'user',
            'packagePrice',
            'roomPrice',
            'totalPrice'
        ));
    }

    /**
     * Display admin listing of bookings with management options.
     */
    public function adminIndex()
    {
        $bookings = Booking::with(['user', 'schedule.touristPackage', 'roomChoices.accommodation.hotel'])
            ->orderBy('booking_date', 'desc')
            ->paginate(15);

        return view('livewire.admin.bookings', compact('bookings'));
    }
}