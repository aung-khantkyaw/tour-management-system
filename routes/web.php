<?php

use App\Http\Controllers\BookingController;
use App\Http\Controllers\DashboardController;
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

    $heroImages = [
        asset('storage/destinations/1.jpg'),
        asset('storage/destinations/2.jpg'),
        asset('storage/destinations/3.jpg')
    ];

    return view('welcome', compact('latestDestinations', 'heroImages'));
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

Route::get('/history', [\App\Http\Controllers\HistoryController::class, 'index'])->middleware('auth')->name('history');

// Tour Management Routes with Admin Prefix
Route::prefix('admin')->name('admin.')->middleware(['auth', \App\Http\Middleware\IsAdmin::class])->group(function () {
    // Dashboard
    Route::get('/dashboard', DashboardController::class)->name('dashboard')->middleware(\App\Http\Middleware\IsAdmin::class);

    // Hotels Management (page-based CRUD)
    Route::get('/hotels', [\App\Http\Controllers\Admin\HotelController::class, 'index'])->name('hotels.index');
    Route::get('/hotels/add', [\App\Http\Controllers\Admin\HotelController::class, 'create'])->name('hotels.create');
    Route::post('/hotels', [\App\Http\Controllers\Admin\HotelController::class, 'store'])->name('hotels.store');
    Route::get('/hotels/{hotel}/edit', [\App\Http\Controllers\Admin\HotelController::class, 'edit'])->name('hotels.edit');
    Route::put('/hotels/{hotel}', [\App\Http\Controllers\Admin\HotelController::class, 'update'])->name('hotels.update');
    Route::get('/hotels/{hotel}/delete', [\App\Http\Controllers\Admin\HotelController::class, 'delete'])->name('hotels.delete');
    Route::delete('/hotels/{hotel}', [\App\Http\Controllers\Admin\HotelController::class, 'destroy'])->name('hotels.destroy');

    // Accommodations Management (page-based CRUD)
    Route::get('/accommodations', [\App\Http\Controllers\Admin\AccommodationController::class, 'index'])->name('accommodations.index');
    Route::get('/accommodations/add', [\App\Http\Controllers\Admin\AccommodationController::class, 'create'])->name('accommodations.create');
    Route::post('/accommodations', [\App\Http\Controllers\Admin\AccommodationController::class, 'store'])->name('accommodations.store');
    Route::get('/accommodations/{accommodation}/edit', [\App\Http\Controllers\Admin\AccommodationController::class, 'edit'])->name('accommodations.edit');
    Route::put('/accommodations/{accommodation}', [\App\Http\Controllers\Admin\AccommodationController::class, 'update'])->name('accommodations.update');
    Route::get('/accommodations/{accommodation}/delete', [\App\Http\Controllers\Admin\AccommodationController::class, 'delete'])->name('accommodations.delete');
    Route::delete('/accommodations/{accommodation}', [\App\Http\Controllers\Admin\AccommodationController::class, 'destroy'])->name('accommodations.destroy');

    // Guides Management (page-based CRUD)
    Route::get('/guides', [\App\Http\Controllers\Admin\GuideController::class, 'index'])->name('guides.index');
    Route::get('/guides/add', [\App\Http\Controllers\Admin\GuideController::class, 'create'])->name('guides.create');
    Route::post('/guides', [\App\Http\Controllers\Admin\GuideController::class, 'store'])->name('guides.store');
    Route::get('/guides/{guide}/edit', [\App\Http\Controllers\Admin\GuideController::class, 'edit'])->name('guides.edit');
    Route::put('/guides/{guide}', [\App\Http\Controllers\Admin\GuideController::class, 'update'])->name('guides.update');
    Route::get('/guides/{guide}/delete', [\App\Http\Controllers\Admin\GuideController::class, 'delete'])->name('guides.delete');
    Route::delete('/guides/{guide}', [\App\Http\Controllers\Admin\GuideController::class, 'destroy'])->name('guides.destroy');

    // Destinations Management (page-based CRUD)
    Route::get('/destinations', [\App\Http\Controllers\Admin\DestinationController::class, 'index'])->name('destinations.index');
    Route::get('/destinations/add', [\App\Http\Controllers\Admin\DestinationController::class, 'create'])->name('destinations.create');
    Route::post('/destinations', [\App\Http\Controllers\Admin\DestinationController::class, 'store'])->name('destinations.store');
    Route::get('/destinations/{destination}/edit', [\App\Http\Controllers\Admin\DestinationController::class, 'edit'])->name('destinations.edit');
    Route::put('/destinations/{destination}', [\App\Http\Controllers\Admin\DestinationController::class, 'update'])->name('destinations.update');
    Route::get('/destinations/{destination}/delete', [\App\Http\Controllers\Admin\DestinationController::class, 'confirmDelete'])->name('destinations.delete');
    Route::delete('/destinations/{destination}', [\App\Http\Controllers\Admin\DestinationController::class, 'destroy'])->name('destinations.destroy');

    // Packages Management (page-based CRUD)
    Route::get('/packages', [\App\Http\Controllers\Admin\PackageController::class, 'index'])->name('packages.index');
    Route::get('/packages/add', [\App\Http\Controllers\Admin\PackageController::class, 'create'])->name('packages.create');
    Route::post('/packages', [\App\Http\Controllers\Admin\PackageController::class, 'store'])->name('packages.store');
    Route::get('/packages/{package}/edit', [\App\Http\Controllers\Admin\PackageController::class, 'edit'])->name('packages.edit');
    Route::put('/packages/{package}', [\App\Http\Controllers\Admin\PackageController::class, 'update'])->name('packages.update');
    Route::get('/packages/{package}/delete', [\App\Http\Controllers\Admin\PackageController::class, 'delete'])->name('packages.delete');
    Route::delete('/packages/{package}', [\App\Http\Controllers\Admin\PackageController::class, 'destroy'])->name('packages.destroy');

    // Schedules Management (page-based CRUD)
    Route::get('/schedules', [\App\Http\Controllers\Admin\ScheduleController::class, 'index'])->name('schedules.index');
    Route::get('/schedules/add', [\App\Http\Controllers\Admin\ScheduleController::class, 'create'])->name('schedules.create');
    Route::post('/schedules', [\App\Http\Controllers\Admin\ScheduleController::class, 'store'])->name('schedules.store');
    Route::get('/schedules/{schedule}/edit', [\App\Http\Controllers\Admin\ScheduleController::class, 'edit'])->name('schedules.edit');
    Route::put('/schedules/{schedule}', [\App\Http\Controllers\Admin\ScheduleController::class, 'update'])->name('schedules.update');
    Route::get('/schedules/{schedule}/delete', [\App\Http\Controllers\Admin\ScheduleController::class, 'delete'])->name('schedules.delete');
    Route::delete('/schedules/{schedule}', [\App\Http\Controllers\Admin\ScheduleController::class, 'destroy'])->name('schedules.destroy');

    // Bookings Management (page-based CRUD)
    Route::get('/bookings', [\App\Http\Controllers\Admin\BookingController::class, 'index'])->name('bookings.index');
    Route::get('/bookings/{booking}', [\App\Http\Controllers\Admin\BookingController::class, 'show'])->name('bookings.show');
    Route::put('/bookings/{booking}/status', [\App\Http\Controllers\Admin\BookingController::class, 'updateStatus'])->name('bookings.updateStatus');
    Route::get('/bookings/{booking}/delete', [\App\Http\Controllers\Admin\BookingController::class, 'delete'])->name('bookings.delete');
    Route::delete('/bookings/{booking}', [\App\Http\Controllers\Admin\BookingController::class, 'destroy'])->name('bookings.destroy');
});

