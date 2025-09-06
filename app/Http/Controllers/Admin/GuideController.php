<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Guide;
use Illuminate\Http\Request;

class GuideController extends Controller
{
    public function index()
    {
        $guides = Guide::withCount('touristPackages')
            ->paginate(10);

        return view('admin.guides.index', compact('guides'));
    }

    public function create()
    {
        return view('admin.guides.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'gname' => 'required|string|max:100',
            'email' => 'required|email|unique:guides,email',
            'phone' => 'required|string|max:15',
            'language' => 'required|string|max:50',
            'profile_image' => 'nullable|image|mimes:jpeg,png,jpg|max:2048',
        ]);

        $data = $request->all();
        
        if ($request->hasFile('profile_image')) {
            $data['profile_image'] = $request->file('profile_image')->store('guides', 'public');
        }

        Guide::create($data);

        return redirect()->route('admin.guides.index')
            ->with('success', 'Guide created successfully!');
    }

    public function edit(Guide $guide)
    {
        return view('admin.guides.edit', compact('guide'));
    }

    public function update(Request $request, Guide $guide)
    {
        $request->validate([
            'gname' => 'required|string|max:100',
            'email' => 'required|email|unique:guides,email,' . $guide->guide_id . ',guide_id',
            'phone' => 'required|string|max:15',
            'language' => 'required|string|max:50',
            'profile_image' => 'nullable|image|mimes:jpeg,png,jpg|max:2048',
        ]);

        $data = $request->all();
        
        if ($request->hasFile('profile_image')) {
            if ($guide->profile_image) {
                \Storage::disk('public')->delete($guide->profile_image);
            }
            $data['profile_image'] = $request->file('profile_image')->store('guides', 'public');
        }

        $guide->update($data);

        return redirect()->route('admin.guides.index')
            ->with('success', 'Guide updated successfully!');
    }

    public function destroy(Guide $guide)
    {
        try {
            if ($guide->profile_image) {
                \Storage::disk('public')->delete($guide->profile_image);
            }
            $guide->delete();
            return redirect()->route('admin.guides.index')
                ->with('success', 'Guide deleted successfully!');
        } catch (\Exception $e) {
            return redirect()->route('admin.guides.index')
                ->with('error', 'Cannot delete guide. It may have associated packages.');
        }
    }

    public function delete(Guide $guide)
    {
        return view('admin.guides.delete', compact('guide'));
    }
}