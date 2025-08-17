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
            $table->string('indicator_id');
            // hasil perhitungan
            $table->integer('total_skor');
            $table->decimal('persentase', 5, 2); // ex: 75.00
            $table->string('keterangan'); // Baik, Cukup, Kurang, Sempurna
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
