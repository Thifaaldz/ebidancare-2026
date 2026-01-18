<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class MedicalRecord extends Model
{
    use HasFactory;

    /**
     * =========================
     * MASS ASSIGNMENT
     * =========================
     */
    protected $fillable = [
        'patient_id',
        'type',
        'tanggal_pemeriksaan',
        'catatan',
        'created_by',
    ];

    /**
     * =========================
     * RELATIONS
     * =========================
     */

    // Relasi ke pasien
    public function patient()
    {
        return $this->belongsTo(Patient::class);
    }

    // Relasi ke user (bidan)
    public function creator()
    {
        return $this->belongsTo(User::class, 'created_by');
    }
}
