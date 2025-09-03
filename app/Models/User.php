<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Support\Str;

class User extends Authenticatable
{
    /** @use HasFactory<\Database\Factories\UserFactory> */
    use HasFactory, Notifiable;

    protected $primaryKey = 'user_id';

    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = [
        'name',
        'email',
        'password',
        'role',
    ];

    public function bookings()
    {
        return $this->hasMany(Booking::class);
    }

    public function guide()
    {
        return $this->hasOne(Guide::class);
    }

    public function login($username, $password)
    {
        return auth()->attempt(['email' => $username, 'password' => $password]);
    }

    public function logout()
    {
        auth()->logout();
    }

    public function searchPackage($criteria)
    {
        return TouristPackage::where('destination_id', $criteria)->get();
    }

    public function bookPackage($packageID)
    {
        return Booking::create(['user_id' => $this->id, 'schedule_id' => $packageID]);
    }

    public function viewBookingHistory()
    {
        return $this->bookings()->get();
    }

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var list<string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
        ];
    }

    /**
     * Get the user's initials
     */
    public function initials(): string
    {
        return Str::of($this->name)
            ->explode(' ')
            ->take(2)
            ->map(fn ($word) => Str::substr($word, 0, 1))
            ->implode('');
    }
}
