<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Room extends Model
{
    protected $primaryKey = 'room_id';
    protected $fillable = ['room_type'];

    public function accommodations()
    {
        return $this->hasMany(Accommodation::class, 'room_id', 'room_id');
    }

    public function addRoom()
    {
        return $this->save();
    }

    public function updateRoom()
    {
        return $this->save();
    }
}