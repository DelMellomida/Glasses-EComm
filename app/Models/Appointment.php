<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\User;

class Appointment extends Model
{

    protected $fillable = [
        'user_id',
        'appointment_date',
        'appointment_time',
        'type',
    ];
    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
