<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Expertise extends Model
{
    protected $timestamp = false;
    const CREATED_AT = null;
    const UPDATED_AT = null;

    protected $table = 'expertise';
    protected $fillable = [
        'doctor_id',
        'title'
    ];
    public function doctor()
    {
        return $this->belongsTo(Doctor::class, 'doctor_id');
    }
}
