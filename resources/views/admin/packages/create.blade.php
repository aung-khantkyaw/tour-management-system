<x-layouts.app.sidebar>
    <div class="min-h-screen bg-gradient-to-br from-slate-50 to-purple-50">
        <div class="p-6 lg:p-8 space-y-8">
            
            <!-- Enhanced Header -->
            <div class="bg-white rounded-2xl shadow-lg border border-gray-100 p-8">
                <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4">
                    <div class="flex items-center gap-4">
                        <div class="p-3 bg-gradient-to-r from-green-500 to-emerald-600 rounded-xl">
                            <svg class="w-8 h-8 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H3"/>
                            </svg>
                        </div>
                        <div>
                            <h1 class="text-3xl font-bold bg-gradient-to-r from-gray-900 to-gray-700 bg-clip-text text-transparent">Add New Package</h1>
                            <p class="text-gray-600 font-medium">Create a comprehensive tour package</p>
                        </div>
                    </div>
                    <a href="{{ route('admin.packages.index') }}" 
                        class="inline-flex items-center gap-2 px-4 py-2 bg-gray-100 text-gray-700 rounded-xl hover:bg-gray-200 transition-all duration-200 font-medium">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"/>
                        </svg>
                        Back to List
                    </a>
                </div>
            </div>

            @if ($errors->any())
                <div class="bg-red-50 border-l-4 border-red-400 text-red-700 px-6 py-4 rounded-r-lg shadow-sm">
                    <div class="flex items-start">
                        <svg class="w-5 h-5 mr-3 mt-0.5" fill="currentColor" viewBox="0 0 20 20">
                            <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zM8.707 7.293a1 1 0 00-1.414 1.414L8.586 10l-1.293 1.293a1 1 0 101.414 1.414L10 11.414l1.293 1.293a1 1 0 001.414-1.414L11.414 10l1.293-1.293a1 1 0 00-1.414-1.414L10 8.586 8.707 7.293z" clip-rule="evenodd"/>
                        </svg>
                        <div>
                            <h3 class="font-semibold mb-2">Please fix the following errors:</h3>
                            <ul class="list-disc ml-5 space-y-1">
                                @foreach ($errors->all() as $error)
                                    <li class="text-sm">{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    </div>
                </div>
            @endif

            <!-- Enhanced Form -->
            <div class="bg-white rounded-2xl shadow-lg border border-gray-100 overflow-hidden">
                <div class="px-8 py-6 bg-gradient-to-r from-purple-50 to-indigo-50 border-b border-gray-100">
                    <h2 class="text-xl font-bold text-gray-900">Package Information</h2>
                    <p class="text-gray-600 text-sm mt-1">Fill in the details below to create a new tour package</p>
                </div>
                
                <form action="{{ route('admin.packages.store') }}" method="POST" class="p-8 space-y-8">
                    @csrf
                    
                    <!-- Basic Information Section -->
                    <div class="grid grid-cols-1 lg:grid-cols-2 gap-8">
                        <div class="space-y-2">
                            <label class="block text-sm font-semibold text-gray-700 mb-2">Package Name *</label>
                            <input name="package_name" type="text" value="{{ old('package_name') }}"
                                class="w-full border-2 border-gray-200 rounded-xl px-4 py-3 text-sm focus:outline-none focus:ring-2 focus:ring-purple-500 focus:border-purple-500 transition-all duration-200 bg-gray-50 hover:bg-white" 
                                placeholder="Enter package name" required>
                            <p class="text-xs text-gray-500">The name of your tour package</p>
                        </div>
                        
                        <div class="space-y-2">
                            <label class="block text-sm font-semibold text-gray-700 mb-2">Duration (Days) *</label>
                            <input name="duration_days" type="number" value="{{ old('duration_days') }}" min="1" max="30"
                                class="w-full border-2 border-gray-200 rounded-xl px-4 py-3 text-sm focus:outline-none focus:ring-2 focus:ring-purple-500 focus:border-purple-500 transition-all duration-200 bg-gray-50 hover:bg-white" 
                                placeholder="Enter duration in days" required>
                            <p class="text-xs text-gray-500">How many days does this package last</p>
                        </div>
                    </div>
                    
                    <!-- Destination and Guide Section -->
                    <div class="grid grid-cols-1 lg:grid-cols-2 gap-8">
                        <div class="space-y-2">
                            <label class="block text-sm font-semibold text-gray-700 mb-2">Destination *</label>
                            <select name="destination_id" 
                                class="w-full border-2 border-gray-200 rounded-xl px-4 py-3 text-sm focus:outline-none focus:ring-2 focus:ring-purple-500 focus:border-purple-500 transition-all duration-200 bg-gray-50 hover:bg-white" required>
                                <option value="">Select a destination</option>
                                @foreach($destinations as $destination)
                                    <option value="{{ $destination->destination_id }}" {{ old('destination_id') == $destination->destination_id ? 'selected' : '' }}>
                                        {{ $destination->destination_name }} - {{ $destination->city }}
                                    </option>
                                @endforeach
                            </select>
                            <p class="text-xs text-gray-500">Choose the destination for this package</p>
                        </div>
                        
                        <div class="space-y-2">
                            <label class="block text-sm font-semibold text-gray-700 mb-2">Tour Guide *</label>
                            <select name="guide_id" 
                                class="w-full border-2 border-gray-200 rounded-xl px-4 py-3 text-sm focus:outline-none focus:ring-2 focus:ring-purple-500 focus:border-purple-500 transition-all duration-200 bg-gray-50 hover:bg-white" required>
                                <option value="">Select a guide</option>
                                @foreach($guides as $guide)
                                    <option value="{{ $guide->guide_id }}" {{ old('guide_id') == $guide->guide_id ? 'selected' : '' }}>
                                        {{ $guide->gname ?? 'Guide #' . $guide->guide_id }} ({{ $guide->language }})
                                    </option>
                                @endforeach
                            </select>
                            <p class="text-xs text-gray-500">Assign a tour guide to this package</p>
                        </div>
                    </div>
                    
                    <!-- Capacity and Vehicle Section -->
                    <div class="grid grid-cols-1 lg:grid-cols-2 gap-8">
                        <div class="space-y-2">
                            <label class="block text-sm font-semibold text-gray-700 mb-2">Maximum People *</label>
                            <input name="no_of_people" type="number" value="{{ old('no_of_people') }}" min="1" max="50"
                                class="w-full border-2 border-gray-200 rounded-xl px-4 py-3 text-sm focus:outline-none focus:ring-2 focus:ring-purple-500 focus:border-purple-500 transition-all duration-200 bg-gray-50 hover:bg-white" 
                                placeholder="Enter maximum capacity" required>
                            <p class="text-xs text-gray-500">Maximum number of people for this package</p>
                        </div>
                        
                        <div class="space-y-2">
                            <label class="block text-sm font-semibold text-gray-700 mb-2">Vehicle Type *</label>
                            <select name="vehicle_type" 
                                class="w-full border-2 border-gray-200 rounded-xl px-4 py-3 text-sm focus:outline-none focus:ring-2 focus:ring-purple-500 focus:border-purple-500 transition-all duration-200 bg-gray-50 hover:bg-white" required>
                                <option value="">Select vehicle type</option>
                                <option value="Car" {{ old('vehicle_type') == 'Car' ? 'selected' : '' }}>Car</option>
                                <option value="Van" {{ old('vehicle_type') == 'Van' ? 'selected' : '' }}>Van</option>
                                <option value="Bus" {{ old('vehicle_type') == 'Bus' ? 'selected' : '' }}>Bus</option>
                                <option value="Minibus" {{ old('vehicle_type') == 'Minibus' ? 'selected' : '' }}>Minibus</option>
                                <option value="SUV" {{ old('vehicle_type') == 'SUV' ? 'selected' : '' }}>SUV</option>
                                <option value="Motorcycle" {{ old('vehicle_type') == 'Motorcycle' ? 'selected' : '' }}>Motorcycle</option>
                            </select>
                            <p class="text-xs text-gray-500">Type of vehicle for transportation</p>
                        </div>
                    </div>
                    
                    <!-- Pricing Section -->
                    <div class="bg-gradient-to-r from-purple-50 to-indigo-50 rounded-2xl p-6 border border-purple-100">
                        <h3 class="text-lg font-bold text-gray-900 mb-4 flex items-center">
                            <svg class="w-5 h-5 mr-2 text-purple-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1"/>
                            </svg>
                            Package Pricing
                        </h3>
                        <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
                            <div class="space-y-2">
                                <label class="block text-sm font-semibold text-gray-700 mb-2">Single Person Fee *</label>
                                <div class="relative">
                                    <span class="absolute left-4 inset-y-0 flex items-center text-gray-500">$</span>
                                    <input name="singlepackage_fee" type="number" value="{{ old('singlepackage_fee') }}" min="0" step="0.01"
                                        class="w-full border-2 border-gray-200 rounded-xl pl-8 pr-4 py-3 text-sm focus:outline-none focus:ring-2 focus:ring-purple-500 focus:border-purple-500 transition-all duration-200 bg-white" 
                                        placeholder="0.00" required>
                                </div>
                                <p class="text-xs text-gray-500">Price for a single person</p>
                            </div>
                            
                            <div class="space-y-2">
                                <label class="block text-sm font-semibold text-gray-700 mb-2">Full Package Fee *</label>
                                <div class="relative">
                                    <span class="absolute left-4 inset-y-0 flex items-center text-gray-500">$</span>
                                    <input name="fullpackage_fee" type="number" value="{{ old('fullpackage_fee') }}" min="0" step="0.01"
                                        class="w-full border-2 border-gray-200 rounded-xl pl-8 pr-4 py-3 text-sm focus:outline-none focus:ring-2 focus:ring-purple-500 focus:border-purple-500 transition-all duration-200 bg-white" 
                                        placeholder="0.00" required>
                                </div>
                                <p class="text-xs text-gray-500">Price for the complete package</p>
                            </div>
                        </div>
                    </div>
                    
                    <!-- Form Actions -->
                    <div class="flex flex-col sm:flex-row gap-4 pt-6 border-t border-gray-200">
                        <button type="submit" 
                            class="flex-1 sm:flex-none inline-flex items-center justify-center gap-2 px-8 py-3 bg-gradient-to-r from-purple-600 to-indigo-600 text-white rounded-xl hover:from-purple-700 hover:to-indigo-700 transition-all duration-200 shadow-lg hover:shadow-xl transform hover:-translate-y-0.5 font-semibold">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/>
                            </svg>
                            Create Package
                        </button>
                        <a href="{{ route('admin.packages.index') }}" 
                            class="flex-1 sm:flex-none inline-flex items-center justify-center gap-2 px-8 py-3 bg-gray-100 text-gray-700 rounded-xl hover:bg-gray-200 transition-all duration-200 font-semibold">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
                            </svg>
                            Cancel
                        </a>
                    </div>
                </form>
            </div>
        </div>
    </div>
</x-layouts.app.sidebar>