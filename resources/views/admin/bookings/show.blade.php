<x-layouts.app.sidebar>
    <div class="min-h-screen bg-gradient-to-br from-slate-50 to-orange-50">
        <div class="p-6 lg:p-8 space-y-8">
            
            <!-- Enhanced Header -->
            <div class="bg-white rounded-2xl shadow-lg border border-gray-100 p-8">
                <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4">
                    <div class="flex items-center gap-4">
                        <div class="p-3 bg-gradient-to-r from-orange-500 to-red-600 rounded-xl">
                            <svg class="w-8 h-8 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/>
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/>
                            </svg>
                        </div>
                        <div>
                            <h1 class="text-3xl font-bold bg-gradient-to-r from-gray-900 to-gray-700 bg-clip-text text-transparent">Booking Details</h1>
                            <p class="text-gray-600 font-medium">Booking #{{ $booking->booking_id }}</p>
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

            <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
                <!-- Main Booking Information -->
                <div class="lg:col-span-2 space-y-8">
                    <!-- Customer Information -->
                    <div class="bg-white rounded-2xl shadow-lg border border-gray-100 overflow-hidden">
                        <div class="px-8 py-6 bg-gradient-to-r from-blue-50 to-indigo-50 border-b border-gray-100">
                            <h2 class="text-xl font-bold text-gray-900">Customer Information</h2>
                        </div>
                        <div class="p-8">
                            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                                <div>
                                    <label class="text-sm font-semibold text-gray-500 uppercase tracking-wide">Full Name</label>
                                    <p class="text-lg font-bold text-gray-900 mt-1">{{ $booking->user->name ?? 'N/A' }}</p>
                                </div>
                                <div>
                                    <label class="text-sm font-semibold text-gray-500 uppercase tracking-wide">Email</label>
                                    <p class="text-lg font-bold text-gray-900 mt-1">{{ $booking->user->email ?? 'N/A' }}</p>
                                </div>
                                <div>
                                    <label class="text-sm font-semibold text-gray-500 uppercase tracking-wide">Phone</label>
                                    <p class="text-lg font-bold text-gray-900 mt-1">{{ $booking->phone }}</p>
                                </div>
                                <div>
                                    <label class="text-sm font-semibold text-gray-500 uppercase tracking-wide">Nationality</label>
                                    <p class="text-lg font-bold text-gray-900 mt-1">{{ $booking->nationality }}</p>
                                </div>
                                <div class="md:col-span-2">
                                    <label class="text-sm font-semibold text-gray-500 uppercase tracking-wide">Address</label>
                                    <p class="text-lg font-bold text-gray-900 mt-1">{{ $booking->address }}</p>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Package Information -->
                    <div class="bg-white rounded-2xl shadow-lg border border-gray-100 overflow-hidden">
                        <div class="px-8 py-6 bg-gradient-to-r from-green-50 to-emerald-50 border-b border-gray-100">
                            <h2 class="text-xl font-bold text-gray-900">Package Information</h2>
                        </div>
                        <div class="p-8">
                            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                                <div>
                                    <label class="text-sm font-semibold text-gray-500 uppercase tracking-wide">Package Name</label>
                                    <p class="text-lg font-bold text-gray-900 mt-1">{{ $booking->schedule->touristPackage->package_name ?? 'N/A' }}</p>
                                </div>
                                <div>
                                    <label class="text-sm font-semibold text-gray-500 uppercase tracking-wide">Destination</label>
                                    <p class="text-lg font-bold text-gray-900 mt-1">{{ $booking->schedule->touristPackage->destination->destination_name ?? 'N/A' }}</p>
                                </div>
                                <div>
                                    <label class="text-sm font-semibold text-gray-500 uppercase tracking-wide">Guide</label>
                                    <p class="text-lg font-bold text-gray-900 mt-1">{{ $booking->schedule->touristPackage->guide->gname ?? 'N/A' }}</p>
                                </div>
                                <div>
                                    <label class="text-sm font-semibold text-gray-500 uppercase tracking-wide">Duration</label>
                                    <p class="text-lg font-bold text-gray-900 mt-1">{{ $booking->schedule->touristPackage->duration_days ?? 'N/A' }} days</p>
                                </div>
                                <div>
                                    <label class="text-sm font-semibold text-gray-500 uppercase tracking-wide">From Date</label>
                                    <p class="text-lg font-bold text-gray-900 mt-1">{{ \Carbon\Carbon::parse($booking->schedule->from_date)->format('M d, Y') }}</p>
                                </div>
                                <div>
                                    <label class="text-sm font-semibold text-gray-500 uppercase tracking-wide">To Date</label>
                                    <p class="text-lg font-bold text-gray-900 mt-1">{{ \Carbon\Carbon::parse($booking->schedule->to_date)->format('M d, Y') }}</p>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Special Requests -->
                    @if($booking->special_request)
                    <div class="bg-white rounded-2xl shadow-lg border border-gray-100 overflow-hidden">
                        <div class="px-8 py-6 bg-gradient-to-r from-purple-50 to-pink-50 border-b border-gray-100">
                            <h2 class="text-xl font-bold text-gray-900">Special Requests</h2>
                        </div>
                        <div class="p-8">
                            <p class="text-gray-700">{{ $booking->special_request }}</p>
                        </div>
                    </div>
                    @endif
                </div>

                <!-- Sidebar -->
                <div class="space-y-8">
                    <!-- Status Update -->
                    <div class="bg-white rounded-2xl shadow-lg border border-gray-100 overflow-hidden">
                        <div class="px-6 py-4 bg-gradient-to-r from-orange-50 to-red-50 border-b border-gray-100">
                            <h3 class="text-lg font-bold text-gray-900">Update Status</h3>
                        </div>
                        <div class="p-6">
                            <form action="{{ route('admin.bookings.updateStatus', $booking) }}" method="POST" class="space-y-4">
                                @csrf
                                @method('PUT')
                                
                                <div>
                                    <label class="block text-sm font-semibold text-gray-700 mb-2">Payment Status</label>
                                    <select name="payment_status" class="w-full border-2 border-gray-200 rounded-xl px-4 py-3 text-sm focus:outline-none focus:ring-2 focus:ring-orange-500 focus:border-orange-500 transition-all duration-200">
                                        <option value="pending" {{ $booking->payment_status === 'pending' ? 'selected' : '' }}>Pending</option>
                                        <option value="confirmed" {{ $booking->payment_status === 'confirmed' ? 'selected' : '' }}>Confirmed</option>
                                        <option value="cancelled" {{ $booking->payment_status === 'cancelled' ? 'selected' : '' }}>Cancelled</option>
                                        <option value="refunded" {{ $booking->payment_status === 'refunded' ? 'selected' : '' }}>Refunded</option>
                                    </select>
                                </div>
                                
                                <div>
                                    <label class="block text-sm font-semibold text-gray-700 mb-2">Package Status</label>
                                    <select name="package_status" class="w-full border-2 border-gray-200 rounded-xl px-4 py-3 text-sm focus:outline-none focus:ring-2 focus:ring-orange-500 focus:border-orange-500 transition-all duration-200">
                                        <option value="pending" {{ $booking->package_status === 'pending' ? 'selected' : '' }}>Pending</option>
                                        <option value="confirmed" {{ $booking->package_status === 'confirmed' ? 'selected' : '' }}>Confirmed</option>
                                        <option value="in_progress" {{ $booking->package_status === 'in_progress' ? 'selected' : '' }}>In Progress</option>
                                        <option value="completed" {{ $booking->package_status === 'completed' ? 'selected' : '' }}>Completed</option>
                                        <option value="cancelled" {{ $booking->package_status === 'cancelled' ? 'selected' : '' }}>Cancelled</option>
                                    </select>
                                </div>
                                
                                <button type="submit" class="w-full inline-flex items-center justify-center gap-2 px-4 py-3 bg-gradient-to-r from-orange-600 to-red-600 text-white rounded-xl hover:from-orange-700 hover:to-red-700 transition-all duration-200 shadow-lg hover:shadow-xl transform hover:-translate-y-0.5 font-semibold">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/>
                                    </svg>
                                    Update Status
                                </button>
                            </form>
                        </div>
                    </div>

                    <!-- Booking Summary -->
                    <div class="bg-white rounded-2xl shadow-lg border border-gray-100 overflow-hidden">
                        <div class="px-6 py-4 bg-gradient-to-r from-blue-50 to-indigo-50 border-b border-gray-100">
                            <h3 class="text-lg font-bold text-gray-900">Booking Summary</h3>
                        </div>
                        <div class="p-6 space-y-4">
                            <div class="flex justify-between items-center">
                                <span class="text-gray-600">Booking ID:</span>
                                <span class="font-bold text-gray-900">#{{ $booking->booking_id }}</span>
                            </div>
                            <div class="flex justify-between items-center">
                                <span class="text-gray-600">Booking Date:</span>
                                <span class="font-bold text-gray-900">{{ \Carbon\Carbon::parse($booking->booking_date)->format('M d, Y') }}</span>
                            </div>
                            <div class="flex justify-between items-center">
                                <span class="text-gray-600">Payment Status:</span>
                                <span class="inline-flex items-center px-2 py-1 rounded-full text-xs font-semibold 
                                    {{ $booking->payment_status === 'confirmed' ? 'bg-green-100 text-green-800' : 
                                       ($booking->payment_status === 'pending' ? 'bg-yellow-100 text-yellow-800' : 
                                       ($booking->payment_status === 'cancelled' ? 'bg-red-100 text-red-800' : 'bg-gray-100 text-gray-800')) }}">
                                    {{ ucfirst($booking->payment_status) }}
                                </span>
                            </div>
                            <div class="flex justify-between items-center">
                                <span class="text-gray-600">Package Status:</span>
                                <span class="inline-flex items-center px-2 py-1 rounded-full text-xs font-semibold 
                                    {{ $booking->package_status === 'confirmed' ? 'bg-green-100 text-green-800' : 
                                       ($booking->package_status === 'pending' ? 'bg-yellow-100 text-yellow-800' : 
                                       ($booking->package_status === 'in_progress' ? 'bg-blue-100 text-blue-800' :
                                       ($booking->package_status === 'completed' ? 'bg-purple-100 text-purple-800' : 'bg-gray-100 text-gray-800'))) }}">
                                    {{ ucfirst(str_replace('_', ' ', $booking->package_status)) }}
                                </span>
                            </div>
                            @if($booking->payment_transaction_id)
                            <div class="flex justify-between items-center">
                                <span class="text-gray-600">Transaction ID:</span>
                                <span class="font-bold text-gray-900 text-sm">{{ $booking->payment_transaction_id }}</span>
                            </div>
                            @endif
                            <div class="border-t pt-4">
                                <div class="flex justify-between items-center">
                                    <span class="text-lg font-bold text-gray-900">Total Amount:</span>
                                    <span class="text-2xl font-bold text-orange-600">${{ number_format($booking->total_amount) }}</span>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Actions -->
                    <div class="bg-white rounded-2xl shadow-lg border border-gray-100 overflow-hidden">
                        <div class="px-6 py-4 bg-gradient-to-r from-red-50 to-pink-50 border-b border-gray-100">
                            <h3 class="text-lg font-bold text-gray-900">Actions</h3>
                        </div>
                        <div class="p-6 space-y-3">
                            <a href="{{ route('admin.bookings.delete', $booking) }}" 
                                class="w-full inline-flex items-center justify-center gap-2 px-4 py-3 bg-gradient-to-r from-red-600 to-red-700 text-white rounded-xl hover:from-red-700 hover:to-red-800 transition-all duration-200 shadow-lg hover:shadow-xl transform hover:-translate-y-0.5 font-semibold"
                                onclick="return confirm('Are you sure you want to delete this booking?')">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6M9 7h6m-7 0V5a2 2 0 012-2h3a2 2 0 012 2v2"/>
                                </svg>
                                Delete Booking
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-layouts.app.sidebar>