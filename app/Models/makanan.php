<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class makanan extends Model
{
    use HasFactory;

    // Nama tabel
    protected $table = 'tbl_makanan';

    // Kolom yang bisa diisi (mass assignment)
    protected $fillable = [
        'nama_makanan',
        'kalori',
        'serat',
        'lemak',
        'protein',
        'gambar',
    ];
}
