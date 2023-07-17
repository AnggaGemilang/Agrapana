<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Ramsey\Uuid\Uuid as RamseyUuid;

class MonitoringMainDevice extends Model
{
    use HasFactory;

    protected $fillable = [
        'number_of_support_devices',
        'wind_temperature',
        'wind_humidity',
        'wind_pressure',
        'wind_speed',
        'rainfall',
        'light_intensity',
        'field_id',
        'meta_data'
    ];

    public static function boot()
    {
        parent::boot();
        static::creating(function($obj) {
            $obj->id = RamseyUuid::uuid4()->toString();
        });
    }

}
