<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class RoomChoice extends Model
{
    protected $primaryKey = 'rchoice_id';
    protected $fillable = ['booking_id', 'accom_id'];

    public function booking()
    {
        return $this->belongsTo(Booking::class, 'booking_id', 'booking_id');
    }

    public function accommodation()
    {
        return $this->belongsTo(Accommodation::class, 'accom_id', 'accom_id');
    }

    public function selectRoom()
    {
        return $this->save();
    }
}