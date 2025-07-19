<?php

namespace Database\Seeders;

use App\Models\makanan;
use Illuminate\Database\Seeder;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class MakananSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        //
         $data = [
            ['nama_makanan' => 'Gado-gado', 'kalori' => 380, 'serat' => 14, 'lemak' => 20, 'protein' => 30, 'harga' => 0, 'gambar' => ''],
            ['nama_makanan' => 'Ayam bakar + nasi', 'kalori' => 420, 'serat' => 25, 'lemak' => 10, 'protein' => 45, 'harga' => 0, 'gambar' => ''],
            ['nama_makanan' => 'Nasi goreng kampung', 'kalori' => 500, 'serat' => 18, 'lemak' => 15, 'protein' => 65, 'harga' => 0, 'gambar' => ''],
            ['nama_makanan' => 'Pecel + nasi', 'kalori' => 350, 'serat' => 12, 'lemak' => 10, 'protein' => 45, 'harga' => 0, 'gambar' => ''],
            ['nama_makanan' => 'Soto ayam bening', 'kalori' => 280, 'serat' => 20, 'lemak' => 10, 'protein' => 20, 'harga' => 0, 'gambar' => ''],
            ['nama_makanan' => 'Sayur asem + tempe', 'kalori' => 300, 'serat' => 12, 'lemak' => 8, 'protein' => 35, 'harga' => 0, 'gambar' => ''],
            ['nama_makanan' => 'Sup ayam + nasi', 'kalori' => 350, 'serat' => 20, 'lemak' => 8, 'protein' => 40, 'harga' => 0, 'gambar' => ''],
            ['nama_makanan' => 'Capcay kuah', 'kalori' => 250, 'serat' => 10, 'lemak' => 6, 'protein' => 30, 'harga' => 0, 'gambar' => ''],
            ['nama_makanan' => 'Lele bakar + nasi', 'kalori' => 400, 'serat' => 25, 'lemak' => 12, 'protein' => 40, 'harga' => 0, 'gambar' => ''],
            ['nama_makanan' => 'Tahu telur', 'kalori' => 420, 'serat' => 16, 'lemak' => 20, 'protein' => 35, 'harga' => 0, 'gambar' => ''],
            ['nama_makanan' => 'Nasi uduk (½ porsi)', 'kalori' => 380, 'serat' => 10, 'lemak' => 12, 'protein' => 50, 'harga' => 0, 'gambar' => ''],
            ['nama_makanan' => 'Lontong sayur', 'kalori' => 420, 'serat' => 12, 'lemak' => 15, 'protein' => 50, 'harga' => 0, 'gambar' => ''],
            ['nama_makanan' => 'Jagung rebus', 'kalori' => 100, 'serat' => 3, 'lemak' => 1, 'protein' => 20, 'harga' => 0, 'gambar' => ''],
            ['nama_makanan' => 'Bubur ayam (tanpa kerupuk & cakwe)', 'kalori' => 300, 'serat' => 12, 'lemak' => 6, 'protein' => 40, 'harga' => 0, 'gambar' => ''],
            ['nama_makanan' => 'Tempe goreng + sayur bening + nasi sedikit', 'kalori' => 360, 'serat' => 15, 'lemak' => 10, 'protein' => 40, 'harga' => 0, 'gambar' => ''],
            ['nama_makanan' => 'Mie goreng (porsi sedang)', 'kalori' => 450, 'serat' => 10, 'lemak' => 15, 'protein' => 60, 'harga' => 0, 'gambar' => ''],
            ['nama_makanan' => 'Bakso kuah (tanpa mie & gorengan)', 'kalori' => 300, 'serat' => 15, 'lemak' => 10, 'protein' => 25, 'harga' => 0, 'gambar' => ''],
            ['nama_makanan' => 'Nasi kuning + telur rebus', 'kalori' => 400, 'serat' => 13, 'lemak' => 10, 'protein' => 50, 'harga' => 0, 'gambar' => ''],
            ['nama_makanan' => 'Lontong opor ayam', 'kalori' => 430, 'serat' => 18, 'lemak' => 18, 'protein' => 40, 'harga' => 0, 'gambar' => ''],
            ['nama_makanan' => 'Nasi padang (nasi setengah, ayam rebus, sayur singkong)', 'kalori' => 450, 'serat' => 22, 'lemak' => 12, 'protein' => 50, 'harga' => 0, 'gambar' => ''],
        ];


        foreach ($data as $item) {
            makanan::create($item);
        }
    }
}
