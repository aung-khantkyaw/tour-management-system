<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Hotel extends Model
{
    protected $primaryKey = 'hotel_id';
    protected $fillable = ['destination_id', 'name', 'contact_no', 'rating'];

    public function destination()
    {
        return $this->belongsTo(Destination::class, 'destination_id', 'destination_id');
    }

    public function accommodations()
    {
        return $this->hasMany(Accommodation::class, 'hotel_id', 'hotel_id');
    }

    public function addHotel()
    {
        return $this->save();
    }

    public function updateHotel()
    {
        return $this->save();
    }
}