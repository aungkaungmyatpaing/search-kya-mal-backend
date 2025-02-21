<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Weekend extends Model
{
    use HasFactory;

    protected $fillable = [
        'hour',
        'price'
    ];

    public function fields()
    {
        return $this->hasMany(Field::class);
    }
}
