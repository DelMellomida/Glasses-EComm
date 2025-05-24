<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Branch extends Model
{
    protected $table = 'branch';
    protected $fillable = [
        'branch_name',
        'branch_address',
        'branch_phone',
    ];

}
