<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ProgressReport extends Model
{
    use HasFactory;

    protected $fillable = [
        'student_id',
        'enrollment_id',
        'coach_id',
        'level',
        'skills_achieved',
        'instructor_notes',
        'attendance',
        'total_sessions',
        'status',
        'report_date'
    ];

    protected $casts = [
        'report_date' => 'date'
    ];

    // Relasi ke Student
    public function student()
    {
        return $this->belongsTo(Student::class);
    }

    // Relasi ke Enrollment
    public function enrollment()
    {
        return $this->belongsTo(Enrollment::class);
    }

    // Relasi ke Coach
    public function coach()
    {
        return $this->belongsTo(Coach::class);
    }

    // Cek kelulusan
    public function isPassed()
    {
        return $this->status === 'passed';
    }

    // Hitung progress (persentase)
    public function getProgressPercentageAttribute()
    {
        if ($this->total_sessions == 0) return 0;
        return round(($this->attendance / $this->total_sessions) * 100);
    }
}
