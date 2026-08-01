<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Student extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'name',
        'birth_date',
        'gender',
        'phone',
        'address',
        'join_date',
        'is_active'
    ];

    protected $casts = [
        'birth_date' => 'date',
        'join_date' => 'date',
        'is_active' => 'boolean'
    ];

    // Relasi ke User (orang tua)
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    // Relasi ke Enrollment
    public function enrollments()
    {
        return $this->hasMany(Enrollment::class);
    }

    // Relasi ke Progress Report
    public function progressReports()
    {
        return $this->hasMany(ProgressReport::class);
    }

    // Relasi ke Payment
    public function payments()
    {
        return $this->hasMany(Payment::class);
    }

    // Scope untuk murid aktif
    public function scopeActive($query)
    {
        return $query->where('is_active', true);
    }
}
