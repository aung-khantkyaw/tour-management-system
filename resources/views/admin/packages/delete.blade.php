<x-layouts.app.sidebar>
    <div class="min-h-screen bg-gradient-to-br from-slate-50 to-red-50">
        <div class="p-6 lg:p-8 space-y-8">
            
            <!-- Enhanced Header -->
            <div class="bg-white rounded-2xl shadow-lg border border-gray-100 p-8">
                <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4">
                    <div class="flex items-center gap-4">
                        <div class="p-3 bg-gradient-to-r from-red-500 to-red-600 rounded-xl">
                            <svg class="w-8 h-8 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6M9 7h6m-7 0V5a2 2 0 012-2h3a2 2 0 012 2v2"/>
                            </svg>
                        </div>
                        <div>
                            <h1 class="text-3xl font-bold bg-gradient-to-r from-gray-900 to-gray-700 bg-clip-text text-transparent">Delete Package</h1>
                            <p class="text-gray-600 font-medium">Confirm package deletion</p>
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

            <!-- Warning Alert -->
            <div class="bg-red-50 border-l-4 border-red-400 text-red-700 px-6 py-4 rounded-r-lg shadow-sm">
                <div class="flex items-start">
                    <svg class="w-5 h-5 mr-3 mt-0.5" fill="currentColor" viewBox="0 0 20 20">
                        <path fill-rule="evenodd" d="M8.257 3.099c.765-1.36 2.722-1.36 3.486 0l5.58 9.92c.75 1.334-.213 2.98-1.742 2.98H4.42c-1.53 0-2.493-1.646-1.743-2.98l5.58-9.92zM11 13a1 1 0 11-2 0 1 1 0 012 0zm-1-8a1 1 0 00-1 1v3a1 1 0 002 0V6a1 1 0 00-1-1z" clip-rule="evenodd"/>
                    </svg>
                    <div>
                        <h3 class="font-semibold mb-2">Warning: This action cannot be undone!</h3>
                        <p class="text-sm">Deleting this package will permanently remove it from the system. Any associated schedules and bookings will also be affected.</p>
                    </div>
                </div>
            </div>

            <!-- Package Details Card -->
            <div class="bg-white rounded-2xl shadow-lg border border-gray-100 overflow-hidden">
                <div class="px-8 py-6 bg-gradient-to-r from-red-50 to-pink-50 border-b border-gray-100">
                    <h2 class="text-xl font-bold text-gray-900">Package to be Deleted</h2>
                    <p class="text-gray-600 text-sm mt-1">Review the package details before confirming deletion</p>
                </div>
                
                <div class="p-8">
                    <!-- Package Overview -->
                    <div class="grid grid-cols-1 lg:grid-cols-2 gap-8 mb-8">
                        <div class="space-y-6">
                            <div>
                                <h3 class="text-2xl font-bold text-gray-900 mb-2">{{ $package->package_name }}</h3>
                                <div class="space-y-2">
                                    <div class="flex items-center text-gray-600">
                                        <svg class="w-4 h-4 mr-2 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a2 2 0 01-2.828 0l-4.243-4.243a8 8 0 1111.314 0z"/>
                                        </svg>
                                        <span class="font-medium">{{ $package->destination->destination_name ?? 'No destination' }}</span>
                                    </div>
                                    <div class="flex items-center text-gray-600">
                                        <svg class="w-4 h-4 mr-2 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/>
                                        </svg>
                                        <span class="font-medium">{{ $package->guide->gname ?? 'No guide assigned' }}</span>
                                    </div>
                                </div>
                            </div>
                            
                            <div class="grid grid-cols-2 gap-4">
                                <div class="bg-gray-50 rounded-xl p-4 text-center">
                                    <p class="text-2xl font-bold text-gray-900">{{ $package->duration_days }}</p>
                                    <p class="text-sm font-semibold text-gray-500 uppercase tracking-wide">Days</p>
                                </div>
                                <div class="bg-gray-50 rounded-xl p-4 text-center">
                                    <p class="text-2xl font-bold text-gray-900">{{ $package->no_of_people }}</p>
                                    <p class="text-sm font-semibold text-gray-500 uppercase tracking-wide">Max People</p>
                                </div>
                            </div>
                        </div>
                        
                        <div class="space-y-6">
                            <!-- Vehicle Info -->
                            <div class="bg-blue-50 rounded-xl p-4 border border-blue-100">
                                <h4 class="font-semibold text-gray-900 mb-2">Vehicle Type</h4>
                                <p class="text-blue-700 font-medium">{{ $package->vehicle_type }}</p>
                            </div>
                            
                            <!-- Pricing Info -->
                            <div class="bg-green-50 rounded-xl p-4 border border-green-100">
                                <h4 class="font-semibold text-gray-900 mb-3">Pricing</h4>
                                <div class="space-y-2">
                                    <div class="flex justify-between">
                                        <span class="text-gray-600">Single Person:</span>
                                        <span class="font-bold text-green-700">${{ number_format($package->singlepackage_fee) }}</span>
                                    </div>
                                    <div class="flex justify-between">
                                        <span class="text-gray-600">Full Package:</span>
                                        <span class="font-bold text-green-700">${{ number_format($package->fullpackage_fee) }}</span>
                                    </div>
                                </div>
                            </div>
                            
                            <!-- Schedule Info -->
                            <div class="bg-purple-50 rounded-xl p-4 border border-purple-100">
                                <h4 class="font-semibold text-gray-900 mb-2">Active Schedules</h4>
                                <p class="text-purple-700 font-medium">{{ $package->schedules_count ?? 0 }} schedules</p>
                                @if($package->schedules_count > 0)
                                    <p class="text-xs text-purple-600 mt-1">These schedules will also be affected</p>
                                @endif
                            </div>
                        </div>
                    </div>
                    
                    <!-- Deletion Impact -->
                    @if($package->schedules_count > 0)
                        <div class="bg-amber-50 border border-amber-200 rounded-xl p-6 mb-8">
                            <div class="flex items-start">
                                <svg class="w-6 h-6 text-amber-600 mr-3 mt-0.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-2.5L13.732 4c-.77-.833-1.964-.833-2.732 0L3.732 16.5c-.77.833.192 2.5 1.732 2.5z"/>
                                </svg>
                                <div>
                                    <h4 class="font-semibold text-amber-800 mb-2">Impact of Deletion</h4>
                                    <ul class="text-sm text-amber-700 space-y-1">
                                        <li>• {{ $package->schedules_count }} active schedule(s) will be deleted</li>
                                        <li>• Any existing bookings for these schedules may be affected</li>
                                        <li>• This action cannot be reversed</li>
                                    </ul>
                                </div>
                            </div>
                        </div>
                    @endif
                    
                    <!-- Confirmation Actions -->
                    <div class="flex flex-col sm:flex-row gap-4 pt-6 border-t border-gray-200">
                        <form action="{{ route('admin.packages.destroy', $package) }}" method="POST" class="flex-1 sm:flex-none">
                            @csrf
                            @method('DELETE')
                            <button type="submit" 
                                class="w-full inline-flex items-center justify-center gap-2 px-8 py-3 bg-gradient-to-r from-red-600 to-red-700 text-white rounded-xl hover:from-red-700 hover:to-red-800 transition-all duration-200 shadow-lg hover:shadow-xl transform hover:-translate-y-0.5 font-semibold"
                                onclick="return confirm('Are you absolutely sure you want to delete this package? This action cannot be undone.')">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6M9 7h6m-7 0V5a2 2 0 012-2h3a2 2 0 012 2v2"/>
                                </svg>
                                Yes, Delete Package
                            </button>
                        </form>
                        <a href="{{ route('admin.packages.index') }}" 
                            class="flex-1 sm:flex-none inline-flex items-center justify-center gap-2 px-8 py-3 bg-gray-100 text-gray-700 rounded-xl hover:bg-gray-200 transition-all duration-200 font-semibold">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
                            </svg>
                            Cancel
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-layouts.app.sidebar>