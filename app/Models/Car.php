<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Car extends Model
{
    protected $fillable = [
        'user_id', 'brand' , 'model', 'year', 'price',
        'sold', 'price', 'sold', 'color', 'country', 'city', 'images'
    ];
    protected $casts = [
        'images' => 'array',
    ];

}
