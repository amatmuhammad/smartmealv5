<?php

namespace App\Models;

use App\Models\User;
use App\Models\makanan;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class RiwayatMakanan extends Model
{
    use HasFactory;
    
    protected $table = 'tbl_riwayat_makanan';

    protected $fillable = ['user_id', 'makanan_id', 'waktu_makan', 'tanggal'];

    public function makanan()
    {
        return $this->belongsTo(makanan::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
