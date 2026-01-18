<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Transaction extends Model
{
    use HasFactory;

    /**
     * =========================
     * MASS ASSIGNMENT
     * =========================
     */
    protected $fillable = [
        'patient_id',
        'layanan',
        'nominal',
        'tanggal',
        'created_by',
    ];

    /**
     * =========================
     * RELATIONS
     * =========================
     */

    // Relasi ke pasien (opsional)
    public function patient()
    {
        return $this->belongsTo(Patient::class);
    }

    // Relasi ke user pencatat
    public function creator()
    {
        return $this->belongsTo(User::class, 'created_by');
    }
}
