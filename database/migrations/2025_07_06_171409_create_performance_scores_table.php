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
        Schema::create('performance_scores', function (Blueprint $table) {
            $table->id();
            $table->string('user_id')->nullable();

            $table->date('periode')->nullable(); // Added for period tracking (monthly)

            // Indicators with scores 1-4
            $table->integer('kehadiran')->default(0);           // 1-4
            $table->integer('ketepatan_waktu')->default(0);     // 1-4
            $table->integer('laporan_kegiatan')->default(0);    // 1-4
            $table->integer('kelengkapan_laporan')->default(0); // 1-4

            // Calculation results
            $table->integer('total_skor')->default(0);
            $table->decimal('persentase', 5, 2)->default(0);
            $table->string('keterangan'); // Sempurna, Baik, Cukup, Kurang

            // Additional metrics for reference
            $table->integer('total_absensi')->default(0);
            $table->integer('total_laporan')->default(0);
            $table->integer('total_laporan_lengkap')->default(0);

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('performance_scores');
    }
};
