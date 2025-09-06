<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PaymentQR extends Model
{
    protected $table = 'payment_q_r_s';
    protected $primaryKey = 'qr_id';
    protected $fillable = [
        'qr_image_path',
        'qr_type',
        'description',
        'amount',
    ];

    protected $appends = ['url'];

    public function getUrlAttribute(): string
    {
        if (!$this->qr_image_path) {
            return '';
        }
        if (str_starts_with($this->qr_image_path, 'http://') || str_starts_with($this->qr_image_path, 'https://')) {
            return $this->qr_image_path;
        }
        return asset($this->qr_image_path);
    }

    public function scopeForProvider($query, string $provider)
    {
        return $query->where('qr_type', strtolower($provider));
    }

    public function scopeForProviderAmount($query, string $provider, $amount)
    {
        return $query->where('qr_type', strtolower($provider))
            ->where(function ($q) use ($amount) {
                $q->where('amount', (int) $amount)
                    ->orWhere('amount', 0);
            })
            ->orderByDesc('amount');
    }
}
