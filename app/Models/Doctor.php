<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Doctor extends Model
{
    protected $hidden = [
        'created_at',
        'updated_at'
    ];
    const UPDATED_AT = null;

    protected $fillable = [
        'name',
        'specialty',
        'description',
        'experience',
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
