<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('documents', function (Blueprint $table) {
            $table->id();

            // Relasi ke pasien
            $table->foreignId('patient_id')
                ->constrained('patients')
                ->cascadeOnDelete();

            // Informasi file
            $table->string('file_name');
            $table->string('file_path');
            $table->string('file_hash', 64);

            // Klasifikasi dokumen
            $table->enum('document_type', [
                'ANC',
                'KB',
                'NEONATAL',
                'LAINNYA'
            ]);

            // User yang mengunggah
            $table->foreignId('uploaded_by')
                ->constrained('users');

            // Metadata sistem
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('documents');
    }
};
