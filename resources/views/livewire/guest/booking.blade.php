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
                <!-- STEP 1 -->
                <section x-show="step === 1" class="space-y-6">
                    <h2 class="text-lg font-semibold text-gray-900">Choose Hotel & Room</h2>

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
                                                x-on:change="selectAccommodation('{{ $acc->accom_id }}','{{ $hotel->hotel_id }}','{{ $hotel->name }}','{{ $acc->room?->room_type ?? 'Room' }}')"
                                                required>
                                            <div
                                                class="rounded-md border border-gray-200 bg-gray-50 p-3 text-xs flex flex-col gap-1 peer-checked:border-blue-500 peer-checked:ring-2 peer-checked:ring-blue-200 transition">
                                                <span class="font-medium text-gray-800">
                                                    {{ $acc->room?->room_type ?? 'Room' }}
                                                </span>
                                                <span class="text-gray-500">
                                                    Ref #{{ $acc->accom_id }}
                                                </span>
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

                    <div class="flex justify-end">
                        <button type="button" x-on:click="goToDetails"
                            class="inline-flex items-center rounded-md bg-blue-600 px-5 py-2.5 text-sm font-medium text-white shadow hover:bg-blue-500 disabled:opacity-40 disabled:cursor-not-allowed transition"
                            :disabled="!selectedAccom">
                            Continue
                        </button>
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

                    <div class="space-y-3">
                        <label class="text-xs font-semibold tracking-wide text-gray-700">Payment Method
                            (Required)</label>
                        <div class="grid sm:grid-cols-3 gap-3">
                            @foreach(['KBZPay', 'AyarPay', 'UABPay'] as $method)
                                <label class="relative cursor-pointer">
                                    <input type="radio" name="payment_status" value="{{ $method }}" class="peer sr-only"
                                        x-model="form.payment_status" required>
                                    <div
                                        class="rounded-md border border-gray-300 bg-white px-4 py-3 flex items-center justify-center text-sm font-medium text-gray-700 peer-checked:border-blue-500 peer-checked:ring-2 peer-checked:ring-blue-200 peer-checked:text-blue-700 transition">
                                        {{ $method }}
                                    </div>
                                </label>
                            @endforeach
                        </div>
                        <p class="text-[11px] text-gray-500">
                            You will receive instructions for the selected payment provider. Status will remain pending
                            until verified.
                        </p>
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
                            <span class="font-medium text-gray-800" x-text="form.payment_status || '—'"></span>
                        </div>
                        <div class="flex justify-between">
                            <span class="text-gray-500">Payment Status</span>
                            <span class="font-medium text-yellow-600"
                                x-text="form.payment_status ? 'pending' : '—'"></span>
                        </div>
                        <div class="flex justify-between">
                            <span class="text-gray-500">Package</span>
                            <span class="font-medium text-gray-800">
                                {{ $schedule->touristPackage?->package_name ?? '—' }}
                            </span>
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
                            <span class="text-gray-500">Payment Status</span>
                            <span class="font-medium text-yellow-600">pending</span>
                        </div>
                        <div class="flex justify-between">
                            <span class="text-gray-500">Package Status</span>
                            <span class="font-medium text-yellow-600">pending</span>
                        </div>
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
            return {
                step: 1,
                submitting: false,
                selectedAccom: null,
                selectedHotel: null,
                selectedHotelName: '',
                selectedRoomType: '',
                form: {
                    phone: '',
                    nationality: '',
                    address: '',
                    special_request: '',
                    payment_status: ''
                },
                selectAccommodation(accomId, hotelId, hotelName, roomType) {
                    this.selectedAccom = accomId;
                    this.selectedHotel = hotelId;
                    this.selectedHotelName = hotelName;
                    this.selectedRoomType = roomType;
                },
                goToDetails() {
                    if (this.selectedAccom) this.step = 2;
                },
                goToConfirm() {
                    if (this.form.phone.trim() === '') {
                        alert('Phone is required.');
                        return;
                    }
                    if (!this.form.payment_status) {
                        alert('Select a payment method.');
                        return;
                    }
                    this.step = 3;
                }
            }
        }
    </script>
</x-layouts.guest>