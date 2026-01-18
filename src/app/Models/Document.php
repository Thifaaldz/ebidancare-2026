<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Document extends Model
{
    use HasFactory;

    /**
     * =========================
     * MASS ASSIGNMENT
     * =========================
     */
    protected $fillable = [
        'patient_id',
        'file_name',
        'file_path',
        'file_hash',
        'document_type',
        'uploaded_by',
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

    // Relasi ke user (pengunggah)
    public function uploader()
    {
        return $this->belongsTo(User::class, 'uploaded_by');
    }
}
