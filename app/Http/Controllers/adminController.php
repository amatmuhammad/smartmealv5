<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\bobot;
use App\Models\makanan;
use App\Models\TopsisHasil;
use Illuminate\Http\Request;
use App\Imports\ImportMakanan;
use Maatwebsite\Excel\Facades\Excel;

class adminController extends Controller
{
    //

    public function dashboard(){
        $usercount = User::where('is_admin', false)->count();

        
        $makanan = Makanan::count();
        $users = User::with('InfoUser')->get();

        // Hitung jumlah berdasarkan status
        $statusCounts = [
            'Kurus' => 0,
            'Normal' => 0,
            'Overweight' => 0,
            'Obesitas I' => 0,
            'Obesitas II' => 0,
        ];

        foreach ($users as $user) {
            $status = $user->InfoUser->status ?? null;
            if ($status && isset($statusCounts[$status])) {
                $statusCounts[$status]++;
            }
        }
        return view('admin.dashboard', compact('usercount','makanan','users','statusCounts'));
    }

    public function alternatif(){
        return view('admin.alternatif');
    }


    public function makanan(){
        $makan = makanan::all();
        // dd($makan);
        return view('admin.makanan',compact('makan'));
    }

    public function usermanage(){

        $user = User::where('is_admin', false)->with('InfoUser')->get();

        // dd($user);
        return view('admin.manajemenuser', compact('user'));
    }

    public function storemakanan(Request $request)
    {
      
       // Validasi input
        $request->validate([
            'nama_makanan' => 'required|string|max:255',
            'kalori'       => 'required|numeric',
            'serat'        => 'required|numeric',
            'lemak'        => 'required|numeric',
            'protein'      => 'required|numeric',
            'gambar'       => 'nullable|image|mimes:jpg,jpeg,png|max:2048',
        ]);

        // Simpan gambar ke public/images
        $namaFile = 'default.jpg'; // default jika tidak upload gambar
        if ($request->hasFile('gambar')) {
            $file = $request->file('gambar');
            $namaFile = time() . '.' . $file->getClientOriginalExtension();
            $file->move(base_path('/images'), $namaFile);
        }

        // Simpan data ke DB
        makanan::create([
            'nama_makanan' => $request->nama_makanan,
            'kalori'       => $request->kalori,
            'serat'        => $request->serat,
            'lemak'        => $request->lemak,
            'protein'      => $request->protein,
            'gambar'       => $namaFile,
        ]);

        return redirect()->route('makanan')->with('success', 'Data makanan berhasil ditambahkan.');
    }


      
    // Update data
    public function updatemakanan(Request $request, $id)
    {
        // Cari data makanan
        $makanan = makanan::findOrFail($id);

        // Validasi input
        $request->validate([
            'nama_makanan' => 'required|string|max:255',
            'kalori'       => 'required|numeric',
            'serat'        => 'required|numeric',
            'lemak'        => 'required|numeric',
            'protein'      => 'required|numeric',
            'gambar'       => 'nullable|image|mimes:jpg,jpeg,png|max:2048',
        ]);

        // Cek apakah ada file gambar baru
        if ($request->hasFile('gambar')) {
            $file = $request->file('gambar');
            $namaFile = time() . '.' . $file->getClientOriginalExtension();

            // Upload gambar baru
            $file->move(base_path('/images'), $namaFile);

            // Hapus gambar lama (selain default.jpg)
            if ($makanan->gambar && $makanan->gambar !== 'default.jpg') {
                $gambarLama = public_path('images/' . $makanan->gambar);
                if (file_exists($gambarLama)) {
                    unlink($gambarLama);
                }
            }

            // Simpan nama file baru
            $makanan->gambar = $namaFile;
        }

        // Update data lainnya
        $makanan->nama_makanan = $request->nama_makanan;
        $makanan->kalori       = $request->kalori;
        $makanan->serat        = $request->serat;
        $makanan->lemak        = $request->lemak;
        $makanan->protein      = $request->protein;

        $makanan->save();

        return redirect()->route('makanan')->with('success', 'Data makanan berhasil diperbarui.');
    }

    // Hapus data
    public function destroymakanan($id)
    {
        $makanan = makanan::findOrFail($id);
        $makanan->delete();

        return redirect()->route('makanan')->with('success', 'Data makanan berhasil dihapus.');
    }


    public function pembobotan(){
        $bobots = bobot::all();

        return view('admin.bobot',compact('bobots'));  
    }

    public function createbobot(Request $request)
    {
        $request->validate([
            'nama_kriteria' => 'required|string',
            'bobot' => 'required|numeric',
            'atribut' => 'required|in:benefit,cost'
        ]);

        bobot::create($request->all());
        return redirect()->route('pembobotan')->with('success', 'Bobot berhasil ditambahkan');
    }

