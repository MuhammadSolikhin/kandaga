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
        Schema::create('child_health_records', function (Blueprint $table) {
            $table->id();

            // Identitas
            $table->string('bpjs_number');
            $table->string('nik')->unique();
            $table->string('phone_number');
            $table->text('address');
            $table->string('kelurahan'); // ex: Bondongan

            // Jenis kelamin
            $table->enum('gender', ['Laki-laki', 'Perempuan']);

            // Data anak
            $table->float('weight'); // kg
            $table->float('height'); // cm
            $table->integer('age_months'); // usia dalam bulan

            // Output hasil evaluasi
            $table->text('note'); // contoh: "Berat badan normal"

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('child_health_records');
    }
};
