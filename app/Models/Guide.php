<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Guide extends Model
{
    protected $primaryKey = 'guide_id';
    protected $fillable = ['user_id', 'phone', 'language'];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function touristPackages()
    {
        return $this->hasMany(TouristPackage::class, 'guide_id', 'guide_id');
    }

    public function assignToPackage($packageID)
    {
        return TouristPackage::where('package_id', $packageID)->update(['guide_id' => $this->guide_id]);
    }

    public function updateDetails()
    {
        return $this->save();
    }
}