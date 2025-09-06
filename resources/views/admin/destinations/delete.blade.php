<x-layouts.app.sidebar>
    <div class="p-6 lg:p-8 space-y-6">
        <h1 class="text-2xl font-bold">Delete Destination</h1>
        <div class="bg-white shadow rounded p-6">
            @if($destination->destination_profile)
                <div class="mb-4">
                    <img src="{{ asset('storage/' . $destination->destination_profile) }}" alt="{{ $destination->destination_name }}" class="w-32 h-32 rounded-lg object-cover border-4 border-gray-200 shadow-lg">
                </div>
            @endif
            <p class="mb-4">Are you sure you want to delete <strong>{{ $destination->destination_name }}</strong>?</p>
            <div class="flex gap-3">
                <a href="{{ route('admin.destinations.index') }}"
                    class="px-4 py-2 rounded bg-gray-200 hover:bg-gray-300">Cancel</a>
                <form action="{{ route('admin.destinations.destroy', $destination) }}" method="POST">
                    @csrf
                    @method('DELETE')
                    <button class="px-4 py-2 rounded bg-red-600 text-white hover:bg-red-700">Delete</button>
                </form>
            </div>
        </div>
    </div>
</x-layouts.app.sidebar>