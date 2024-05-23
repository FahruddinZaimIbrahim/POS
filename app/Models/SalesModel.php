<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SalesModel extends Model
{
    use HasFactory;

    protected $table = 't_penjualan';
    protected $primaryKey = 'penjualan_id';
    protected $fillable = [
        'user_id',
        'pembeli',
        'penjualan_tanggal',
        'penjualan_kode',
    ];

    public function user()
    {
        return $this->belongsTo(UserModel::class);
    }
}
