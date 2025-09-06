<?php

namespace App\Http\Controllers;

use App\Models\Destination;
use App\Models\TouristPackage;
use Illuminate\Http\Request;

class DestinationController extends Controller
{
    /**
     * Display a listing of destinations with related counts.
     */
    public function index()
    {
        $destinations = Destination::withCount(['hotels', 'touristPackages'])
            ->orderBy('destination_name')
            ->get();

        return view('livewire.guest.destination', [
            'destinations' => $destinations,
        ]);
    }

    public function packages(Destination $destination)
    {
        $destination->loadCount(['hotels', 'touristPackages'])
            ->load(['hotels' => function($query) {
                $query->select('hotel_id', 'destination_id', 'name', 'rating')
                      ->orderBy('rating', 'desc')
                      ->limit(3);
            }]);
            
        $packages = TouristPackage::withCount('schedules')
            ->with('guide')
            ->where('destination_id', $destination->destination_id)
            ->orderBy('package_name')
            ->get();

        return view('livewire.guest.destination-packages', compact('destination', 'packages'));
    }

    /**
     * Display admin listing of destinations with management options.
     */
    public function adminIndex()
    {
        $destinations = Destination::withCount(['hotels', 'touristPackages'])
            ->orderBy('destination_name')
            ->paginate(12);

        return view('livewire.admin.destinations', [
            'destinations' => $destinations,
        ]);
    }
}
