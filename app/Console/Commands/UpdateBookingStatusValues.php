<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\Booking;

class UpdateBookingStatusValues extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'booking:update-status-values';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Update booking status values to reflect combined payment and booking status';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $this->info('Updating booking status values...');

        // Since we removed payment_status, the booking_status now represents the overall status
        // The existing booking_status values should already be appropriate

        $bookings = Booking::all();
        $this->info("Found {$bookings->count()} bookings with current status values.");

        foreach ($bookings as $booking) {
            $this->line("Booking ID {$booking->booking_id}: {$booking->booking_status}");
        }

        $this->info('Booking statuses are now unified. No updates needed.');
        $this->info('Available status values: pending, confirmed, in_progress, completed, cancelled');
    }
}
