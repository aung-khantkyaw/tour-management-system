<?php

namespace App\Livewire\Admin;

use App\Models\Destination;
use Illuminate\Support\Facades\Storage;
use Livewire\Component;
use Livewire\WithPagination;
use Livewire\WithFileUploads;

class Destinations extends Component
{
    use WithPagination;
    use WithFileUploads;

    public $showAddModal = false;
    public $showEditModal = false;
    public $showDeleteModal = false;

    public $destination_name = '';
    public $city = '';
    public $description = '';
    public $destination_profile = '';

    public $editingDestination = null;
    public $deletingDestination = null;

    // New: uploaded image handle
    public $image;

    protected $rules = [
        'destination_name' => 'required|string|max:50',
        'city' => 'required|string|max:50',
        'description' => 'required|string|max:1000',
        'destination_profile' => 'nullable|string|max:255',
        // New: validate uploaded image
        'image' => 'nullable|image|max:2048',
    ];

    protected $messages = [
        'destination_name.required' => 'Destination name is required.',
        'destination_name.max' => 'Destination name cannot exceed 50 characters.',
        'city.required' => 'City is required.',
        'city.max' => 'City cannot exceed 50 characters.',
        'description.required' => 'Description is required.',
        'description.max' => 'Description cannot exceed 1000 characters.',
        'destination_profile.max' => 'Destination profile cannot exceed 255 characters.',
        'image.image' => 'The file must be an image.',
        'image.max' => 'The image may not be greater than 2MB.',
    ];

    public function render()
    {
        $destinations = Destination::withCount(['hotels', 'touristPackages'])
            ->paginate(9);

        return view('livewire.admin.destinations', [
            'destinations' => $destinations
        ]);
    }

    public function openAddModal()
    {
        $this->resetForm();
        $this->showAddModal = true;
    }

    public function closeAddModal()
    {
        $this->showAddModal = false;
        $this->resetForm();
        $this->resetValidation();
    }

    public function openEditModal($destinationId)
    {
        $this->editingDestination = Destination::find($destinationId);

        if ($this->editingDestination) {
            $this->destination_name = $this->editingDestination->destination_name;
            $this->city = $this->editingDestination->city;
            $this->description = $this->editingDestination->description;
            $this->destination_profile = $this->editingDestination->destination_profile ?? '';
            $this->image = null; // reset any selected file
            $this->showEditModal = true;
        }
    }

    public function closeEditModal()
    {
        $this->showEditModal = false;
        $this->editingDestination = null;
        $this->resetForm();
        $this->resetValidation();
    }

    public function openDeleteModal($destinationId)
    {
        $this->deletingDestination = Destination::find($destinationId);
        $this->showDeleteModal = true;
    }

    public function closeDeleteModal()
    {
        $this->showDeleteModal = false;
        $this->deletingDestination = null;
    }

    public function store()
    {
        $this->validate();

        $storedPath = $this->destination_profile ?: 'default-profile.jpg';
        if ($this->image) {
            $storedPath = $this->image->store('destinations', 'public');
        }

        Destination::create([
            'destination_name' => $this->destination_name,
            'city' => $this->city,
            'description' => $this->description,
            'destination_profile' => $storedPath,
        ]);

        $this->closeAddModal();
        session()->flash('message', 'Destination created successfully!');
    }

    public function update()
    {
        $this->validate();

        if ($this->editingDestination) {
            $storedPath = $this->editingDestination->destination_profile;

            if ($this->image) {
                // delete old image if stored in public disk
                if ($storedPath && $storedPath !== 'default-profile.jpg' && Storage::disk('public')->exists($storedPath)) {
                    Storage::disk('public')->delete($storedPath);
                }
                $storedPath = $this->image->store('destinations', 'public');
            } else if ($this->destination_profile) {
                // if user provided a text path fallback (kept for backward compatibility)
                $storedPath = $this->destination_profile;
            }

            $this->editingDestination->update([
                'destination_name' => $this->destination_name,
                'city' => $this->city,
                'description' => $this->description,
                'destination_profile' => $storedPath,
            ]);

            $this->closeEditModal();
            session()->flash('message', 'Destination updated successfully!');
        }
    }

    public function delete()
    {
        if ($this->deletingDestination) {
            // delete associated image if exists
            if ($this->deletingDestination->destination_profile && $this->deletingDestination->destination_profile !== 'default-profile.jpg') {
                if (Storage::disk('public')->exists($this->deletingDestination->destination_profile)) {
                    Storage::disk('public')->delete($this->deletingDestination->destination_profile);
                }
            }

            $this->deletingDestination->delete();
            $this->closeDeleteModal();
            session()->flash('message', 'Destination deleted successfully!');
        }
    }

    private function resetForm()
    {
        $this->destination_name = '';
        $this->city = '';
        $this->description = '';
        $this->destination_profile = '';
        $this->image = null;
    }
}
