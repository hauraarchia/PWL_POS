<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

use Illuminate\Support\Facades\DB;

class BarangSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $data = [
            // Supplier 1
            ['kategori_id' => 1, 'barang_kode' => 'BRG001', 'barang_nama' => 'Laptop', 'harga_beli' => 5000000, 'harga_jual' => 7000000, 'created_at' => NOW()],
            ['kategori_id' => 1, 'barang_kode' => 'BRG002', 'barang_nama' => 'Smartphone', 'harga_beli' => 3000000, 'harga_jual' => 4500000, 'created_at' => NOW()],
            ['kategori_id' => 1, 'barang_kode' => 'BRG101', 'barang_nama' => 'Monitor LED 24 Inch', 'harga_beli' => 1200000, 'harga_jual' => 1800000, 'created_at' => NOW()],
            ['kategori_id' => 1, 'barang_kode' => 'BRG102', 'barang_nama' => 'Mouse Gaming', 'harga_beli' => 250000, 'harga_jual' => 400000, 'created_at' => NOW()],
            ['kategori_id' => 1, 'barang_kode' => 'BRG103', 'barang_nama' => 'Keyboard Mechanical', 'harga_beli' => 500000, 'harga_jual' => 750000, 'created_at' => NOW()],

            // Supplier 2
            ['kategori_id' => 2, 'barang_kode' => 'BRG006', 'barang_nama' => 'Kemeja', 'harga_beli' => 100000, 'harga_jual' => 150000, 'created_at' => NOW()],
            ['kategori_id' => 2, 'barang_kode' => 'BRG007', 'barang_nama' => 'Celana Jeans', 'harga_beli' => 200000, 'harga_jual' => 300000, 'created_at' => NOW()],
            ['kategori_id' => 2, 'barang_kode' => 'BRG201', 'barang_nama' => 'Jaket Hoodie', 'harga_beli' => 150000, 'harga_jual' => 220000, 'created_at' => NOW()],
            ['kategori_id' => 2, 'barang_kode' => 'BRG202', 'barang_nama' => 'Sepatu Sneakers', 'harga_beli' => 350000, 'harga_jual' => 500000, 'created_at' => NOW()],
            ['kategori_id' => 2, 'barang_kode' => 'BRG203', 'barang_nama' => 'Kaos Polos', 'harga_beli' => 70000, 'harga_jual' => 120000, 'created_at' => NOW()],
            // Supplier 3
            ['kategori_id' => 3, 'barang_kode' => 'BRG011', 'barang_nama' => 'Pensil', 'harga_beli' => 2000, 'harga_jual' => 5000, 'created_at' => NOW()],
            ['kategori_id' => 3, 'barang_kode' => 'BRG012', 'barang_nama' => 'Buku Tulis', 'harga_beli' => 5000, 'harga_jual' => 10000, 'created_at' => NOW()],
            ['kategori_id' => 3, 'barang_kode' => 'BRG301', 'barang_nama' => 'Kopi Bubuk 250gr', 'harga_beli' => 30000, 'harga_jual' => 50000, 'created_at' => NOW()],
            ['kategori_id' => 3, 'barang_kode' => 'BRG302', 'barang_nama' => 'Mie Instan 1 Dus', 'harga_beli' => 90000, 'harga_jual' => 120000, 'created_at' => NOW()],
            ['kategori_id' => 3, 'barang_kode' => 'BRG303', 'barang_nama' => 'Susu UHT 1L', 'harga_beli' => 15000, 'harga_jual' => 25000, 'created_at' => NOW()],
        ];

        DB::table('m_barang')->insert($data);
    }
}
