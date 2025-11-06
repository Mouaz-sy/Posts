<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Profile extends Model
{
    protected $fillable = [
        //'user_id',
        'phone',
        'date_of_birth',
        'image',
        'address',
        'bio',
    ];
}
