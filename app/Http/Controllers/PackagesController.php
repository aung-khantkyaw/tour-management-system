<?php

namespace App\Http\Controllers;

use App\Models\TouristPackage;

class PackagesController extends Controller
{
    public function index()
    {
        $packages = TouristPackage::with(['destination', 'guide'])
            ->withCount([
                'schedules' => function ($query) {
                    $query->where('available_places', '>', 0);
                }
            ])
            ->orderBy('package_name')
            ->get()
            ->map(function ($p) {
                return [
                    'id' => $p->package_id,
                    'name' => $p->package_name,
                    'destination' => $p->destination?->destination_name ?? 'Unknown',
                    'destination_image' => $p->destination?->destination_profile,
                    'duration_days' => $p->duration_days,
                    'capacity' => $p->no_of_people,
                    'vehicle_type' => $p->vehicle_type,
                    'single_fee' => $p->singlepackage_fee,
                    'full_fee' => $p->fullpackage_fee,
                    'schedules_count' => $p->schedules_count,
                    'guide' => $p->guide?->gname ?? 'Unknown'
                ];
            });

        return view('livewire.guest.packages', compact('packages'));
    }

    /**
     * Display admin listing of packages with management options.
     */
    public function adminIndex()
    {
        $packages = TouristPackage::with(['destination', 'guide'])
            ->withCount([
                'schedules' => function ($query) {
                    $query->where('available_places', '>', 0);
                }
            ])
            ->orderBy('package_name')
            ->paginate(12);

        return view('livewire.admin.packages', compact('packages'));
    }
}