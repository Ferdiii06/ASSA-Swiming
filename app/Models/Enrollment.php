<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Enrollment extends Model
{
    use HasFactory;

    protected $fillable = [
        'student_id',
        'program_id',
        'coach_id',
        'schedule_id',
        'start_date',
        'end_date',
        'current_level',
        'status'
    ];

    protected $casts = [
        'start_date' => 'date',
        'end_date' => 'date',
    ];

    // Relasi ke Student
    public function student()
    {
        return $this->belongsTo(Student::class);
    }

    // Relasi ke Program
    public function program()
    {
        return $this->belongsTo(Program::class);
    }

    // Relasi ke Coach
    public function coach()
    {
        return $this->belongsTo(Coach::class);
    }

    // Relasi ke Schedule
    public function schedule()
    {
        return $this->belongsTo(Schedule::class);
    }

    // Relasi ke Payment
    public function payments()
    {
        return $this->hasMany(Payment::class);
    }

    // Relasi ke Progress Report
    public function progressReports()
    {
        return $this->hasMany(ProgressReport::class);
    }

    // Scope aktif
    public function scopeActive($query)
    {
        return $query->where('status', 'active');
    }

    // Cek apakah masih aktif
    public function isActive()
    {
        return $this->status === 'active';
    }
}
