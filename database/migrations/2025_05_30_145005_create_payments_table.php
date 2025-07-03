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
        Schema::create('payments', function (Blueprint $table) {
            $table->id();
            $table->string('siswa_id')->onDelete('cascade');
            $table->string('spp_id')->onDelete('cascade');
            $table->timestamp('paid_at')->nullable();
            $table->string('order_id');
            $table->string('paid_month');
            $table->string('paid_year');
            $table->decimal('amount', 12, 2);
            $table->enum('status', ['unpaid', 'paid','pending'])->default('unpaid');
            $table->string('snap_token')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('payments');
    }
};
