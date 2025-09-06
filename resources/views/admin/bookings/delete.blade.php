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
                            <h1 class="text-3xl font-bold bg-gradient-to-r from-gray-900 to-gray-700 bg-clip-text text-transparent">Delete Booking</h1>
                            <p class="text-gray-600 font-medium">Confirm booking deletion</p>
                        </div>
                    </div>
                    <a href="{{ route('admin.bookings.index') }}" 
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
                        <p class="text-sm">Deleting this booking will permanently remove it from the system. Customer data and payment information will be lost.</p>
                    </div>
                </div>
            </div>

            <!-- Booking Details Card -->
            <div class="bg-white rounded-2xl shadow-lg border border-gray-100 overflow-hidden">
                <div class="px-8 py-6 bg-gradient-to-r from-red-50 to-pink-50 border-b border-gray-100">
                    <h2 class="text-xl font-bold text-gray-900">Booking to be Deleted</h2>
                    <p class="text-gray-600 text-sm mt-1">Review the booking details before confirming deletion</p>
                </div>
                
                <div class="p-8">
                    <!-- Booking Overview -->
                    <div class="grid grid-cols-1 lg:grid-cols-2 gap-8 mb-8">
                        <div class="space-y-6">
                            <div>
                                <h3 class="text-2xl font-bold text-gray-900 mb-2">Booking #{{ $booking->booking_id }}</h3>
                                <div class="space-y-2">
                                    <div class="flex items-center text-gray-600">
                                        <svg class="w-4 h-4 mr-2 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/>
                                        </svg>
                                        <span class="font-medium">{{ $booking->user->name ?? 'Unknown Customer' }}</span>
                                    </div>
                                    <div class="flex items-center text-gray-600">
                                        <svg class="w-4 h-4 mr-2 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 4.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"/>
                                        </svg>
                                        <span class="font-medium">{{ $booking->user->email ?? 'No email' }}</span>
                                    </div>
                                    <div class="flex items-center text-gray-600">
                                        <svg class="w-4 h-4 mr-2 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z"/>
                                        </svg>
                                        <span class="font-medium">{{ $booking->phone }}</span>
                                    </div>
                                </div>
                            </div>
                            
                            <!-- Package Info -->
                            <div class="bg-blue-50 rounded-xl p-4 border border-blue-100">
                                <h4 class="font-semibold text-gray-900 mb-3">Package Details</h4>
                                <div class="space-y-2">
                                    <p class="text-sm"><span class="font-medium">Package:</span> {{ $booking->schedule->touristPackage->package_name ?? 'N/A' }}</p>
                                    <p class="text-sm"><span class="font-medium">Destination:</span> {{ $booking->schedule->touristPackage->destination->destination_name ?? 'N/A' }}</p>
                                    <p class="text-sm"><span class="font-medium">Guide:</span> {{ $booking->schedule->touristPackage->guide->gname ?? 'N/A' }}</p>
                                </div>
                            </div>
                        </div>
                        
                        <div class="space-y-6">
                            <!-- Booking Info -->
                            <div class="bg-green-50 rounded-xl p-4 border border-green-100">
                                <h4 class="font-semibold text-gray-900 mb-3">Booking Information</h4>
                                <div class="space-y-2">
                                    <p class="text-sm"><span class="font-medium">Booking Date:</span> {{ \Carbon\Carbon::parse($booking->booking_date)->format('M d, Y') }}</p>
                                    <p class="text-sm"><span class="font-medium">Tour From:</span> {{ \Carbon\Carbon::parse($booking->schedule->from_date)->format('M d, Y') }}</p>
                                    <p class="text-sm"><span class="font-medium">Tour To:</span> {{ \Carbon\Carbon::parse($booking->schedule->to_date)->format('M d, Y') }}</p>
                                </div>
                            </div>
                            
                            <!-- Status Info -->
                            <div class="bg-purple-50 rounded-xl p-4 border border-purple-100">
                                <h4 class="font-semibold text-gray-900 mb-3">Current Status</h4>
                                <div class="space-y-3">
                                    <div class="flex justify-between items-center">
                                        <span class="text-sm text-gray-600">Payment Status:</span>
                                        <span class="inline-flex items-center px-2 py-1 rounded-full text-xs font-semibold 
                                            {{ $booking->payment_status === 'confirmed' ? 'bg-green-100 text-green-800' : 
                                               ($booking->payment_status === 'pending' ? 'bg-yellow-100 text-yellow-800' : 
                                               ($booking->payment_status === 'cancelled' ? 'bg-red-100 text-red-800' : 'bg-gray-100 text-gray-800')) }}">
                                            {{ ucfirst($booking->payment_status) }}
                                        </span>
                                    </div>
                                    <div class="flex justify-between items-center">
                                        <span class="text-sm text-gray-600">Package Status:</span>
                                        <span class="inline-flex items-center px-2 py-1 rounded-full text-xs font-semibold 
                                            {{ $booking->package_status === 'confirmed' ? 'bg-green-100 text-green-800' : 
                                               ($booking->package_status === 'pending' ? 'bg-yellow-100 text-yellow-800' : 
                                               ($booking->package_status === 'in_progress' ? 'bg-blue-100 text-blue-800' :
                                               ($booking->package_status === 'completed' ? 'bg-purple-100 text-purple-800' : 'bg-gray-100 text-gray-800'))) }}">
                                            {{ ucfirst(str_replace('_', ' ', $booking->package_status)) }}
                                        </span>
                                    </div>
                                </div>
                            </div>
                            
                            <!-- Payment Info -->
                            <div class="bg-amber-50 rounded-xl p-4 border border-amber-100">
                                <h4 class="font-semibold text-gray-900 mb-2">Payment Information</h4>
                                <div class="flex justify-between items-center">
                                    <span class="text-lg font-bold text-amber-700">Total Amount:</span>
                                    <span class="text-2xl font-bold text-amber-800">${{ number_format($booking->total_amount) }}</span>
                                </div>
                                @if($booking->payment_transaction_id)
                                    <p class="text-xs text-amber-600 mt-2">Transaction ID: {{ $booking->payment_transaction_id }}</p>
                                @endif
                            </div>
                        </div>
                    </div>
                    
                    <!-- Special Requests -->
                    @if($booking->special_request)
                        <div class="bg-gray-50 border border-gray-200 rounded-xl p-6 mb-8">
                            <h4 class="font-semibold text-gray-900 mb-2">Special Requests</h4>
                            <p class="text-gray-700">{{ $booking->special_request }}</p>
                        </div>
                    @endif
                    
                    <!-- Deletion Impact -->
                    <div class="bg-amber-50 border border-amber-200 rounded-xl p-6 mb-8">
                        <div class="flex items-start">
                            <svg class="w-6 h-6 text-amber-600 mr-3 mt-0.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-2.5L13.732 4c-.77-.833-1.964-.833-2.732 0L3.732 16.5c-.77.833.192 2.5 1.732 2.5z"/>
                            </svg>
                            <div>
                                <h4 class="font-semibold text-amber-800 mb-2">Impact of Deletion</h4>
                                <ul class="text-sm text-amber-700 space-y-1">
                                    <li>• Customer booking record will be permanently deleted</li>
                                    <li>• Payment and transaction information will be lost</li>
                                    <li>• This action cannot be reversed</li>
                                    <li>• Customer will lose access to their booking details</li>
                                </ul>
                            </div>
                        </div>
                    </div>
                    
                    <!-- Confirmation Actions -->
                    <div class="flex flex-col sm:flex-row gap-4 pt-6 border-t border-gray-200">
                        <form action="{{ route('admin.bookings.destroy', $booking) }}" method="POST" class="flex-1 sm:flex-none">
                            @csrf
                            @method('DELETE')
                            <button type="submit" 
                                class="w-full inline-flex items-center justify-center gap-2 px-8 py-3 bg-gradient-to-r from-red-600 to-red-700 text-white rounded-xl hover:from-red-700 hover:to-red-800 transition-all duration-200 shadow-lg hover:shadow-xl transform hover:-translate-y-0.5 font-semibold"
                                onclick="return confirm('Are you absolutely sure you want to delete this booking? This action cannot be undone.')">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6M9 7h6m-7 0V5a2 2 0 012-2h3a2 2 0 012 2v2"/>
                                </svg>
                                Yes, Delete Booking
                            </button>
                        </form>
                        <a href="{{ route('admin.bookings.index') }}" 
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