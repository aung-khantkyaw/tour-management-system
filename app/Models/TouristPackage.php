<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class TouristPackage extends Model
{
    protected $primaryKey = 'package_id';
    protected $fillable = ['package_name', 'guide_id', 'destination_id', 'duration_days', 'no_of_people', 'vehicle_type', 'singlepackage_fee', 'fullpackage_fee'];

    public function guide()
    {
        return $this->belongsTo(Guide::class, 'guide_id', 'guide_id');
    }

    public function destination()
    {
        return $this->belongsTo(Destination::class, 'destination_id', 'destination_id');
    }

    public function schedules()
    {
        return $this->hasMany(Schedule::class, 'package_id', 'package_id');
    }

    public function getDetails()
    {
        return $this->toArray();
    }

    public function calculatePrice()
    {
        return $this->no_of_people > 1 ? $this->fullpackage_fee : $this->singlepackage_fee;
    }
}