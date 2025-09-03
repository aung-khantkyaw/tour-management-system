<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Destination extends Model
{
    protected $primaryKey = 'destination_id';
    protected $fillable = ['destination_name', 'city', 'description'];

    public function hotels()
    {
        return $this->hasMany(Hotel::class, 'destination_id', 'destination_id');
    }

    public function touristPackages()
    {
        return $this->hasMany(TouristPackage::class, 'destination_id', 'destination_id');
    }

    public function getDetails()
    {
        return $this->toArray();
    }
}