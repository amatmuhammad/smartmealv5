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
        Schema::create('tbl_makanan', function (Blueprint $table) {
            $table->id();
            $table->string('nama_makanan');
            $table->float('kalori');
            $table->float('serat');
            $table->float('lemak');
            $table->float('protein');
            $table->float('harga');
            $table->string('gambar');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('tbl_makanan');
    }
};
