<?php

namespace Database\Seeders;

use App\Models\bobot;
use Illuminate\Database\Seeder;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class BobotKriteriaSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        //
        $data = [
            [
                'nama_kriteria' => 'kalori',
                'bobot' => 0.25,
                'atribut' => 'benefit',
            ],
            [
                'nama_kriteria' => 'serat',
                'bobot' => 0.25,
                'atribut' => 'benefit',
            ],
            [
                'nama_kriteria' => 'lemak',
                'bobot' => 0.20,
                'atribut' => 'cost',
            ],
            [
                'nama_kriteria' => 'protein',
                'bobot' => 0.30,
                'atribut' => 'benefit',
            ],
        ];

        foreach ($data as $item) {
            bobot::create($item);
        }
    }
}
