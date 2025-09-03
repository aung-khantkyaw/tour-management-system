<?php

use App\Http\Controllers\BookingController;
use App\Http\Controllers\DestinationController;
use App\Http\Controllers\PackagesController;
use App\Http\Controllers\ScheduleController;
use App\Models\Destination;
use Illuminate\Support\Facades\Route;
use Livewire\Volt\Volt;

Route::get('/', function () {
    $latestDestinations = Destination::withCount(['hotels', 'touristPackages'])
        ->when(
            Schema::hasColumn('destinations', 'created_at'),
            fn($q) => $q->latest(),
            fn($q) => $q->orderByDesc('destination_id')
        )
        ->limit(3)
        ->get();

    return view('welcome', compact('latestDestinations'));
})->name('welcome');

Route::get('/about', function () {
    return view('livewire.guest.about');
})->name('about');

Route::get('/destinations', [DestinationController::class, 'index'])->name('destinations');

Route::get('/destination/{destination}/packages', [DestinationController::class, 'packages'])
    ->whereNumber('destination')
    ->name('destination.packages');

Route::get('/packages', [PackagesController::class, 'index'])->name('packages');

// Route::get('/schedule/{packageId?}', [ScheduleController::class, 'index'])
//     ->where('packageId', '[0-9]+')
//     ->name('schedule');

Route::get('/schedules', [ScheduleController::class, 'index'])->name('schedules');

Route::get('/package/{package}/schedule', [ScheduleController::class, 'package'])
    ->whereNumber('package')
    ->name('package.schedule');

Route::get('/schedule/{schedule}/book', [BookingController::class, 'create'])
    ->middleware('auth')
    ->whereNumber('schedule')
    ->name('schedule.book');

Route::get('/history', function () {
    return view('livewire.guest.history');
})->middleware('auth')->name('history');

Route::post('/bookings', [BookingController::class, 'store'])->middleware('auth')->name('bookings.store');

Route::get('/booking/{booking}/ticket', [BookingController::class, 'ticket'])
    ->middleware('auth')
    ->whereNumber('booking')
    ->name('booking.ticket');

Route::view('dashboard', 'dashboard')
    ->middleware(['auth', 'verified'])
    ->name('dashboard');

Route::middleware(['auth'])->group(function () {
    Route::redirect('settings', 'settings/profile');

    Volt::route('settings/profile', 'settings.profile')->name('settings.profile');
    Volt::route('settings/password', 'settings.password')->name('settings.password');
    Volt::route('settings/appearance', 'settings.appearance')->name('settings.appearance');
});

require __DIR__ . '/auth.php';
