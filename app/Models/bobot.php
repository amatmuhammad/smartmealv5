<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class bobot extends Model
{
    use HasFactory;

    protected $table = 'tbl_bobot';
    protected $fillable = ['nama_kriteria', 'bobot', 'atribut'];
}
