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
        Schema::create('tbl_hasil_topsis', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('makanan_id');
            $table->double('d_plus');
            $table->double('d_minus');
            $table->double('nilai_preferensi');
            $table->integer('ranking');
            $table->timestamps();

            $table->foreign('makanan_id')->references('id')->on('tbl_makanan')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('tbl_hasil_topsis');
    }
};
