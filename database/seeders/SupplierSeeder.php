<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class SupplierSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
       DB::table('m_supplier')->insert([
            ['supplier_kode' => 'SUP001', 'supplier_nama' => 'PT. Sumber Jaya', 'supplier_alamat' => 'Jl. Merdeka No.1', 'created_at' => NOW()],
            ['supplier_kode' => 'SUP002', 'supplier_nama' => 'CV. Makmur Sentosa', 'supplier_alamat' => 'Jl. Sudirman No.45', 'created_at' => NOW()],
            ['supplier_kode' => 'SUP003', 'supplier_nama' => 'UD. Sukses Abadi', 'supplier_alamat' => 'Jl. Diponegoro No.77', 'created_at' => NOW()],
        ]);
    }
}
