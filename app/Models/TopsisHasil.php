<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TopsisHasil extends Model
{
    use HasFactory;

    protected $table = 'tbl_hasil_topsis';

    protected $fillable = [
        'makanan_id',
        'd_plus',
        'd_minus',
        'nilai_preferensi',
        'ranking',
    ];

    public function makanan()
    {
        return $this->belongsTo(makanan::class);
    }
}
