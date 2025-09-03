<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Accommodation extends Model
{
    protected $primaryKey = 'accom_id';
    protected $fillable = ['hotel_id', 'room_id', 'price'];

    public function hotel()
    {
        return $this->belongsTo(Hotel::class, 'hotel_id', 'hotel_id');
    }

    public function room()
    {
        return $this->belongsTo(Room::class, 'room_id', 'room_id');
    }

    public function roomChoices()
    {
        return $this->hasMany(RoomChoice::class, 'accom_id', 'accom_id');
    }

    public function getAccommodationDetails()
    {
        return $this->load(['hotel', 'room']);
    }
}