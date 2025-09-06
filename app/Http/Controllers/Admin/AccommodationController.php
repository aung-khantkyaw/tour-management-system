<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Accommodation;
use App\Models\Hotel;
use App\Models\Room;
use Illuminate\Http\Request;

class AccommodationController extends Controller
{
    public function index()
    {
        $accommodations = Accommodation::with(['hotel.destination', 'room'])
            ->withCount('roomChoices')
            ->paginate(10);

        return view('admin.accommodations.index', compact('accommodations'));
    }

    public function create()
    {
        $hotels = Hotel::with('destination')->get();
        $rooms = Room::all();
        
        return view('admin.accommodations.create', compact('hotels', 'rooms'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'hotel_id' => 'required|exists:hotels,hotel_id',
            'room_id' => 'required|exists:rooms,room_id',
            'price' => 'required|numeric|min:0',
        ]);

        Accommodation::create($request->all());

        return redirect()->route('admin.accommodations.index')
            ->with('success', 'Accommodation created successfully!');
    }

    public function edit(Accommodation $accommodation)
    {
        $hotels = Hotel::with('destination')->get();
        $rooms = Room::all();
        
        return view('admin.accommodations.edit', compact('accommodation', 'hotels', 'rooms'));
    }

    public function update(Request $request, Accommodation $accommodation)
    {
        $request->validate([
            'hotel_id' => 'required|exists:hotels,hotel_id',
            'room_id' => 'required|exists:rooms,room_id',
            'price' => 'required|numeric|min:0',
        ]);

        $accommodation->update($request->all());

        return redirect()->route('admin.accommodations.index')
            ->with('success', 'Accommodation updated successfully!');
    }

    public function destroy(Accommodation $accommodation)
    {
        try {
            $accommodation->delete();
            return redirect()->route('admin.accommodations.index')
                ->with('success', 'Accommodation deleted successfully!');
        } catch (\Exception $e) {
            return redirect()->route('admin.accommodations.index')
                ->with('error', 'Cannot delete accommodation. It may have associated bookings.');
        }
    }

    public function delete(Accommodation $accommodation)
    {
        return view('admin.accommodations.delete', compact('accommodation'));
    }
}