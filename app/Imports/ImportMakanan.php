<?php

namespace App\Imports;

use App\Models\makanan;
use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\ToCollection;
use Maatwebsite\Excel\Concerns\WithHeadingRow;

class ImportMakanan implements ToCollection, WithHeadingRow
{
    /**
    * @param Collection $collection
    */
    public function collection(Collection $collection)
    {
        //
        foreach ($collection as $row) {

             // Lewati jika nama_makanan kosong
            if (empty($row['nama_makanan'])) {
                continue;
            }

            makanan::create([
                'nama_makanan' => $row['nama_makanan'],
                'kalori'       => $row['kalori'],
                'protein'      => $row['protein'],
                'lemak'        => $row['lemak'],
                'serat'        => $row['serat'],
                'gambar'       => $row['gambar'] ?? 'default.jpg',
            ]);
        }
    }
}
