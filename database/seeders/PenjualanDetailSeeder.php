<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class PenjualanDetailSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('t_penjualan_detail')->insert([
            ['penjualan_id' => 1, 'barang_id' => 1, 'harga' => 7000000, 'jumlah' => 1, 'created_at' => NOW()],
            ['penjualan_id' => 1, 'barang_id' => 2, 'harga' => 4500000, 'jumlah' => 1, 'created_at' => NOW()],
            ['penjualan_id' => 1, 'barang_id' => 3, 'harga' => 500000, 'jumlah' => 1, 'created_at' => NOW()],
            
            ['penjualan_id' => 2, 'barang_id' => 6, 'harga' => 150000, 'jumlah' => 2, 'created_at' => NOW()],
            ['penjualan_id' => 2, 'barang_id' => 7, 'harga' => 350000, 'jumlah' => 2, 'created_at' => NOW()],
            ['penjualan_id' => 2, 'barang_id' => 8, 'harga' => 180000, 'jumlah' => 2, 'created_at' => NOW()],
            
            ['penjualan_id' => 3, 'barang_id' => 4, 'harga' => 300000, 'jumlah' => 1, 'created_at' => NOW()],
            ['penjualan_id' => 3, 'barang_id' => 5, 'harga' => 550000, 'jumlah' => 3, 'created_at' => NOW()],
            ['penjualan_id' => 3, 'barang_id' => 6, 'harga' => 150000, 'jumlah' => 1, 'created_at' => NOW()],
            
            ['penjualan_id' => 4, 'barang_id' => 1, 'harga' => 700000, 'jumlah' => 3, 'created_at' => NOW()],
            ['penjualan_id' => 4, 'barang_id' => 4, 'harga' => 300000, 'jumlah' => 1, 'created_at' => NOW()],
            ['penjualan_id' => 4, 'barang_id' => 7, 'harga' => 500000, 'jumlah' => 4, 'created_at' => NOW()],
            
            ['penjualan_id' => 5, 'barang_id' => 8, 'harga' => 180000, 'jumlah' => 1, 'created_at' => NOW()],
            ['penjualan_id' => 5, 'barang_id' => 2, 'harga' => 450000, 'jumlah' => 1, 'created_at' => NOW()],
            ['penjualan_id' => 5, 'barang_id' => 4, 'harga' => 300000, 'jumlah' => 3, 'created_at' => NOW()],
            
            ['penjualan_id' => 6, 'barang_id' => 7, 'harga' => 350000, 'jumlah' => 1, 'created_at' => NOW()],
            ['penjualan_id' => 6, 'barang_id' => 9, 'harga' => 450000, 'jumlah' => 2, 'created_at' => NOW()],
            ['penjualan_id' => 6, 'barang_id' => 10, 'harga' => 200000, 'jumlah' => 1, 'created_at' => NOW()],
            
            ['penjualan_id' => 7, 'barang_id' => 3, 'harga' => 500000, 'jumlah' => 1, 'created_at' => NOW()],
            ['penjualan_id' => 7, 'barang_id' => 6, 'harga' => 150000, 'jumlah' => 5, 'created_at' => NOW()],
            ['penjualan_id' => 7, 'barang_id' => 9, 'harga' => 450000, 'jumlah' => 2, 'created_at' => NOW()],
            
            ['penjualan_id' => 8, 'barang_id' => 4, 'harga' => 300000, 'jumlah' => 1, 'created_at' => NOW()],
            ['penjualan_id' => 8, 'barang_id' => 3, 'harga' => 300000, 'jumlah' => 3, 'created_at' => NOW()],
            ['penjualan_id' => 8, 'barang_id' => 1, 'harga' => 300000, 'jumlah' => 2, 'created_at' => NOW()],
        
            ['penjualan_id' => 9, 'barang_id' => 5, 'harga' => 550000, 'jumlah' => 2, 'created_at' => NOW()],
            ['penjualan_id' => 9, 'barang_id' => 9, 'harga' => 450000, 'jumlah' => 2, 'created_at' => NOW()],
            ['penjualan_id' => 9, 'barang_id' => 4, 'harga' => 300000, 'jumlah' => 2, 'created_at' => NOW()],
            
            ['penjualan_id' => 10, 'barang_id' => 10, 'harga' => 200000, 'jumlah' => 1, 'created_at' => NOW()],
            ['penjualan_id' => 10, 'barang_id' => 2, 'harga' => 450000, 'jumlah' => 3, 'created_at' => NOW()],
            ['penjualan_id' => 10, 'barang_id' => 4, 'harga' => 300000, 'jumlah' => 3, 'created_at' => NOW()],
        ]);
    }
}
