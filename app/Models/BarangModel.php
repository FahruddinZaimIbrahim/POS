<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class BarangModel extends Model
{
    protected $table = "m_barang";
    protected $primaryKey = "barang_id";

    protected $fillable = ['barang_kode','barang_nama', 'harga_beli', 'harga_jual'];

    public function kategori(): HasMany
    {
        return $this->hasMany(KategoriModel::class, 'kategori_id', 'kategori_id');
    }
}