<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PromoCode extends Model
{
    const UPDATED_AT = null;

    protected $fillable = [
        'code',
        'discount_pct',
        'quota',
        'expiry_date'
    ];
    public function appointment()
    {
        return $this->hasMany(Appointment::class, 'coupon_code');
    }
    public function user()
    {
        return $this->belongsTo(User::class);
    }
    public function savedDoctor()
    {
        return $this->belongsTo(SavedDoctor::class);
    }
}
