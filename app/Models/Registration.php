<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Registration extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'nickname',
        'age',
        'phone',
        'parent_name',
        'address',
        'program',
        'nominal',
        'location',
        'schedule_day',
        'schedule_time',
        'source',
        'status',
    ];
}
