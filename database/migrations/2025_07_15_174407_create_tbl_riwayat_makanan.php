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
        Schema::create('tbl_riwayat_makanan', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained('users')->onDelete('cascade');
            $table->foreignId('makanan_id')->constrained('tbl_makanan')->onDelete('cascade');
            $table->enum('waktu_makan', ['sarapan', 'makan_siang', 'snack', 'makan_malam']);
            $table->date('tanggal'); // untuk grouping harian
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('tbl_riwayat_makanan');
    }
};
