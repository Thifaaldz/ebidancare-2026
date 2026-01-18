<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Patient extends Model
{
    use HasFactory;

    /**
     * =========================
     * MASS ASSIGNMENT
     * =========================
     */
    protected $fillable = [
        'nik',
        'nama',
        'tanggal_lahir',
        'jenis_kelamin',
        'alamat',
        'no_hp',
    ];

    /**
     * =========================
     * RELATIONS
     * =========================
     */

    // Relasi ke rekam medis
    public function medicalRecords()
    {
        return $this->hasMany(MedicalRecord::class);
    }

    // Relasi ke arsip dokumen
    public function documents()
    {
        return $this->hasMany(Document::class);
    }

    // Relasi ke transaksi (jika ada)
    public function transactions()
    {
        return $this->hasMany(Transaction::class);
    }
}
