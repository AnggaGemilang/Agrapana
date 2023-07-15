<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SupportDevice extends Model
{
    use HasFactory;

    protected $fillable = [
        'number_of',
        'soil_temperature',
        'soil_humidity',
        'soil_ph',
        'soil_nitrogen',
        'soil_phosphor',
        'soil_kalium',
        'main_device_id',
        'meta_data'
    ];

}
