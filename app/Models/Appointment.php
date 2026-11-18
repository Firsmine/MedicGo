<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Appointment extends Model
{
    protected $fillable = [
        'patient_id',
        'doctor_id',
        'coupon_code',
        'payment_method',
        'status'
    ];

    public function user()
    {
        return $this->belongsTo(User::class, 'patient_id');
    }
    public function doctor()
    {
        return $this->belongsTo(Doctor::class, 'doctor_id');
    }
    public function savedDoctor()
    {
        return $this->belongsTo(SavedDoctor::class, 'doctor_id');
    }
    public function promoCode()
    {
        return $this->belongsTo(PromoCode::class, 'coupon_code');
    }
}
