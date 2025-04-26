<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

use App\Models\User;

class UserDetails extends Model
{
    protected $fillable = [
        'user_id',
        'address',
        'phone_number',
        'date_of_birth',
        'gender',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
