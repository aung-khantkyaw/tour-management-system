<?php

namespace App\Http\Controllers;

use App\Models\Booking;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class HistoryController extends Controller
{
    public function index()
    {
        $bookings = Booking::with([
            'schedule.touristPackage.destination',
            'schedule.touristPackage.guide',
            'roomChoices.accommodation.hotel',
            'roomChoices.accommodation.room'
        ])
        ->where('user_id', Auth::id())
        ->orderBy('booking_date', 'desc')
        ->get();

        return view('livewire.guest.history', compact('bookings'));
    }
}