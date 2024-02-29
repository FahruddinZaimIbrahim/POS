<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class KategoriSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $data = [
            ['kategori_id' => 1, 'kode_kategori' => 'MKN', 'nama_kategori' => 'Makanan'],
            ['kategori_id' => 2, 'kode_kategori' => 'PKN', 'nama_kategori' => 'Pakaian'],
            ['kategori_id' => 3, 'kode_kategori' => 'EKT', 'nama_kategori' => 'Elektronik'],
            ['kategori_id' => 4, 'kode_kategori' => 'ALT', 'nama_kategori' => 'Alat'],
            ['kategori_id' => 5, 'kode_kategori' => 'KES', 'nama_kategori' => 'Kesehatan'],
        ];
        DB::table('m_kategori')->insert($data);
    }
}
