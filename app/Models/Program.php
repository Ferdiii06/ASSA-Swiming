<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Program extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'description',
        'price_per_session',
        'price_monthly',
        'duration_months',
        'is_active'
    ];

    protected $casts = [
        'price_per_session' => 'decimal:2',
        'price_monthly' => 'decimal:2',
        'is_active' => 'boolean'
    ];

    // Relasi ke Enrollment
    public function enrollments()
    {
        return $this->hasMany(Enrollment::class);
    }

    // Relasi ke Schedule
    public function schedules()
    {
        return $this->hasMany(Schedule::class);
    }

    // Scope aktif
    public function scopeActive($query)
    {
        return $query->where('is_active', true);
    }
}
