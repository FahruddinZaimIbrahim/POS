<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class StokModel extends Model
{
    use HasFactory;

    protected $table = 't_stok';
    protected $primaryKey = 'stok_id';
    protected $fillable = [
        'user_id',
        'barang_id',
        'stok_tanggal',
        'stok_jumlah',
    ];

    public function user()
    {
        return $this->belongsTo(UserModel::class,'user_id','user_id');
    }

    public function barang()
    {
        return $this->belongsTo(BarangModel::class);
    }
}
