<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\User;
use App\Models\Branch;

class Appointment extends Model
{

    protected $fillable = [
        'user_id',
        'appointment_date',
        'appointment_time',
        'type',
        'branch_id',
    ];
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function branch()
    {
        return $this->belongsTo(Branch::class);
    }
}
