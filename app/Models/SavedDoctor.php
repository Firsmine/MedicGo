<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class SavedDoctor extends Model
{
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
}
