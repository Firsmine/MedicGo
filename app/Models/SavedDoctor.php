<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class SavedDoctor extends Model
{
    const UPDATED_AT = null;
    protected $fillable = [
        'patient_id',
        'doctor_id'
    ];
    public function appointment()
    {
        return $this->hasMany(Appointment::class, 'doctor_id');
    }
    public function promoCode()
    {
        return $this->hasMany(PromoCode::class);
    }
    public function doctor()
    {
        return $this->belongsTo(Doctor::class, 'doctor_id');
    }

    public function user()
    {
        return $this->belongsTo(User::class, 'patient_id');
    }
}
