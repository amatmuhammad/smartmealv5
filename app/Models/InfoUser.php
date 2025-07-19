<?php

namespace App\Models;

use App\Models\User;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class InfoUser extends Model
{
    use HasFactory;

    protected $table = 'tbl_info_user';

    protected $fillable = [
        'user_id',
        'umur',
        'tinggi_badan',
        'berat_badan',
        'kalori_harian',
        'status',
        'foto',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
