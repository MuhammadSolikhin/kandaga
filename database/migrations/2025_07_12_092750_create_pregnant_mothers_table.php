<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('pregnant_mothers', function (Blueprint $table) {
            $table->id();
            $table->string('bpjs_number'); // No. BPJS
            $table->string('nik')->unique(); // NIK
            $table->string('phone_number'); // No. Telepon
            $table->text('address'); // Alamat
            $table->string('kelurahan'); // Kelurahan
            $table->float('pre_pregnancy_weight'); // Berat Badan Sebelum Mengandung (kg)

            // Data saat ini
            $table->float('current_weight'); // Berat Badan (kg)
            $table->float('height'); // Tinggi Badan (cm)
            $table->integer('age'); // Usia (tahun)
            $table->float('hemoglobin'); // HB (Hemoglobin)
            $table->float('lila'); // LILA (Lingkar Lengan Atas) cm

            $table->string('blood_pressure'); // Tekanan Darah
            $table->integer('gestational_age'); // Usia Kandungan (minggu)

            $table->float('bmi');                  // BMI hasil hitung
            $table->text('note');                  // Catatan 

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('pregnant_mothers');
    }
};
