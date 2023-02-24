<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Region extends Model
{
    use HasFactory;

    public static function allRegions()
    {
        return [
            'North America',
            'Europe',
            'Africa',
            'Australia',
            'Asia',
            'Oceania',
            'South America',
            'Other',
        ];
    }
}
