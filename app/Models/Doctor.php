<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Doctor extends Model
{
    protected $fillable = [
        'name',
        'specialty',
        'description',
        'location',
        'price',
        'duration'
    ];
    public function appointment()
    {
        return $this->hasMany(Appointment::class, 'doctor_id');
    }
    public function expertise()
    {
        return $this->hasMany(Expertise::class, 'doctor_id');
    }
}
