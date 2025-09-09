<x-layouts.guest title="History - Tour Management System">
    <div class="max-w-5xl mx-auto px-4 py-16">
        <h1 class="text-4xl font-bold text-center mb-10 text-blue-800">Booking History</h1>
        <p class="text-center text-gray-600 max-w-2xl mx-auto mb-12">View all your tour bookings and their current
            status.</p>

        @if($bookings->isEmpty())
            <div class="text-center py-12">
                <div class="mx-auto w-24 h-24 bg-gray-100 rounded-full flex items-center justify-center mb-6">
                    <svg class="w-12 h-12 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5"
                            d="M9 5H7a2 2 0 00-2 2v10a2 2 0 002 2h8a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2" />
                    </svg>
                </div>
                <h3 class="text-xl font-bold text-gray-900 mb-2">No bookings yet</h3>
                <p class="text-gray-600 mb-6">Start exploring our tour packages and make your first booking!</p>
                <a href="{{ route('packages') }}"
                    class="inline-flex items-center px-6 py-3 bg-blue-600 text-white rounded-lg hover:bg-blue-700 transition">
                    Browse Packages
                </a>
            </div>
        @else
            <div class="space-y-6">
                @foreach($bookings as $booking)
                    <div class="rounded-lg border border-gray-200 bg-white p-6 shadow-sm">
                        <div class="flex flex-wrap items-start justify-between gap-4 mb-4">
                            <div class="flex-1">
                                <h3 class="font-semibold text-gray-900 text-lg">
                                    {{ $booking->schedule->touristPackage->package_name ?? 'Package' }}
                                </h3>
                                <p class="text-sm text-gray-600 mt-1">
                                    {{ \Carbon\Carbon::parse($booking->schedule->from_date)->format('M d, Y') }} -
                                    {{ \Carbon\Carbon::parse($booking->schedule->to_date)->format('M d, Y') }}
                                </p>
                                <p class="text-sm text-gray-500 mt-1">
                                    {{ $booking->schedule->touristPackage->destination->destination_name ?? 'Destination' }} •
                                    Guide: {{ $booking->schedule->touristPackage->guide->gname ?? 'N/A' }}
                                </p>
                            </div>
                            <div class="flex flex-col items-end gap-2">
                                <div class="flex gap-2">
                                    <span
                                        class="text-xs inline-flex items-center px-2 py-1 rounded-full font-medium
                                                        {{ $booking->booking_status === 'confirmed' ? 'bg-green-100 text-green-800' :
                    ($booking->booking_status === 'pending' ? 'bg-yellow-100 text-yellow-800' : 'bg-red-100 text-red-800') }}">
                                        {{ ucfirst($booking->booking_status) }}
                                    </span>
                                </div>
                                <span class="font-semibold text-gray-900">${{ number_format($booking->total_amount, 2) }}</span>
                            </div>
                        </div>

                        <div class="border-t pt-4">
                            <div class="grid grid-cols-1 md:grid-cols-3 gap-4 text-sm">
                                <div>
                                    <span class="text-gray-500">Booking ID:</span>
                                    <span
                                        class="font-medium text-gray-900">BK-{{ str_pad($booking->booking_id, 6, '0', STR_PAD_LEFT) }}</span>
                                </div>
                                <div>
                                    <span class="text-gray-500">Payment Method:</span>
                                    <span class="font-medium text-gray-900">{{ $booking->payment_method }}</span>
                                </div>
                                <div>
                                    <span class="text-gray-500">Hotel:</span>
                                    <span
                                        class="font-medium text-gray-900">{{ $booking->roomChoices->first()?->accommodation?->hotel?->name ?? 'N/A' }}</span>
                                </div>
                            </div>

                            @if($booking->special_request)
                                <div class="mt-3 text-sm">
                                    <span class="text-gray-500">Special Request:</span>
                                    <span class="text-gray-700">{{ $booking->special_request }}</span>
                                </div>
                            @endif

                            <div class="mt-4 flex justify-end">
                                <a href="{{ route('booking.ticket', $booking->booking_id) }}"
                                    class="inline-flex items-center px-4 py-2 bg-blue-600 text-white text-sm rounded-lg hover:bg-blue-700 transition">
                                    View E-Ticket
                                </a>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
        @endif
    </div>
</x-layouts.guest>