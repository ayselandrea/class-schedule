<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Schedule extends Model
{
    use HasFactory;

    protected $fillable = [
        'subject',
        'professor',
        'section',
        'year_level',
        'day',
        'time_start',
        'time_end',
        'room',
    ];
}
