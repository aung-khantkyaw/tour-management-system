<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Schedule extends Model
{
    protected $primaryKey = 'schedule_id';
    protected $fillable = ['package_id', 'from_date', 'to_date', 'departure_time', 'arrival_time', 'available_places'];

    public function touristPackage()
    {
        return $this->belongsTo(TouristPackage::class, 'package_id', 'package_id');
    }

    public function bookings()
    {
        return $this->hasMany(Booking::class, 'schedule_id', 'schedule_id');
    }

    public function getSchedule()
    {
        return $this->toArray();
    }

    /**
     * Check if schedule has available places for booking
     */
    public function hasAvailablePlaces($requestedPlaces = 1)
    {
        return $this->available_places >= $requestedPlaces;
    }

    /**
     * Reduce available places when booking is made
     */
    public function reduceAvailablePlaces($places)
    {
        $this->decrement('available_places', $places);
    }

    /**
     * Increase available places when booking is cancelled
     */
    public function increaseAvailablePlaces($places)
    {
        $this->increment('available_places', $places);
    }

    /**
     * Initialize available places from package capacity
     */
    public function initializeAvailablePlaces()
    {
        $this->available_places = $this->touristPackage->no_of_people ?? 0;
        $this->save();
    }
}