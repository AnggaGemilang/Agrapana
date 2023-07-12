<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MainDevice extends Model
{
    use HasFactory;

    protected $fillable = [
        'wind_temperature',
        'wind_humidity',
        'wind_pressure',
        'wind_speed',
        'rainfall',
        'user_id',
        'meta_data'
    ];

}
