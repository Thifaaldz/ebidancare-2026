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
        Schema::create('patients', function (Blueprint $table) {
            $table->id();

            // Identitas utama pasien (unique)
            $table->string('nik', 20)->unique();

            // Data pribadi
            $table->string('nama', 150);
            $table->date('tanggal_lahir');
            $table->enum('jenis_kelamin', ['P', 'L'])->default('P');

            // Kontak & alamat
            $table->text('alamat')->nullable();
            $table->string('no_hp', 20)->nullable();

            // Metadata sistem
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('patients');
    }
};
