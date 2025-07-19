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
        Schema::create('tbl_bobot', function (Blueprint $table) {
            $table->id();
            $table->string('nama_kriteria'); // contoh: kalori, protein
            $table->float('bobot');          // contoh: 0.2, 0.3
            $table->enum('atribut', ['benefit', 'cost']); // jenis kriteria
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('tbl_bobot');
    }
};
