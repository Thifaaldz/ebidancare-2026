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
        Schema::create('transactions', function (Blueprint $table) {
            $table->id();

            // Relasi ke pasien (boleh null jika transaksi umum)
            $table->foreignId('patient_id')
                ->nullable()
                ->constrained('patients')
                ->nullOnDelete();

            // Informasi layanan
            $table->string('layanan', 150);

            // Nominal transaksi
            $table->decimal('nominal', 12, 2);

            // Tanggal transaksi
            $table->date('tanggal');

            // User yang mencatat
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
        Schema::dropIfExists('transactions');
    }
};
