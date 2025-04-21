<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Ad extends Model
{
    protected $fillable = ['full_name', 'image', 'ad_url', 'hit', 'start_date', 'end_date', 'location'];
}