// Public Tour Management Routes (for guests and users)
Route::get('/hotels', function () {
    $hotels = \App\Models\Hotel::withCount(['rooms'])->paginate(12);
    return view('hotels.index', compact('hotels'));
})->name('hotels');

Route::get('/accommodations', function () {
    $accommodations = \App\Models\Accommodation::with(['touristPackage', 'hotel'])->paginate(12);
    return view('accommodations.index', compact('accommodations'));
})->name('accommodations');

Route::get('/guides', function () {
    $guides = \App\Models\Guide::withCount(['touristPackages'])->paginate(12);
    return view('guides.index', compact('guides'));
})->name('guides');

Route::post('/bookings', [BookingController::class, 'store'])->middleware('auth')->name('bookings.store');

Route::get('/booking/{booking}/ticket', [BookingController::class, 'ticket'])
    ->middleware('auth')
    ->whereNumber('booking')
    ->name('booking.ticket');

// Admin Dashboard Route
Route::get('/admin/dashboard', DashboardController::class)
    ->middleware(['auth'])
    ->name('admin.dashboard');

// Redirect old dashboard route to admin dashboard
Route::get('/dashboard', function () {
    return redirect()->route('admin.dashboard');
})->middleware(['auth'])->name('dashboard');

// Route::middleware(['auth'])->group(function () {
//     Route::redirect('settings', 'settings/profile');

//     Volt::route('settings/profile', 'settings.profile')->name('settings.profile');
//     Volt::route('settings/password', 'settings.password')->name('settings.password');
//     Volt::route('settings/appearance', 'settings.appearance')->name('settings.appearance');
// });

require __DIR__ . '/auth.php';
