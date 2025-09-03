<x-layouts.guest :title="'E‑Ticket ' . $eticket . ' - Tour Management System'">
    <style>
        @media print {
            body * {
                visibility: hidden !important;
            }

            #ticket-print-area,
            #ticket-print-area * {
                visibility: visible !important;
            }

            #ticket-print-area {
                position: absolute;
                inset: 0;
                margin: 0 !important;
                padding: 0 !important;
                box-shadow: none !important;
                border: none !important;
                width: 100%;
            }

            .no-print {
                display: none !important;
            }

            /* .ticket-watermark {
                opacity: .12 !important;
            } */
        }

        .ticket-watermark {
            position: absolute;
            inset: 0;
            display: flex;
            align-items: center;
            justify-content: center;
            pointer-events: none;
            z-index: 0;
            mix-blend-mode: luminosity;
            /* subtle */
        }

        .ticket-watermark .wm-icon {
            filter: grayscale(100%);
        }

        /* fallback if Tailwind not covering sizes */
        .wm-text {
            font-size: 3.2rem;
            line-height: 1;
            font-weight: 700;
            letter-spacing: .08em;
            text-transform: uppercase;
        }
    </style>

    <!-- Heading / actions (not printed) -->
    <div class="max-w-4xl mx-auto px-4 pt-12 pb-4 flex items-center justify-between no-print">
        <!-- <a href="{{ route('schedules') }}" class="text-sm text-blue-600 hover:underline">Back</a> -->
        <h1 class="text-3xl font-bold text-blue-800">Your E‑Ticket</h1>
        <div class="flex gap-3">
            <button onclick="window.print()"
                class="inline-flex items-center rounded-md border border-gray-300 bg-white px-4 py-2 text-sm font-medium text-gray-700 shadow-sm hover:bg-gray-100 transition">
                Print / Save PDF
            </button>
        </div>
    </div>

    <!-- PRINTABLE CARD ONLY -->
    <div id="ticket-print-area" class="max-w-4xl mx-auto px-4 pb-16">
        <div class="relative rounded-xl border border-gray-200 bg-white shadow-sm p-8 space-y-8 overflow-hidden">

            {{-- Watermark using component (ensure this file exists: resources/views/components/app-logo.blade.php) --}}
            <div class="ticket-watermark">
                <div class="flex flex-col items-center justify-center opacity-10">
                    <x-app-logo-icon class="wm-icon w-[420px] h-[420px] text-blue-600/80" />
                </div>
            </div>

            {{-- Content wrapper must be above watermark --}}
            <div class="relative z-10 space-y-8">
                <div class="flex flex-col md:flex-row md:items-center md:justify-between gap-4">
                    <div>
                        <p class="text-xs font-medium tracking-wide text-gray-500 uppercase">Reference</p>
                        <p class="text-xl font-semibold text-gray-900">{{ $eticket }}</p>
                    </div>
                    <div class="text-xs text-gray-500">
                        Issued: {{ now()->format('M d, Y H:i') }}
                    </div>
                </div>

                <div class="grid md:grid-cols-2 gap-8">
                    <div class="space-y-4">
                        <h2 class="text-sm font-semibold tracking-wide text-gray-900 uppercase">Booking</h2>
                        <dl class="text-sm space-y-1.5">
                            <div class="flex justify-between">
                                <dt class="text-gray-500">Package</dt>
                                <dd class="font-medium text-gray-800">
                                    {{ $booking->schedule->touristPackage?->package_name ?? '—' }}
                                </dd>
                            </div>
                            <div class="flex justify-between">
                                <dt class="text-gray-500">Destination</dt>
                                <dd class="font-medium text-gray-800">
                                    {{ $booking->schedule->touristPackage?->destination?->destination_name ?? '—' }}
                                </dd>
                            </div>
                            <div class="flex justify-between">
                                <dt class="text-gray-500">Dates</dt>
                                <dd class="font-medium text-gray-800">
                                    {{ \Illuminate\Support\Carbon::parse($booking->schedule->from_date)->format('M d, Y') }}
                                    –
                                    {{ \Illuminate\Support\Carbon::parse($booking->schedule->to_date)->format('M d, Y') }}
                                </dd>
                            </div>
                            <div class="flex justify-between">
                                <dt class="text-gray-500">Payment Method</dt>
                                <dd class="font-medium text-gray-800">
                                    {{ $booking->payment_status }}
                                </dd>
                            </div>
                        </dl>
                    </div>

                    <div class="space-y-4">
                        <h2 class="text-sm font-semibold tracking-wide text-gray-900 uppercase">Traveler</h2>
                        <dl class="text-sm space-y-1.5">
                            <div class="flex justify-between">
                                <dt class="text-gray-500">Name</dt>
                                <dd class="font-medium text-gray-800">{{ $displayName }}</dd>
                            </div>
                            <div class="flex justify-between">
                                <dt class="text-gray-500">Phone</dt>
                                <dd class="font-medium text-gray-800">{{ $booking->phone ?? '—' }}</dd>
                            </div>
                            <div class="flex justify-between">
                                <dt class="text-gray-500">Nationality</dt>
                                <dd class="font-medium text-gray-800">{{ $booking->nationality ?? '—' }}</dd>
                            </div>
                            <div class="flex justify-between">
                                <dt class="text-gray-500">Address</dt>
                                <dd class="font-medium text-gray-800">{{ $booking->address ?? '—' }}</dd>
                            </div>
                        </dl>
                    </div>
                </div>

                <div class="space-y-4">
                    <h2 class="text-sm font-semibold tracking-wide text-gray-900 uppercase">Accommodation</h2>
                    @php($rc = $booking->roomChoices->first())
                    @if($rc)
                        <div
                            class="rounded-md border border-gray-200 bg-gray-50 p-4 text-sm flex flex-col sm:flex-row sm:items-center sm:justify-between gap-3">
                            <div class="space-y-1">
                                <p class="font-medium text-gray-900">
                                    {{ $rc->accommodation->hotel->name ?? 'Hotel' }}
                                </p>
                                <p class="text-xs text-gray-600">
                                    Room: {{ $rc->accommodation->room?->room_type ?? '—' }} · Ref
                                    #{{ $rc->accommodation->accom_id }}
                                </p>
                            </div>
                            <div class="text-xs text-gray-500">
                                Contact: {{ $rc->accommodation->hotel->contact_no ?? '—' }}
                            </div>
                        </div>
                    @else
                        <p class="text-xs text-gray-500">No accommodation recorded.</p>
                    @endif
                </div>

                <div class="space-y-4">
                    <h2 class="text-sm font-semibold tracking-wide text-gray-900 uppercase">Pricing</h2>
                    <div class="rounded-md border border-gray-200 bg-gray-50 p-4 text-sm space-y-2">
                        <div class="flex justify-between">
                            <span class="text-gray-600">Package Price</span>
                            <span class="font-medium text-gray-900">${{ number_format($packagePrice, 2) }}</span>
                        </div>
                        <div class="flex justify-between">
                            <span class="text-gray-600">Room Price</span>
                            <span class="font-medium text-gray-900">${{ number_format($roomPrice, 2) }}</span>
                        </div>
                        <hr class="border-gray-200">
                        <div class="flex justify-between">
                            <span class="text-gray-700 font-semibold">Total</span>
                            <span class="text-blue-600 font-semibold">${{ number_format($totalPrice, 2) }}</span>
                        </div>
                    </div>
                </div>

                @if($booking->special_request)
                    <div class="space-y-2">
                        <h2 class="text-sm font-semibold tracking-wide text-gray-900 uppercase">Special Request</h2>
                        <p class="text-sm text-gray-600 whitespace-pre-line">
                            {{ $booking->special_request }}
                        </p>
                    </div>
                @endif

                <div class="pt-6 border-t border-gray-200">
                    <p class="text-xs text-gray-500">
                        Present this e‑ticket (Ref {{ $eticket }}) at check‑in. Keep a copy for your records.
                    </p>
                </div>
            </div>
        </div>
</x-layouts.guest>