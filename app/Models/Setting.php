<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Setting extends Model
{
    protected $fillable = ['site_name', 'icon_image', 'logo_image',
        'facebook_link', 'instagram_link', 'whatsapp_number',
        'image_1', 'image_2', 'image_3',
        'text_1', 'text_2', 'text_3'];
}
