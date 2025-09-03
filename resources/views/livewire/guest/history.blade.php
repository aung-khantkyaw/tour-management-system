<x-layouts.guest title="History - Tour Management System">
    <div class="max-w-5xl mx-auto px-4 py-16">
        <h1 class="text-4xl font-bold text-center mb-10 text-blue-800">Booking History</h1>
        <p class="text-center text-gray-600 max-w-2xl mx-auto mb-12">A simple static history view placeholder. Integrate
            with real booking data later. This shows a mock layout for past and upcoming bookings.</p>

        <div class="space-y-10">
            <div>
                <h2 class="text-xl font-semibold text-gray-900 mb-4">Upcoming</h2>
                <div class="grid md:grid-cols-2 gap-6">
                    <div class="rounded-lg border border-gray-200 bg-white p-5 shadow-sm flex flex-col">
                        <div class="flex items-start justify-between mb-2">
                            <h3 class="font-semibold text-gray-900">Inle Lake Adventure</h3>
                            <span
                                class="text-xs inline-flex items-center px-2 py-0.5 rounded-full bg-blue-100 text-blue-700 font-medium">Paid</span>
                        </div>
                        <p class="text-sm text-gray-600 mb-2">March 22-25, 2024</p>
                        <p class="text-xs text-gray-500">2 Travelers • Guide Included</p>
                        <div class="mt-4 flex items-center justify-between text-xs text-gray-500">
                            <span>Ref: BK-2024-1042</span>
                            <span class="font-medium text-gray-700">$480</span>
                        </div>
                    </div>
                    <div class="rounded-lg border border-gray-200 bg-white p-5 shadow-sm flex flex-col">
                        <div class="flex items-start justify-between mb-2">
                            <h3 class="font-semibold text-gray-900">Coast & Culture</h3>
                            <span
                                class="text-xs inline-flex items-center px-2 py-0.5 rounded-full bg-yellow-100 text-yellow-800 font-medium">Pending</span>
                        </div>
                        <p class="text-sm text-gray-600 mb-2">April 5-10, 2024</p>
                        <p class="text-xs text-gray-500">1 Traveler • Flight Add-on</p>
                        <div class="mt-4 flex items-center justify-between text-xs text-gray-500">
                            <span>Ref: BK-2024-1090</span>
                            <span class="font-medium text-gray-700">$699</span>
                        </div>
                    </div>
                </div>
            </div>

            <div>
                <h2 class="text-xl font-semibold text-gray-900 mb-4">Past</h2>
                <div class="space-y-4">
                    <div class="rounded-lg border border-gray-200 bg-white p-5 shadow-sm">
                        <div class="flex flex-wrap items-center justify-between gap-2">
                            <div>
                                <h3 class="font-semibold text-gray-900">Bagan Heritage Tour</h3>
                                <p class="text-sm text-gray-600">Jan 12-15, 2024 • 3 Nights</p>
                            </div>
                            <div class="flex items-center gap-2 text-xs">
                                <span
                                    class="inline-flex items-center px-2 py-0.5 rounded-full bg-green-100 text-green-700 font-medium">Completed</span>
                                <span class="font-medium text-gray-800">$299</span>
                            </div>
                        </div>
                        <p class="text-xs text-gray-500 mt-3">Guide: Aung Ko • Accommodation: Standard Hotel • Rating
                            pending</p>
                    </div>
                    <div class="rounded-lg border border-gray-200 bg-white p-5 shadow-sm">
                        <div class="flex flex-wrap items-center justify-between gap-2">
                            <div>
                                <h3 class="font-semibold text-gray-900">City Explorer Day Trip</h3>
                                <p class="text-sm text-gray-600">Dec 08, 2023 • 1 Day</p>
                            </div>
                            <div class="flex items-center gap-2 text-xs">
                                <span
                                    class="inline-flex items-center px-2 py-0.5 rounded-full bg-green-100 text-green-700 font-medium">Completed</span>
                                <span class="font-medium text-gray-800">$89</span>
                            </div>
                        </div>
                        <p class="text-xs text-gray-500 mt-3">Guide: Thida • Minimal gear required • Rating pending</p>
                    </div>
                </div>
            </div>
        </div>

        <div class="mt-16 text-center text-xs text-gray-500">Data shown above is sample only. Hook this page to actual
            bookings later.</div>
    </div>
</x-layouts.guest>