    public function updatebobot(Request $request, $id)
    {
        $request->validate([
            'nama_kriteria' => 'required|string',
            'bobot' => 'required|numeric',
            'atribut' => 'required|in:benefit,cost'
        ]);

        $bobot = bobot::findOrFail($id);
        $bobot->update($request->all());
        return redirect()->route('pembobotan')->with('success', 'Bobot berhasil diperbarui');
    }

    public function destroybobot($id)
    {
        $bobot = bobot::findOrFail($id);
        $bobot->delete();
        return redirect()->route('pembobotan')->with('success', 'Bobot berhasil dihapus');
    }

    public function topsis()
    {
        $makanan = Makanan::all();
        $bobot = Bobot::all()->keyBy('nama_kriteria');

        $kriteria = $bobot->keys()->toArray();

        // Matriks Keputusan
        $matriks = [];
        foreach ($makanan as $item) {
            $row = [];
            foreach ($kriteria as $k) {
                $row[$k] = $item->$k;
            }
            $matriks[$item->id] = $row;
        }

        // Langkah 1: Normalisasi
        $pembagi = [];
        foreach ($kriteria as $k) {
            $pembagi[$k] = sqrt(array_sum(array_map(fn($row) => pow($row[$k], 2), $matriks)));
        }

        $normalisasi = [];
        foreach ($matriks as $id => $row) {
            foreach ($kriteria as $k) {
                $normalisasi[$id][$k] = $row[$k] / $pembagi[$k];
            }
        }

        // Langkah 2: Normalisasi Terbobot
        $terbobot = [];
        foreach ($normalisasi as $id => $row) {
            foreach ($kriteria as $k) {
                $terbobot[$id][$k] = $row[$k] * $bobot[$k]->bobot;
            }
        }
        // dd($terbobot);

        // Langkah 3: Solusi Ideal
        $idealPositif = [];
        $idealNegatif = [];
        foreach ($kriteria as $k) {
            $values = array_column($terbobot, $k);
            if ($bobot[$k]->atribut == 'benefit') {
                $idealPositif[$k] = max($values);
                $idealNegatif[$k] = min($values);
            } else {
                $idealPositif[$k] = min($values);
                $idealNegatif[$k] = max($values);
            }
        }

        // Langkah 4: Jarak ke solusi ideal
        $jarakPositif = [];
        $jarakNegatif = [];
        foreach ($terbobot as $id => $row) {
            $jarakPositif[$id] = sqrt(array_sum(array_map(fn($k) => pow($row[$k] - $idealPositif[$k], 2), $kriteria)));
            $jarakNegatif[$id] = sqrt(array_sum(array_map(fn($k) => pow($row[$k] - $idealNegatif[$k], 2), $kriteria)));
        }

        // Langkah 5: Nilai Preferensi
        $preferensi = [];
        foreach ($makanan as $item) {
            $id = $item->id;
            $v = $jarakPositif[$id] + $jarakNegatif[$id];
            $preferensi[$id] = $v == 0 ? 0 : $jarakNegatif[$id] / $v;
        }

        // Gabungkan hasil preferensi dengan makanan
        $hasil = $makanan->map(function ($item) use ($preferensi, $jarakNegatif, $jarakPositif) {
            return [
                'id' => $item->id,
                'nama_makanan' => $item->nama_makanan,
                'd_plus' => round($jarakPositif[$item->id], 4),
                'd_minus' => round($jarakNegatif[$item->id], 4),
                'nilai_preferensi' => round($preferensi[$item->id], 4),
            ];
        })->sortByDesc('nilai_preferensi')->values();

        // Setelah perhitungan preferensi dan sort
        $hasil = $hasil->map(function ($item, $index) {
            $item['ranking'] = $index + 1;
            return $item;
        });

        // Hapus data lama agar tidak duplikat
        TopsisHasil::truncate();

        // Simpan ke database
        foreach ($hasil as $item) {
            TopsisHasil::create([
                'makanan_id' => $item['id'],
                'd_plus' => $item['d_plus'],
                'd_minus' => $item['d_minus'],
                'nilai_preferensi' => $item['nilai_preferensi'],
                'ranking' => $item['ranking'],
            ]);
        }

        return view('admin.hasiltopsis', compact('hasil'));
    }

    public function destroyuser($id)
    {
        $user = User::with('InfoUser')->findOrFail($id);

        // Hapus relasi InfoUser terlebih dahulu
        if ($user->InfoUser) {
            $user->InfoUser->delete();
        }

        // Hapus user
        $user->delete();

        return redirect()->back()->with('success', 'Data user dan info user berhasil dihapus.');
    }

    public function import(Request $request)
    {
        $request->validate([
            'excel_file' => 'required|mimes:xlsx,xls'
        ]);

        Excel::import(new ImportMakanan, $request->file('excel_file'));

        return redirect()->back()->with('success', 'Data makanan berhasil diimport!');
    }

}





















