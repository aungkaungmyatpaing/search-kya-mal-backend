<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Contact extends Model
{
    use HasFactory;

    protected $fillable = [
        'phone_1',
        'phone_2',
        'email',
        'address',
        'facebook_link',
        'messenger_link',
        'viber_link'
    ];
}
