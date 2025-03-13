<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

use Illuminate\Support\Facades\DB;

class PenjualanSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
         DB::table('t_penjualan')->insert([
            ['user_id' => 1, 'pembeli' => 'Andi', 'penjualan_kode' => 'TRX001', 'penjualan_tanggal' => now(), 'created_at' => NOW()],
            ['user_id' => 1, 'pembeli' => 'Budi', 'penjualan_kode' => 'TRX002', 'penjualan_tanggal' => now(), 'created_at' => NOW()],
            ['user_id' => 1, 'pembeli' => 'Citra', 'penjualan_kode' => 'TRX003', 'penjualan_tanggal' => now(), 'created_at' => NOW()],
            ['user_id' => 2, 'pembeli' => 'Doni', 'penjualan_kode' => 'TRX004', 'penjualan_tanggal' => now(), 'created_at' => NOW()],
            ['user_id' => 2, 'pembeli' => 'Eka', 'penjualan_kode' => 'TRX005', 'penjualan_tanggal' => now(), 'created_at' => NOW()],
            ['user_id' => 2, 'pembeli' => 'Fijra', 'penjualan_kode' => 'TRX006', 'penjualan_tanggal' => now(), 'created_at' => NOW()],
            ['user_id' => 2, 'pembeli' => 'Gege', 'penjualan_kode' => 'TRX007', 'penjualan_tanggal' => now(), 'created_at' => NOW()],
            ['user_id' => 3, 'pembeli' => 'Haura', 'penjualan_kode' => 'TRX008', 'penjualan_tanggal' => now(), 'created_at' => NOW()],
            ['user_id' => 3, 'pembeli' => 'Indah', 'penjualan_kode' => 'TRX009', 'penjualan_tanggal' => now(), 'created_at' => NOW()],
            ['user_id' => 3, 'pembeli' => 'Jesika', 'penjualan_kode' => 'TRX0010', 'penjualan_tanggal' => now(), 'created_at' => NOW()],
        ]);
    }
}
