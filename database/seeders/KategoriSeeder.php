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
            ['kategori_kode' => 'KTG001', 'kategori_nama' => 'Elektronik', 'created_at' => NOW()],
            ['kategori_kode' => 'KTG002', 'kategori_nama' => 'Pakaian', 'created_at' => NOW()],
            ['kategori_kode' => 'KTG003', 'kategori_nama' => 'Makanan', 'created_at' => NOW()],
            ['kategori_kode' => 'KTG004', 'kategori_nama' => 'Alat Tulis', 'created_at' => NOW()],
            ['kategori_kode' => 'KTG005', 'kategori_nama' => 'Perabotan', 'created_at' => NOW()],
        ];
        DB::table('m_kategori')->insert($data);
    }
}
