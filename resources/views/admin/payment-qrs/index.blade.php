<x-layouts.app.sidebar>
    <div class="min-h-screen bg-gradient-to-br from-slate-50 to-teal-50">
        <div class="p-6 lg:p-8 space-y-8">
            @if(session('success'))
                <div class="bg-emerald-50 border-l-4 border-emerald-400 text-emerald-700 px-6 py-4 rounded-r-lg shadow-sm" role="alert">
                    <div class="flex items-center">
                        <svg class="w-5 h-5 mr-3" fill="currentColor" viewBox="0 0 20 20">
                            <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"/>
                        </svg>
                        <span class="font-medium">{{ session('success') }}</span>
                    </div>
                </div>
            @endif

            <!-- Enhanced Header -->
            <div class="bg-white rounded-2xl shadow-lg border border-gray-100 p-8">
                <div class="flex flex-col lg:flex-row lg:items-center lg:justify-between gap-6">
                    <div class="space-y-2">
                        <div class="flex items-center gap-3">
                            <div class="p-3 bg-gradient-to-r from-teal-500 to-cyan-600 rounded-xl">
                                <svg class="w-8 h-8 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v1m6 11h2m-6 0h-2v4m0-11v3m0 0h.01M12 12h4.01M16 20h4M4 12h4m12 0h.01M5 8h2a1 1 0 001-1V5a1 1 0 00-1-1H5a1 1 0 00-1 1v2a1 1 0 001 1zm12 0h2a1 1 0 001-1V5a1 1 0 00-1-1h-2a1 1 0 00-1 1v2a1 1 0 001 1zM5 20h2a1 1 0 001-1v-2a1 1 0 00-1-1H5a1 1 0 00-1 1v2a1 1 0 001 1z" />
                                </svg>
                            </div>
                            <div>
                                <h1 class="text-3xl font-bold bg-gradient-to-r from-gray-900 to-gray-700 bg-clip-text text-transparent">Payment QR Codes</h1>
                                <p class="text-gray-600 font-medium">Manage payment QR codes for bookings</p>
                            </div>
                        </div>
                    </div>
                    <a href="{{ route('admin.payment-qrs.create') }}"
                        class="inline-flex items-center justify-center px-6 py-3 bg-gradient-to-r from-teal-600 to-cyan-600 text-white rounded-xl hover:from-teal-700 hover:to-cyan-700 transition-all duration-200 shadow-lg hover:shadow-xl transform hover:-translate-y-0.5 font-medium">
                        <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H3"></path>
                        </svg>
                        Add New QR Code
                    </a>
                </div>
            </div>

            <!-- Search and Filter Section -->
            <div class="bg-white rounded-2xl shadow-lg border border-gray-100 p-6">
                <form method="GET" action="{{ route('admin.payment-qrs.index') }}" id="filterForm" class="flex flex-col md:flex-row gap-4">
                    <!-- Search Input -->
                    <div class="flex-1">
                        <div class="relative">
                            <input type="text" name="search" value="{{ request('search') }}" 
                                placeholder="Search QR codes, descriptions..."
                                class="w-full pl-10 pr-4 py-3 border-2 border-gray-200 rounded-xl focus:outline-none focus:ring-2 focus:ring-teal-500 focus:border-teal-500 transition-all duration-200 bg-gray-50 hover:bg-white"
                                oninput="debounceSubmit()">
                            <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                <svg class="w-5 h-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/>
                                </svg>
                            </div>
                        </div>
                    </div>

                    <!-- QR Type Filter -->
                    <div class="w-full md:w-48">
                        <select name="qr_type" class="w-full px-4 py-3 border-2 border-gray-200 rounded-xl focus:outline-none focus:ring-2 focus:ring-teal-500 focus:border-teal-500 transition-all duration-200 bg-gray-50 hover:bg-white" onchange="this.form.submit()">
                            <option value="">All Types</option>
                            <option value="kbzpay" {{ request('qr_type') === 'kbzpay' ? 'selected' : '' }}>KBZPay</option>
                            <option value="ayarpay" {{ request('qr_type') === 'ayarpay' ? 'selected' : '' }}>AyarPay</option>
                            <option value="uabpay" {{ request('qr_type') === 'uabpay' ? 'selected' : '' }}>UABPay</option>
                        </select>
                    </div>

                    <!-- Amount Type Filter -->
                    <div class="w-full md:w-48">
                        <select name="amount_type" class="w-full px-4 py-3 border-2 border-gray-200 rounded-xl focus:outline-none focus:ring-2 focus:ring-teal-500 focus:border-teal-500 transition-all duration-200 bg-gray-50 hover:bg-white" onchange="this.form.submit()">
                            <option value="">All Amounts</option>
                            <option value="generic" {{ request('amount_type') === 'generic' ? 'selected' : '' }}>Generic QR</option>
                            <option value="specific" {{ request('amount_type') === 'specific' ? 'selected' : '' }}>Specific Amount</option>
                        </select>
                    </div>

                    @if(request()->hasAny(['search', 'qr_type', 'amount_type']))
                        <div class="flex items-center">
                            <a href="{{ route('admin.payment-qrs.index') }}" class="px-4 py-3 bg-gray-100 text-gray-700 rounded-xl hover:bg-gray-200 transition-all duration-200 font-medium">
                                Clear
                            </a>
                        </div>
                    @endif
                </form>
            </div>

            <script>
                let debounceTimer;
                function debounceSubmit() {
                    clearTimeout(debounceTimer);
                    debounceTimer = setTimeout(() => {
                        document.getElementById('filterForm').submit();
                    }, 500);
                }
            </script>

            <!-- QR Codes Grid -->
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
                @forelse($qrs as $qr)
                    <div class="bg-white rounded-2xl border border-gray-100 shadow-lg overflow-hidden hover:shadow-2xl hover:border-teal-200 transition-all duration-300 transform hover:-translate-y-2 group">
                        <!-- QR Header -->
                        <div class="relative h-48 bg-gradient-to-br from-teal-100 via-cyan-100 to-blue-100 overflow-hidden flex items-center justify-center">
                            <img src="{{ $qr->url }}" alt="{{ $qr->description }}" class="w-32 h-32 object-contain bg-white rounded-lg shadow-md">
                            
                            <!-- Type Badge -->
                            <div class="absolute top-4 right-4">
                                <span class="inline-flex items-center px-3 py-1 rounded-full text-xs font-semibold bg-white/90 text-gray-800 shadow-sm uppercase">
                                    {{ $qr->qr_type }}
                                </span>
                            </div>
                            
                            <!-- Amount Badge -->
                            <div class="absolute top-4 left-4">
                                <span class="inline-flex items-center px-3 py-1 rounded-full text-xs font-semibold {{ $qr->amount == 0 ? 'bg-green-100 text-green-800' : 'bg-blue-100 text-blue-800' }} shadow-sm">
                                    {{ $qr->amount == 0 ? 'Generic' : '$' . number_format($qr->amount, 2) }}
                                </span>
                            </div>
                        </div>

                        <div class="p-6">
                            <!-- Title Section -->
                            <div class="mb-4">
                                <h3 class="text-lg font-bold text-gray-900 mb-2 group-hover:text-teal-600 transition-colors duration-200">
                                    {{ $qr->description }}
                                </h3>
                                <div class="space-y-2">
                                    <div class="flex items-center text-gray-600">
                                        <svg class="w-4 h-4 mr-2 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 9V7a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2m2 4h10a2 2 0 002-2v-6a2 2 0 00-2-2H9a2 2 0 00-2 2v6a2 2 0 002 2zm7-5a2 2 0 11-4 0 2 2 0 014 0z"/>
                                        </svg>
                                        <span class="text-sm font-medium uppercase">{{ $qr->qr_type }}</span>
                                    </div>
                                    <div class="flex items-center text-gray-600">
                                        <svg class="w-4 h-4 mr-2 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1"/>
                                        </svg>
                                        <span class="text-sm font-medium">
                                            {{ $qr->amount == 0 ? 'Generic QR (Any Amount)' : '$' . number_format($qr->amount, 2) }}
                                        </span>
                                    </div>
                                </div>
                            </div>

                            <!-- Enhanced Action Buttons -->
                            <div class="flex items-center gap-2">
                                <a href="{{ route('admin.payment-qrs.edit', $qr) }}"
                                    class="flex-1 inline-flex items-center justify-center gap-2 px-3 py-2.5 rounded-xl text-sm font-medium bg-gradient-to-r from-teal-500 to-teal-600 text-white hover:from-teal-600 hover:to-teal-700 transition-all duration-200 shadow-md hover:shadow-lg transform hover:-translate-y-0.5">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5M18.5 2.5a2.121 2.121 0 013 3L12 15l-4 1 1-4 9.5-9.5z"/>
                                    </svg>
                                    Edit
                                </a>
                                <form method="POST" action="{{ route('admin.payment-qrs.destroy', $qr) }}" class="flex-1" onsubmit="return confirm('Are you sure you want to delete this QR code?')">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit"
                                        class="w-full inline-flex items-center justify-center gap-2 px-3 py-2.5 rounded-xl text-sm font-medium bg-gradient-to-r from-red-500 to-red-600 text-white hover:from-red-600 hover:to-red-700 transition-all duration-200 shadow-md hover:shadow-lg transform hover:-translate-y-0.5">
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6M9 7h6m-7 0V5a2 2 0 012-2h3a2 2 0 012 2v2"/>
                                        </svg>
                                        Delete
                                    </button>
                                </form>
                            </div>
                        </div>
                    </div>
                @empty
                    <div class="col-span-full">
                        <div class="bg-white rounded-2xl shadow-lg border border-gray-100 p-12 text-center">
                            <div class="mx-auto w-24 h-24 bg-gradient-to-br from-gray-100 to-gray-200 rounded-full flex items-center justify-center mb-6">
                                <svg class="w-12 h-12 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M12 4v1m6 11h2m-6 0h-2v4m0-11v3m0 0h.01M12 12h4.01M16 20h4M4 12h4m12 0h.01M5 8h2a1 1 0 001-1V5a1 1 0 00-1-1H5a1 1 0 00-1 1v2a1 1 0 001 1zm12 0h2a1 1 0 001-1V5a1 1 0 00-1-1h-2a1 1 0 00-1 1v2a1 1 0 001 1zM5 20h2a1 1 0 001-1v-2a1 1 0 00-1-1H5a1 1 0 00-1 1v2a1 1 0 001 1z"/>
                                </svg>
                            </div>
                            <h3 class="text-xl font-bold text-gray-900 mb-2">
                                @if(request()->hasAny(['search', 'qr_type', 'amount_type']))
                                    No QR codes match your filters
                                @else
                                    No QR codes found
                                @endif
                            </h3>
                            <p class="text-gray-600 mb-8 max-w-md mx-auto">
                                @if(request()->hasAny(['search', 'qr_type', 'amount_type']))
                                    Try adjusting your search criteria or clear the filters to see all QR codes.
                                @else
                                    Get started by adding your first payment QR code for customer bookings.
                                @endif
                            </p>
                            <a href="{{ route('admin.payment-qrs.create') }}"
                                class="inline-flex items-center px-6 py-3 bg-gradient-to-r from-teal-600 to-cyan-600 text-white rounded-xl hover:from-teal-700 hover:to-cyan-700 transition-all duration-200 shadow-lg hover:shadow-xl transform hover:-translate-y-0.5 font-medium">
                                <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H3"/>
                                </svg>
                                Create First QR Code
                            </a>
                        </div>
                    </div>
                @endforelse
            </div>
        </div>
    </div>
</x-layouts.app.sidebar>