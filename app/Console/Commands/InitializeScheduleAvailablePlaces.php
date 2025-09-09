<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\Schedule;

class InitializeScheduleAvailablePlaces extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'schedule:init-available-places';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Initialize available_places for existing schedules based on their package capacity';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $this->info('Initializing available places for existing schedules...');

        $schedules = Schedule::with('touristPackage')->where('available_places', 0)->get();

        if ($schedules->isEmpty()) {
            $this->info('No schedules need initialization.');
            return;
        }

        $this->info("Found {$schedules->count()} schedules to initialize.");

        $updated = 0;

        foreach ($schedules as $schedule) {
            if ($schedule->touristPackage) {
                $capacity = $schedule->touristPackage->no_of_people ?? 0;
                $schedule->update(['available_places' => $capacity]);
                $updated++;
                $this->line("Schedule ID {$schedule->schedule_id}: Set available places to {$capacity}");
            } else {
                $this->warn("Schedule ID {$schedule->schedule_id}: No associated package found");
            }
        }

        $this->info("Successfully updated {$updated} schedules.");
    }
}
