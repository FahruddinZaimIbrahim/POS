<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\Hasmany;

class KategoriModel extends Model
{
    protected $table = 'm_kategori';
    protected $primaryKey = 'kategori_id';

    protected $fillable = [
        'kode_kategori',
        'nama_kategori',
    ];

    public function barang(): Hasmany
    {
        return $this->hasMany(BarangModel::class, 'barang_id', 'barang_id');
    }
}