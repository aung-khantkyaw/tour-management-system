<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Hotel;
use App\Models\Destination;
use Illuminate\Http\Request;

class HotelController extends Controller
{
    public function index()
    {
        $hotels = Hotel::with(['destination'])
            ->withCount('accommodations')
            ->paginate(10);

        return view('admin.hotels.index', compact('hotels'));
    }

    public function create()
    {
        $destinations = Destination::all();
        return view('admin.hotels.create', compact('destinations'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:100',
            'destination_id' => 'required|exists:destinations,destination_id',
            'contact_no' => 'required|string|max:15',
            'rating' => 'required|integer|min:1|max:5',
        ]);

        Hotel::create($request->all());

        return redirect()->route('admin.hotels.index')
            ->with('success', 'Hotel created successfully!');
    }

    public function edit(Hotel $hotel)
    {
        $destinations = Destination::all();
        return view('admin.hotels.edit', compact('hotel', 'destinations'));
    }

    public function update(Request $request, Hotel $hotel)
    {
        $request->validate([
            'name' => 'required|string|max:100',
            'destination_id' => 'required|exists:destinations,destination_id',
            'contact_no' => 'required|string|max:15',
            'rating' => 'required|integer|min:1|max:5',
        ]);

        $hotel->update($request->all());

        return redirect()->route('admin.hotels.index')
            ->with('success', 'Hotel updated successfully!');
    }

    public function destroy(Hotel $hotel)
    {
        try {
            $hotel->delete();
            return redirect()->route('admin.hotels.index')
                ->with('success', 'Hotel deleted successfully!');
        } catch (\Exception $e) {
            return redirect()->route('admin.hotels.index')
                ->with('error', 'Cannot delete hotel. It may have associated accommodations.');
        }
    }

    public function delete(Hotel $hotel)
    {
        return view('admin.hotels.delete', compact('hotel'));
    }
}