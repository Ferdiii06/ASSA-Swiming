<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Payment extends Model
{
    use HasFactory;

    protected $fillable = [
        'enrollment_id',
        'student_id',
        'package_id',
        'amount',
        'payment_type',
        'payment_method',
        'qris_token',
        'transaction_id',
        'proof_image',
        'status',
        'paid_at',
        'payment_period',
        'notes'
    ];

    protected $casts = [
        'amount' => 'decimal:2',
        'paid_at' => 'datetime',
        'payment_period' => 'date'
    ];

    // Relasi ke Enrollment
    public function enrollment()
    {
        return $this->belongsTo(Enrollment::class);
    }

    // Relasi ke Student (through enrollment)
    public function student()
    {
        return $this->hasOneThrough(Student::class, Enrollment::class);
    }

    // Scope: pembayaran sukses
    public function scopeSuccess($query)
    {
        return $query->where('status', 'success');
    }

    // Scope: pending
    public function scopePending($query)
    {
        return $query->where('status', 'pending');
    }

    // Cek status
    public function isPaid()
    {
        return $this->status === 'success';
    }

    // Relasi ke Package
    public function package()
    {
        return $this->belongsTo(Package::class);
    }
}
