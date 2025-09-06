<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Booking extends Model
{
    protected $primaryKey = 'booking_id';
    protected $fillable = [
        'user_id',
        'schedule_id',
        'booking_date',
        'payment_method',
        'payment_status',
        'special_request',
        'address',
        'phone',
        'nationality',
        'booking_status',
        'payment_transaction_id',
        'total_amount'
    ];

    public function user()
    {
        return $this->belongsTo(\App\Models\User::class, 'user_id');
    }

    public function schedule()
    {
        return $this->belongsTo(\App\Models\Schedule::class, 'schedule_id');
    }

    public function roomChoices()
    {
        return $this->hasMany(\App\Models\RoomChoice::class, 'booking_id');
    }

    public function confirmBooking()
    {
        $this->payment_status = 'confirmed';
        return $this->save();
    }

    public function cancelBooking()
    {
        $this->payment_status = 'cancelled';
        return $this->save();
    }

    public function getBookingDetails()
    {
        return $this->load(['user', 'schedule.touristPackage', 'roomChoices']);
    }
}