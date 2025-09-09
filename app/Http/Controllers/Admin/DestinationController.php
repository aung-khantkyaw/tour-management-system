<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Destination;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class DestinationController extends Controller
{
    public function index()
    {
        $destinations = Destination::withCount(['hotels', 'touristPackages'])->paginate(9);
        return view('admin.destinations.index', compact('destinations'));
    }

    public function create()
    {
        return view('admin.destinations.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'destination_name' => 'required|string|max:50',
            'city' => 'required|string|max:50',
            'description' => 'required|string|max:1000',
            'image' => 'nullable|image|max:2048',
        ]);

        $path = null;
        if ($request->hasFile('image')) {
            $path = $request->file('image')->store('destinations', 'public');
        }

        Destination::create([
            'destination_name' => $validated['destination_name'],
            'city' => $validated['city'],
            'description' => $validated['description'],
            'destination_profile' => $path ?? 'default-profile.jpg',
        ]);

        return redirect()->route('admin.destinations.index')->with('success', 'Destination created successfully!');
    }

    public function edit(Destination $destination)
    {
        return view('admin.destinations.edit', compact('destination'));
    }

    public function update(Request $request, Destination $destination)
    {
        $validated = $request->validate([
            'destination_name' => 'required|string|max:50',
            'city' => 'required|string|max:50',
            'description' => 'required|string|max:1000',
            'image' => 'nullable|image|max:2048',
        ]);

        $path = $destination->destination_profile;
        if ($request->hasFile('image')) {
            if ($path && $path !== 'default-profile.jpg' && Storage::disk('public')->exists($path)) {
                Storage::disk('public')->delete($path);
            }
            $path = $request->file('image')->store('destinations', 'public');
        }

        $destination->update([
            'destination_name' => $validated['destination_name'],
            'city' => $validated['city'],
            'description' => $validated['description'],
            'destination_profile' => $path,
        ]);

        return redirect()->route('admin.destinations.index')->with('success', 'Destination updated successfully!');
    }

    public function confirmDelete(Destination $destination)
    {
        return view('admin.destinations.delete', compact('destination'));
    }

    public function destroy(Destination $destination)
    {
        try {
            $destination->delete();
            return redirect()->route('admin.destinations.index')
                ->with('success', 'Destination and all related data deleted successfully!');
        } catch (\Exception $e) {
            return redirect()->route('admin.destinations.index')
                ->with('error', 'Cannot delete destination. It may have associated data.');
        }
    }
}