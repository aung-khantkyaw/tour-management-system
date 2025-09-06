<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\TouristPackage;
use App\Models\Destination;
use App\Models\Guide;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class PackageController extends Controller
{
    public function index()
    {
        $packages = TouristPackage::with(['destination', 'guide'])
            ->withCount('schedules')
            ->paginate(10);

        return view('admin.packages.index', compact('packages'));
    }

    public function create()
    {
        $destinations = Destination::all();
        $guides = Guide::all();

        return view('admin.packages.create', compact('destinations', 'guides'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'package_name' => 'required|string|max:100',
            'destination_id' => 'required|exists:destinations,destination_id',
            'guide_id' => 'required|exists:guides,guide_id',
            'duration_days' => 'required|integer|min:1|max:30',
            'no_of_people' => 'required|integer|min:1|max:50',
            'vehicle_type' => 'required|string|max:50',
            'singlepackage_fee' => 'required|numeric|min:0',
            'fullpackage_fee' => 'required|numeric|min:0',
        ]);

        $data = $request->all();
        $days = (int) $data['duration_days'];
        $nights = max(0, $days - 1);
        $data['duration_days'] = "{$days} days {$nights} nights trip";

        TouristPackage::create($data);

        return redirect()->route('admin.packages.index')
            ->with('success', 'Package created successfully!');
    }

    public function show(TouristPackage $package)
    {
        $package->load(['destination', 'guide', 'schedules']);
        return view('admin.packages.show', compact('package'));
    }

    public function edit(TouristPackage $package)
    {
        $destinations = Destination::all();
        $guides = Guide::all();

        return view('admin.packages.edit', compact('package', 'destinations', 'guides'));
    }

    public function update(Request $request, TouristPackage $package)
    {
        $request->validate([
            'package_name' => 'required|string|max:100',
            'destination_id' => 'required|exists:destinations,destination_id',
            'guide_id' => 'required|exists:guides,guide_id',
            'duration_days' => 'required|integer|min:1|max:30',
            'no_of_people' => 'required|integer|min:1|max:50',
            'vehicle_type' => 'required|string|max:50',
            'singlepackage_fee' => 'required|numeric|min:0',
            'fullpackage_fee' => 'required|numeric|min:0',
        ]);

        $data = $request->all();
        $days = (int) $data['duration_days'];
        $nights = max(0, $days - 1);
        $data['duration_days'] = "{$days} days {$nights} nights trip";

        $package->update($data);

        return redirect()->route('admin.packages.index')
            ->with('success', 'Package updated successfully!');
    }

    public function destroy(TouristPackage $package)
    {
        try {
            $package->delete();
            return redirect()->route('admin.packages.index')
                ->with('success', 'Package deleted successfully!');
        } catch (\Exception $e) {
            return redirect()->route('admin.packages.index')
                ->with('error', 'Cannot delete package. It may have associated schedules.');
        }
    }

    public function delete(TouristPackage $package)
    {
        return view('admin.packages.delete', compact('package'));
    }
}