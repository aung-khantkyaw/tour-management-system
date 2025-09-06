<x-layouts.guest :title="'Book Schedule #' . $schedule->schedule_id . ' - Tour Management System'">
    <div class="max-w-4xl mx-auto px-4 py-16">
        <a href="{{ url()->previous() }}" class="text-sm text-blue-600 hover:underline">&larr; Back</a>

        <div class="mt-4 rounded-xl border border-gray-200 bg-white shadow-sm p-8 space-y-10" x-data="bookingWizard()"
            x-cloak>
            <header class="space-y-2">
                <h1 class="text-3xl font-bold text-blue-800">
                    Book: {{ $schedule->touristPackage?->package_name ?? 'Package #' . $schedule->package_id }}
                </h1>
                <p class="text-sm text-gray-600">
                    {{ \Illuminate\Support\Carbon::parse($schedule->from_date)->format('M d, Y') }} –
                    {{ \Illuminate\Support\Carbon::parse($schedule->to_date)->format('M d, Y') }}
                    @if($schedule->touristPackage)
                        · Destination:
                        <span class="font-medium text-gray-800">
                            {{ $schedule->touristPackage->destination?->destination_name ?? 'Unknown' }}
                        </span>
                        · Duration: {{ $schedule->touristPackage->duration_days }} days
                        · Capacity: {{ $schedule->touristPackage->no_of_people }}
                    @endif
                </p>
            </header>

            <!-- Progress -->
            <div class="flex items-center justify-between text-xs font-medium tracking-wide">
                <div class="flex-1 flex items-center gap-2">
                    <div :class="step >= 1 ? 'bg-blue-600 text-white' : 'bg-gray-200 text-gray-500'"
                        class="h-7 w-7 rounded-full flex items-center justify-center">1</div>
                    <span :class="step >= 1 ? 'text-gray-900' : 'text-gray-500'">Accommodation</span>
                </div>
                <div class="h-0.5 flex-1 mx-4" :class="step >= 2 ? 'bg-blue-600' : 'bg-gray-200'"></div>
                <div class="flex-1 flex items-center gap-2">
                    <div :class="step >= 2 ? 'bg-blue-600 text-white' : 'bg-gray-200 text-gray-500'"
                        class="h-7 w-7 rounded-full flex items-center justify-center">2</div>
                    <span :class="step >= 2 ? 'text-gray-900' : 'text-gray-500'">Details</span>
                </div>
                <div class="h-0.5 flex-1 mx-4" :class="step >= 3 ? 'bg-blue-600' : 'bg-gray-200'"></div>
                <div class="flex-1 flex items-center gap-2">
                    <div :class="step >= 3 ? 'bg-blue-600 text-white' : 'bg-gray-200 text-gray-500'"
                        class="h-7 w-7 rounded-full flex items-center justify-center">3</div>
                    <span :class="step >= 3 ? 'text-gray-900' : 'text-gray-500'">Confirm</span>
                </div>
            </div>

            <form method="POST" action="{{ route('bookings.store') }}" @submit="submitting=true">
                @csrf
                <input type="hidden" name="schedule_id" value="{{ $schedule->schedule_id }}">
                <input type="hidden" name="hotel_id" :value="selectedHotel">
                <input type="hidden" name="calculated_total" :value="totalPrice">
                <input type="hidden" name="package_type" :value="packageType">
                <!-- STEP 1 -->
                <section x-show="step === 1" class="space-y-6">
                    <h2 class="text-lg font-semibold text-gray-900">Choose Package Type & Hotel</h2>

                    <div class="space-y-4">
                        <label class="text-sm font-semibold text-gray-700">Package Type <span
                                class="text-red-500">*</span></label>
                        <div class="grid sm:grid-cols-2 gap-3">
                            <label class="relative cursor-pointer">
                                <input type="radio" name="package_type" value="single" class="peer sr-only"
                                    x-model="packageType" x-on:change="updatePackagePrice()" required>
                                <div
                                    class="rounded-md border border-gray-300 bg-white p-4 peer-checked:border-blue-500 peer-checked:ring-2 peer-checked:ring-blue-200 transition">
                                    <div class="font-medium text-gray-800">Single Package</div>
                                    <div class="text-sm text-gray-600">Individual traveler package</div>
                                    <div class="text-xs text-blue-600 font-medium mt-1">
                                        ${{ number_format($schedule->touristPackage?->singlepackage_fee ?? 0, 2) }}
                                    </div>
                                </div>
                            </label>
                            <label class="relative cursor-pointer">
                                <input type="radio" name="package_type" value="full" class="peer sr-only"
                                    x-model="packageType" x-on:change="updatePackagePrice()" required>
                                <div
                                    class="rounded-md border border-gray-300 bg-white p-4 peer-checked:border-blue-500 peer-checked:ring-2 peer-checked:ring-blue-200 transition">
                                    <div class="font-medium text-gray-800">Full Package</div>
                                    <div class="text-sm text-gray-600">Complete group package</div>
                                    <div class="text-xs text-blue-600 font-medium mt-1">
                                        ${{ number_format($schedule->touristPackage?->fullpackage_fee ?? 0, 2) }}</div>
                                </div>
                            </label>
                        </div>
                    </div>

                    <div x-show="packageType" class="space-y-4">
                        <h3 class="text-md font-semibold text-gray-900">Choose Hotel & Room</h3>

                        @if($hotels->isEmpty())
                            <p class="text-sm text-gray-500">No hotels available for this destination.</p>
                        @else
                        <div class="space-y-6">
                            @foreach($hotels as $hotel)
                            @php($rating = (float) ($hotel->rating ?? 0))
                            <div class="rounded-lg border border-gray-200 p-5 hover:border-blue-300 transition">
                                <div class="flex flex-col sm:flex-row sm:items-start sm:justify-between gap-4">
                                    <div>
                                        <h3 class="font-semibold text-gray-900">
                                            {{ $hotel->name }}
                                        </h3>
                                        <div class="flex items-center gap-2 mt-1">
                                            <div class="flex">
                                                @for($i = 1; $i <= 5; $i++)
                                                    <svg class="h-4 w-4 {{ $rating >= $i ? 'text-yellow-400' : 'text-gray-300' }}"
                                                        viewBox="0 0 20 20" fill="currentColor">
                                                        <path
                                                            d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 0 0 .95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.802 2.038a1 1 0 0 0-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118L11 14.347a1 1 0 0 0-1.175 0L7.615 16.285c-.785.57-1.84-.197-1.54-1.118l1.07-3.292a1 1 0 0 0-.364-1.118L3.98 8.72c-.783-.57-.38-1.81.588-1.81H8.03a1 1 0 0 0 .95-.69l1.07-3.292Z" />
                                                    </svg>
                                                @endfor
                                            </div>
                                            <span class="text-xs text-gray-600">
                                                {{ $rating > 0 ? number_format($rating, 1) : 'No rating' }}
                                            </span>
                                        </div>
                                        <p class="text-xs text-gray-500 mt-1">
                                            {{ $hotel->contact_no ?? 'No contact' }}
                                        </p>
                                    </div>
                                </div>

                                @if($hotel->accommodations->isNotEmpty())
                                    <div class="mt-4 grid sm:grid-cols-2 lg:grid-cols-3 gap-3">
                                        @foreach($hotel->accommodations as $acc)
                                            <label class="relative cursor-pointer">
                                                <input type="radio" name="accom_id" value="{{ $acc->accom_id }}"
                                                    class="peer sr-only"
                                                    x-on:change="selectAccommodation('{{ $acc->accom_id }}','{{ $hotel->hotel_id }}','{{ $hotel->name }}','{{ $acc->room?->room_type ?? 'Room' }}', {{ (float) ($acc->price ?? 0) }})"
                                                    required>
                                                <div
                                                    class="rounded-md border border-gray-200 bg-gray-50 p-3 text-xs flex flex-col gap-1 peer-checked:border-blue-500 peer-checked:ring-2 peer-checked:ring-blue-200 transition">
                                                    <span class="font-medium text-gray-800">
                                                        {{ $acc->room?->room_type ?? 'Room' }}
                                                    </span>
                                                    <span class="text-gray-500">
                                                        Ref #{{ $acc->accom_id }}
                                                    </span>
                                                    <span class="text-[11px] text-gray-600">Room Price:
                                                        ${{ number_format($acc->price ?? 0, 2) }}</span>
                                                </div>
                                            </label>
                                        @endforeach
                                    </div>
                                @else
                                    <p class="mt-3 text-xs text-gray-500">No rooms listed.</p>
                                @endif
                            </div>
                            @endforeach
                        </div>
                        @endif

                        <div class="space-y-4">
                            <template x-if="selectedAccom">
                                <div
                                    class="rounded-md border border-blue-200 bg-blue-50 p-4 text-xs space-y-2 max-w-sm">
                                    <div class="flex justify-between"><span class="text-gray-600">Package
                                            Price</span><span class="font-medium text-gray-800"
                                            x-text="formatCurrency(packagePrice)"></span></div>
                                    <div class="flex justify-between"><span class="text-gray-600">Room Price</span><span
                                            class="font-medium text-gray-800" x-text="formatCurrency(roomPrice)"></span>
                                    </div>
                                    <hr class="border-blue-200">
                                    <div class="flex justify-between"><span
                                            class="text-gray-700 font-semibold">Total</span><span
                                            class="text-blue-700 font-semibold"
                                            x-text="formatCurrency(totalPrice)"></span></div>
                                </div>
                            </template>
                            <div class="flex justify-end">
                                <button type="button" x-on:click="goToDetails"
                                    class="inline-flex items-center rounded-md bg-blue-600 px-5 py-2.5 text-sm font-medium text-white shadow hover:bg-blue-500 disabled:opacity-40 disabled:cursor-not-allowed transition"
                                    :disabled="!selectedAccom || !packageType">
                                    Continue
                                </button>
                            </div>
                        </div>
                    </div>
                </section>

                <!-- STEP 2: Traveler Details -->
                <section x-show="step === 2" class="space-y-8">
                    <h2 class="text-lg font-semibold text-gray-900">Traveler Details</h2>

                    <div class="grid md:grid-cols-3 gap-5">
                        <div class="flex flex-col gap-1.5">
                            <label class="text-xs font-semibold tracking-wide text-gray-700">Phone <span
                                    class="text-red-500">*</span></label>
                            <input name="phone" x-model="form.phone" required
                                class="rounded-md border border-gray-300 bg-white px-3 py-2.5 text-sm text-gray-900 placeholder:text-gray-500 shadow-sm focus:border-blue-500 focus:outline-none focus:ring-4 focus:ring-blue-100 transition"
                                placeholder="+95 912345678">
                        </div>
                        <div class="flex flex-col gap-1.5">
                            <label class="text-xs font-semibold tracking-wide text-gray-700">Nationality</label>
                            <input name="nationality" x-model="form.nationality"
                                class="rounded-md border border-gray-300 bg-white px-3 py-2.5 text-sm text-gray-900 placeholder:text-gray-500 shadow-sm focus:border-blue-500 focus:outline-none focus:ring-4 focus:ring-blue-100 transition"
                                placeholder="Myanmar">
                        </div>
                        <div class="flex flex-col gap-1.5">
                            <label class="text-xs font-semibold tracking-wide text-gray-700">Address</label>
                            <input name="address" x-model="form.address"
                                class="rounded-md border border-gray-300 bg-white px-3 py-2.5 text-sm text-gray-900 placeholder:text-gray-500 shadow-sm focus:border-blue-500 focus:outline-none focus:ring-4 focus:ring-blue-100 transition"
                                placeholder="Street, City">
                        </div>
                    </div>

                    <div class="flex flex-col gap-1.5">
                        <label class="text-xs font-semibold tracking-wide text-gray-700">Special Request</label>
                        <textarea name="special_request" x-model="form.special_request" rows="3"
                            class="rounded-md border border-gray-300 bg-white px-3 py-2.5 text-sm text-gray-900 placeholder:text-gray-500 shadow-sm focus:border-blue-500 focus:outline-none focus:ring-4 focus:ring-blue-100 transition resize-none"
                            placeholder="Dietary, accessibility, other notes"></textarea>
                    </div>

                    <div class="space-y-4">
                        <div class="space-y-4">
                            <label class="text-xs font-semibold tracking-wide text-gray-700">Payment Method
                                (Required)</label>
                            <div class="mt-2 grid sm:grid-cols-3 gap-3">
                                @foreach(['KBZPay', 'AyarPay', 'UABPay'] as $method)
                                    <label class="relative cursor-pointer">
                                        <input type="radio" name="payment_method" value="{{ $method }}" class="peer sr-only"
                                            x-model="form.payment_method" required
                                            x-on:change="showQr('{{ strtolower($method) }}')">
                                        <div
                                            class="rounded-md border border-gray-300 bg-white px-4 py-3 flex items-center justify-center text-sm font-medium text-gray-700 peer-checked:border-blue-500 peer-checked:ring-2 peer-checked:ring-blue-200 peer-checked:text-blue-700 transition">
                                            {{ $method }}
                                        </div>
                                    </label>
                                @endforeach
                            </div>
                            <p class="text-[11px] text-gray-500">Select a payment provider to view its QR code. Total
                                Due: <span class="font-medium text-gray-700" x-text="formatCurrency(totalPrice)"></span>
                            </p>
                            <template x-if="form.payment_method">
                                <div
                                    class="rounded-md border border-gray-200 bg-gray-50 p-3 text-xs space-y-1 max-w-sm">
                                    <div class="flex justify-between"><span class="text-gray-600">Package</span><span
                                            class="font-medium text-gray-900"
                                            x-text="formatCurrency(packagePrice)"></span></div>
                                    <div class="flex justify-between"><span class="text-gray-600">Room</span><span
                                            class="font-medium text-gray-900" x-text="formatCurrency(roomPrice)"></span>
                                    </div>
                                    <hr class="border-gray-200">
                                    <div class="flex justify-between"><span
                                            class="text-gray-700 font-semibold">Total</span><span
                                            class="text-blue-700 font-semibold"
                                            x-text="formatCurrency(totalPrice)"></span></div>
                                </div>
                            </template>
                        </div>

                        <div x-show="form.payment_method" class="space-y-2">
                            <label class="text-xs font-semibold tracking-wide text-gray-700">Payment Transaction ID <span
                                    class="text-red-500">*</span></label>
                            <input name="payment_transaction_id" x-model="form.payment_transaction_id" required
                                class="rounded-md border border-gray-300 bg-white px-3 py-2.5 text-sm text-gray-900 placeholder:text-gray-500 shadow-sm focus:border-blue-500 focus:outline-none focus:ring-4 focus:ring-blue-100 transition"
                                placeholder="Enter 20-digit payment transaction ID" pattern="[0-9]{20}" maxlength="20"
                                minlength="20" oninput="this.value = this.value.replace(/[^0-9]/g, '').slice(0, 20)">
                            <p class="text-[11px] text-gray-500">Enter the 20-digit payment transaction ID from your payment app
                                after completing the payment</p>
                        </div>

                        <template x-if="activeQr">
                            <div
                                class="rounded-lg border border-blue-200 bg-blue-50 p-5 flex flex-col md:flex-row md:items-center gap-6">
                                <div class="flex-1">
                                    <h3 class="text-sm font-semibold text-blue-900 mb-2" x-text="activeQrLabel"></h3>
                                    <p class="text-xs text-blue-800 leading-relaxed">Scan the QR with your <span
                                            class="font-medium" x-text="form.payment_method"></span> app. After payment,
                                        keep the transaction reference. Booking remains <span
                                            class="font-semibold">pending</span> until an admin verifies.</p>
                                </div>
                                <div
                                    class="w-44 h-44 rounded-md bg-white border border-blue-200 shadow-inner flex items-center justify-center overflow-hidden">
                                    <img :src="activeQr.url" :alt="activeQr.description || 'Payment QR'"
                                        class="w-full h-full object-contain text-gray-900" />
                                </div>
                            </div>
                        </template>
                    </div>

                    <div class="flex items-center justify-between pt-4">
                        <button type="button" x-on:click="step = 1" class="text-sm text-gray-500 hover:text-gray-700">
                            &larr; Back
                        </button>
                        <button type="button" x-on:click="goToConfirm"
                            class="inline-flex items-center rounded-md bg-blue-600 px-5 py-2.5 text-sm font-medium text-white shadow hover:bg-blue-500 transition">
                            Review
                        </button>
                    </div>
                </section>

                <!-- STEP 3: Confirm -->
                <section x-show="step === 3" class="space-y-6">
                    <h2 class="text-lg font-semibold text-gray-900">Confirm Booking</h2>
                    <p class="text-sm text-gray-600">
                        Review all details. Submitting will set booking status to pending.
                    </p>

                    <div class="rounded-lg border border-gray-200 bg-gray-50 p-5 space-y-4 text-sm">
                        <div class="flex justify-between">
                            <span class="text-gray-500">Payment Method</span>
                            <span class="font-medium text-gray-800" x-text="form.payment_method || '—'"></span>
                        </div>
                        <div class="flex justify-between">
                            <span class="text-gray-500">Payment Status</span>
                            <span class="font-medium text-yellow-600"
                                x-text="form.payment_method ? 'pending' : '—'"></span>
                        </div>
                        <div class="flex justify-between">
                            <span class="text-gray-500">Package</span>
                            <span class="font-medium text-gray-800">
                                {{ $schedule->touristPackage?->package_name ?? '—' }}
                            </span>
                        </div>
                        <div class="flex justify-between">
                            <span class="text-gray-500">Package Type</span>
                            <span class="font-medium text-gray-800 capitalize" x-text="packageType || '—'"></span>
                        </div>
                        <div class="flex justify-between">
                            <span class="text-gray-500">Destination</span>
                            <span class="font-medium text-gray-800">
                                {{ $schedule->touristPackage?->destination?->destination_name ?? '—' }}
                            </span>
                        </div>
                        <div class="flex justify-between">
                            <span class="text-gray-500">Dates</span>
                            <span class="font-medium text-gray-800">
                                {{ \Illuminate\Support\Carbon::parse($schedule->from_date)->format('M d, Y') }} –
                                {{ \Illuminate\Support\Carbon::parse($schedule->to_date)->format('M d, Y') }}
                            </span>
                        </div>
                        <div class="flex justify-between">
                            <span class="text-gray-500">Hotel</span>
                            <span class="font-medium text-gray-800" x-text="selectedHotelName || '—'"></span>
                        </div>
                        <div class="flex justify-between">
                            <span class="text-gray-500">Room Type</span>
                            <span class="font-medium text-gray-800" x-text="selectedRoomType || '—'"></span>
                        </div>
                        <div class="flex justify-between">
                            <span class="text-gray-500">Phone</span>
                            <span class="font-medium text-gray-800" x-text="form.phone || '—'"></span>
                        </div>
                        <div class="flex justify-between">
                            <span class="text-gray-500">Nationality</span>
                            <span class="font-medium text-gray-800" x-text="form.nationality || '—'"></span>
                        </div>
                        <div class="flex justify-between">
                            <span class="text-gray-500">Address</span>
                            <span class="font-medium text-gray-800" x-text="form.address || '—'"></span>
                        </div>
                        <div class="flex justify-between">
                            <span class="text-gray-500">Special Request</span>
                            <span class="font-medium text-gray-800 truncate max-w-[55%]"
                                x-text="form.special_request ? form.special_request : '—'"></span>
                        </div>
                        <div class="flex justify-between">
                            <span class="text-gray-500">Payment Transaction ID</span>
                            <span class="font-medium text-gray-800" x-text="form.payment_transaction_id || '—'"></span>
                        </div>
                        <div class="flex justify-between"><span class="text-gray-500">Package Price</span><span
                                class="font-medium text-gray-800" x-text="formatCurrency(packagePrice)"></span></div>
                        <div class="flex justify-between"><span class="text-gray-500">Room Price</span><span
                                class="font-medium text-gray-800" x-text="formatCurrency(roomPrice)"></span></div>
                        <div class="flex justify-between"><span class="text-gray-700 font-semibold">Total</span><span
                                class="text-blue-700 font-semibold" x-text="formatCurrency(totalPrice)"></span></div>
                    </div>

                    <div class="flex items-center justify-between pt-4">
                        <button type="button" x-on:click="step = 2" class="text-sm text-gray-500 hover:text-gray-700">
                            &larr; Back
                        </button>
                        <button type="submit" :disabled="submitting"
                            class="inline-flex items-center rounded-md bg-blue-600 px-6 py-2.5 text-sm font-medium text-white shadow hover:bg-blue-500 focus:outline-none focus:ring-4 focus:ring-blue-200 disabled:opacity-50 transition">
                            <span x-show="!submitting">Submit & Get E‑Ticket</span>
                            <span x-show="submitting">Processing...</span>
                        </button>
                    </div>
                </section>
            </form>
        </div>
    </div>

    <script src="https://unpkg.com/alpinejs@3.x.x/dist/cdn.min.js" defer></script>
    <script>
        function bookingWizard() {
            const qrs = {!! json_encode($paymentQrs->map(function ($q) {
    return ['type' => $q->qr_type, 'url' => $q->url, 'description' => $q->description, 'amount' => (int) $q->amount]; }) ?? []) !!};
            return {
                step: 1,
                submitting: false,
                packageType: '',
                selectedAccom: null,
                selectedHotel: null,
                selectedHotelName: '',
                selectedRoomType: '',
                singlePrice: parseFloat(@json($schedule->touristPackage?->singlepackage_fee ?? 0)),
                fullPrice: parseFloat(@json($schedule->touristPackage?->fullpackage_fee ?? 0)),
                packagePrice: 0,
                roomPrice: 0,
                totalPrice: 0,
                qrs: qrs,
                activeQr: null,
                activeQrLabel: '',
                form: {
                    phone: '',
                    nationality: '',
                    address: '',
                    special_request: '',
                    payment_method: '',
                    payment_transaction_id: ''
                },
                updatePackagePrice() {
                    this.packagePrice = this.packageType === 'single' ? this.singlePrice : this.fullPrice;
                    this.totalPrice = this.packagePrice + this.roomPrice;
                    if (this.form.payment_method) { this.showQr(this.form.payment_method.toLowerCase()); }
                },
                selectAccommodation(accomId, hotelId, hotelName, roomType, roomPrice) {
                    this.selectedAccom = accomId;
                    this.selectedHotel = hotelId;
                    this.selectedHotelName = hotelName;
                    this.selectedRoomType = roomType;
                    this.roomPrice = parseFloat(roomPrice || 0);
                    this.totalPrice = this.packagePrice + this.roomPrice;
                    if (this.form.payment_method) { this.showQr(this.form.payment_method.toLowerCase()); }
                },
                goToDetails() {
                    if (this.selectedAccom && this.packageType) this.step = 2;
                },
                goToConfirm() {
                    if (this.form.phone.trim() === '') {
                        alert('Phone is required.');
                        return;
                    }
                    if (!this.form.payment_method) {
                        alert('Select a payment method.');
                        return;
                    }
                    if (this.form.payment_transaction_id.trim() === '') {
                        alert('Payment Transaction ID is required.');
                        return;
                    }
                    if (!/^[0-9]{20}$/.test(this.form.payment_transaction_id)) {
                        alert('Payment Transaction ID must be exactly 20 digits.');
                        return;
                    }
                    this.step = 3;
                },
                showQr(key) {
                    const matches = this.qrs.filter(q => q.type === key.toLowerCase());
                    let found = matches.find(q => q.amount === Math.round(this.totalPrice));
                    if (!found) { found = matches.find(q => q.amount === 0); }
                    this.activeQr = found || null;
                    this.activeQrLabel = found && found.description ? found.description : (this.form.payment_method + ' QR Code');
                },
                formatCurrency(v) {
                    return '$' + Number(v || 0).toFixed(2);
                }
            }
        }
    </script>
</x-layouts.guest>