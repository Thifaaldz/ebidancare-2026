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
        Schema::create('medical_records', function (Blueprint $table) {
            $table->id();

            // Relasi ke pasien
            $table->foreignId('patient_id')
                ->constrained('patients')
                ->cascadeOnDelete();

            // Jenis layanan bidan
            $table->enum('type', ['ANC', 'KB', 'NEONATAL']);

            // Tanggal pemeriksaan
            $table->date('tanggal_pemeriksaan');

            // Catatan medis
            $table->text('catatan');

            // User (bidan) yang input
            $table->foreignId('created_by')
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
        Schema::dropIfExists('medical_records');
    }
};
