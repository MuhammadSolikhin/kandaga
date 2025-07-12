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
            $table->string('bpjs_number')->nullable(); // No. BPJS
            $table->string('nik')->unique(); // NIK
            $table->string('phone_number')->nullable(); // No. Telepon
            $table->text('address')->nullable(); // Alamat
            $table->string('kelurahan')->nullable(); // Kelurahan
            $table->float('pre_pregnancy_weight')->nullable(); // Berat Badan Sebelum Mengandung (kg)

            // Data saat ini
            $table->float('current_weight')->nullable(); // Berat Badan (kg)
            $table->float('height')->nullable(); // Tinggi Badan (cm)
            $table->integer('age')->nullable(); // Usia (tahun)
            $table->float('hemoglobin')->nullable(); // HB (Hemoglobin)
            $table->float('lila')->nullable(); // LILA (Lingkar Lengan Atas) cm

            $table->string('blood_pressure')->nullable(); // Tekanan Darah
            $table->integer('gestational_age')->nullable(); // Usia Kandungan (minggu)

            $table->float('bmi')->nullable();                  // BMI hasil hitung
            $table->text('note')->nullable();                  // Catatan 

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
