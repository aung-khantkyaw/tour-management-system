<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Schedule extends Model
{
    protected $primaryKey = 'schedule_id';
    protected $fillable = ['package_id', 'from_date', 'to_date', 'departure_time', 'arrival_time'];

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
}