<?php

namespace Tests\Feature\Admin;

use App\Livewire\Admin\Destinations;
use App\Models\Destination;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Livewire\Livewire;
use Tests\TestCase;

class DestinationsLivewireTest extends TestCase
{
    use RefreshDatabase;

    protected function setUp(): void
    {
        parent::setUp();
        
        // Create a user for authentication
        $this->user = User::factory()->create();
    }

    /** @test */
    public function it_can_render_destinations_component()
    {
        $this->actingAs($this->user);

        Livewire::test(Destinations::class)
            ->assertStatus(200)
            ->assertSee('Admin - Destinations Management');
    }

    /** @test */
    public function it_can_open_add_modal()
    {
        $this->actingAs($this->user);

        Livewire::test(Destinations::class)
            ->call('openAddModal')
            ->assertSet('showAddModal', true)
            ->assertSee('Add New Destination');
    }

    /** @test */
    public function it_can_create_destination()
    {
        $this->actingAs($this->user);

        Livewire::test(Destinations::class)
            ->set('destination_name', 'Test Destination')
            ->set('city', 'Test City')
            ->set('description', 'Test Description')
            ->set('destination_profile', 'test-profile.jpg')
            ->call('store')
            ->assertSet('showAddModal', false)
            ->assertHasNoErrors();

        $this->assertDatabaseHas('destinations', [
            'destination_name' => 'Test Destination',
            'city' => 'Test City',
            'description' => 'Test Description',
            'destination_profile' => 'test-profile.jpg'
        ]);
    }

    /** @test */
    public function it_validates_required_fields_when_creating()
    {
        $this->actingAs($this->user);

        Livewire::test(Destinations::class)
            ->set('destination_name', '')
            ->set('city', '')
            ->set('description', '')
            ->call('store')
            ->assertHasErrors(['destination_name', 'city', 'description']);
    }

    /** @test */
    public function it_can_open_edit_modal()
    {
        $this->actingAs($this->user);
        
        $destination = Destination::create([
            'destination_name' => 'Original Name',
            'city' => 'Original City',
            'description' => 'Original Description',
            'destination_profile' => 'original.jpg'
        ]);

        Livewire::test(Destinations::class)
            ->call('openEditModal', $destination->destination_id)
            ->assertSet('showEditModal', true)
            ->assertSet('destination_name', 'Original Name')
            ->assertSet('city', 'Original City')
            ->assertSet('description', 'Original Description')
            ->assertSee('Edit Destination');
    }

    /** @test */
    public function it_can_update_destination()
    {
        $this->actingAs($this->user);
        
        $destination = Destination::create([
            'destination_name' => 'Original Name',
            'city' => 'Original City',
            'description' => 'Original Description',
            'destination_profile' => 'original.jpg'
        ]);

        Livewire::test(Destinations::class)
            ->call('openEditModal', $destination->destination_id)
            ->set('destination_name', 'Updated Name')
            ->set('city', 'Updated City')
            ->set('description', 'Updated Description')
            ->call('update')
            ->assertSet('showEditModal', false)
            ->assertHasNoErrors();

        $this->assertDatabaseHas('destinations', [
            'destination_id' => $destination->destination_id,
            'destination_name' => 'Updated Name',
            'city' => 'Updated City',
            'description' => 'Updated Description'
        ]);
    }

    /** @test */
    public function it_can_open_delete_modal()
    {
        $this->actingAs($this->user);
        
        $destination = Destination::create([
            'destination_name' => 'Test Destination',
            'city' => 'Test City',
            'description' => 'Test Description',
            'destination_profile' => 'test.jpg'
        ]);

        Livewire::test(Destinations::class)
            ->call('openDeleteModal', $destination->destination_id)
            ->assertSet('showDeleteModal', true)
            ->assertSee('Delete Destination')
            ->assertSee('Test Destination');
    }

    /** @test */
    public function it_can_delete_destination()
    {
        $this->actingAs($this->user);
        
        $destination = Destination::create([
            'destination_name' => 'Test Destination',
            'city' => 'Test City',
            'description' => 'Test Description',
            'destination_profile' => 'test.jpg'
        ]);

        Livewire::test(Destinations::class)
            ->call('openDeleteModal', $destination->destination_id)
            ->call('delete')
            ->assertSet('showDeleteModal', false);

        $this->assertDatabaseMissing('destinations', [
            'destination_id' => $destination->destination_id
        ]);
    }

    /** @test */
    public function it_can_close_modals()
    {
        $this->actingAs($this->user);

        $component = Livewire::test(Destinations::class);

        // Test closing add modal
        $component->call('openAddModal')
            ->assertSet('showAddModal', true)
            ->call('closeAddModal')
            ->assertSet('showAddModal', false);

        // Test closing edit modal
        $destination = Destination::create([
            'destination_name' => 'Test',
            'city' => 'Test',
            'description' => 'Test',
            'destination_profile' => 'test.jpg'
        ]);

        $component->call('openEditModal', $destination->destination_id)
            ->assertSet('showEditModal', true)
            ->call('closeEditModal')
            ->assertSet('showEditModal', false);

        // Test closing delete modal
        $component->call('openDeleteModal', $destination->destination_id)
            ->assertSet('showDeleteModal', true)
            ->call('closeDeleteModal')
            ->assertSet('showDeleteModal', false);
    }
}
