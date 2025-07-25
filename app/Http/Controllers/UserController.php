<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use App\Models\InfoUser;
use App\Models\TopsisHasil;
use Illuminate\Http\Request;
use App\Models\RiwayatMakanan;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function indexuser()
    {
        $info = InfoUser::where('user_id', Auth::id())->first();

        $rekomendasi = [];
        $userKalori = null;
        $alertHari = [];
        $kaloriHariIni = 0;
        $kaloriPerwaktu = [];

        if ($info) {
            // Bulatkan kalori_harian ke kelipatan 50 terdekat
            $userKalori = round(Auth::user()->InfoUser->kalori_harian / 50) * 50;

            // Hitung riwayat total kalori per hari
            $riwayatKalori = DB::table('tbl_riwayat_makanan')
                ->where('user_id', Auth::id())
                ->join('tbl_makanan', 'tbl_makanan.id', '=', 'tbl_riwayat_makanan.makanan_id')
                ->selectRaw('tanggal, SUM(tbl_makanan.kalori) as total_kalori')
                ->groupBy('tanggal')
                ->orderBy('tanggal')
                ->get();

            // Cek jika ada yang melebihi batas
            foreach ($riwayatKalori as $r) {
                if ($r->total_kalori > $userKalori) {
                    $alertHari[] = [
                        'tanggal' => $r->tanggal,
                        'total_kalori' => $r->total_kalori,
                    ];
                }
            }

            // ✅ Hitung total kalori yang dikonsumsi hari ini
            $kaloriHariIni = DB::table('tbl_riwayat_makanan')
                ->where('user_id', Auth::id())
                ->whereDate('tanggal', now()->toDateString())
                ->join('tbl_makanan', 'tbl_makanan.id', '=', 'tbl_riwayat_makanan.makanan_id')
                ->sum('tbl_makanan.kalori');

            // ✅ Rekomendasi makanan per waktu makan
            $persen = [
                'sarapan' => 0.25,
                'makan_siang' => 0.35,
                'snack' => 0.10,
                'makan_malam' => 0.30,
            ];

            foreach ($persen as $waktu => $porsi) {
                $targetKalori = $userKalori * $porsi;
                $kaloriPerwaktu[$waktu] = $targetKalori; 

                $rekomendasi[$waktu] = TopsisHasil::with('makanan')
                    ->whereHas('makanan', function ($q) use ($targetKalori) {
                        $q->whereBetween('kalori', [$targetKalori - 50, $targetKalori + 50]);
                    })
                    ->orderByDesc('nilai_preferensi')
                    ->take(3)
                    ->get();
            }
        }

        return view('user.dashboard_user', compact(
            'info',
            'rekomendasi',
            'userKalori',
            'alertHari',
            'kaloriHariIni',
            'kaloriPerwaktu', 
        ));
    }

    // public function store(Request $request)
    // {
    //     $request->validate([
    //         'umur' => 'required|integer|min:10|max:100',
    //         'tinggi_badan' => 'required|numeric|min:100|max:250',
    //         'berat_badan' => 'required|numeric|min:20|max:300',
    //         'foto' => 'nullable|image|max:2048',
    //     ]);

    //     $user_id = Auth::id();
    //     $tinggi = $request->tinggi_badan;
    //     $berat = $request->berat_badan;
    //     $kalori = round(10 * $berat + 6.25 * $tinggi - 5 * $request->umur); 
    //         $bmi = $berat / pow($tinggi / 100, 2);
    //         $status = $this->kategoriBMI($bmi);

    //     $foto = $request->file('foto') ? $request->file('foto')->store('foto_user', 'public') : '';

    //     InfoUser::create([
    //         'user_id' => $user_id,
    //         'umur' => $request->umur,
    //         'tinggi_badan' => $tinggi,
    //         'berat_badan' => $berat,
    //         'kalori_harian' => $kalori,
    //         'status' => $status,
    //         'foto' => $foto,
    //     ]);

    //     return redirect()->back()->with('success', 'Data diri berhasil disimpan');
    // }

    public function store(Request $request)
    {
        $request->validate([
            'umur'          => 'required|integer|min:10|max:100',
            'tinggi_badan'  => 'required|numeric|min:100|max:250',
            'berat_badan'   => 'required|numeric|min:20|max:300',
            'foto'          => 'nullable|image|mimes:jpg,jpeg,png|max:2048',
        ]);

        $user_id = Auth::id();
        $tinggi = $request->tinggi_badan;
        $berat = $request->berat_badan;
        $kalori = round(10 * $berat + 6.25 * $tinggi - 5 * $request->umur); 
        $bmi = $berat / pow($tinggi / 100, 2);
        $status = $this->kategoriBMI($bmi);

        $fotoPath = '';

        if ($request->hasFile('foto')) {
            $foto = $request->file('foto');
            $namaFile = time() . '.' . $foto->getClientOriginalExtension();
            $tujuan = base_path('/foto');

            $foto->move($tujuan, $namaFile);
            $fotoPath =  $namaFile;
        }

        InfoUser::create([
            'user_id' => $user_id,
            'umur' => $request->umur,
            'tinggi_badan' => $tinggi,
            'berat_badan' => $berat,
            'kalori_harian' => $kalori,
            'status' => $status,
            'foto' => $fotoPath,
        ]);

        return redirect()->back()->with('success', 'Data diri berhasil disimpan');
    }


    private function kategoriBMI($bmi)
    {
        if ($bmi < 18.5) return 'Kurus';
        elseif ($bmi < 23) return 'Normal';
        elseif ($bmi < 25) return 'Overweight';
        elseif ($bmi < 30) return 'Obesitas I';
        return 'Obesitas II';
    }

    public function update(Request $request, $id)
    {
        $info = InfoUser::where('user_id', Auth::id())->findOrFail($id);

        $request->validate([
            'umur'          => 'required|integer|min:10|max:100',
            'tinggi_badan'  => 'required|numeric|min:100|max:250',
            'berat_badan'   => 'required|numeric|min:20|max:300',
            'foto'          => 'nullable|image|mimes:jpg,jpeg,png|max:2048',
        ]);

        $info->umur = $request->umur;
        $info->tinggi_badan = $request->tinggi_badan;
        $info->berat_badan = $request->berat_badan;

        if ($request->hasFile('foto')) {
            // Hapus foto lama jika ada
            if ($info->foto && file_exists(public_path($info->foto))) {
                unlink(public_path($info->foto));
            }

            // Simpan foto baru ke folder public/images
            $foto = $request->file('foto');
            $namaFile = time() . '.' . $foto->getClientOriginalExtension();
            $tujuan = base_path('/foto');

            $foto->move($tujuan, $namaFile);
            $info->foto =  $namaFile;
        }

        $info->save();

        return redirect()->back()->with('success', 'Data berhasil diperbarui');
    }


    public function riwayat(Request $request)
    {
        $rekom = TopsisHasil::with('makanan')->orderByDesc('nilai_preferensi')->get();
        $riwayat = RiwayatMakanan::with('makanan')
            ->where('user_id', Auth::id())
            ->orderByDesc('tanggal')
            ->get();

        // Ambil bulan dari request, default bulan ini
        $bulan = $request->input('bulan', now()->format('Y-m'));

        $kaloriHarian = RiwayatMakanan::where('user_id', Auth::id())
            ->join('tbl_makanan', 'tbl_makanan.id', '=', 'tbl_riwayat_makanan.makanan_id')
            ->whereRaw("DATE_FORMAT(tanggal, '%Y-%m') = ?", [$bulan])
            ->selectRaw('tanggal, SUM(tbl_makanan.kalori) as total_kalori')
            ->groupBy('tanggal')
            ->orderBy('tanggal')
            ->get();
        
            // dd($kaloriHarian);

        return view('user.riwayat', compact('riwayat','rekom', 'kaloriHarian', 'bulan'));
    }




    public function storeriwayat(Request $request)
    {
        $request->validate([
            'makanan_id' => 'required|exists:tbl_makanan,id',
            'waktu_makan' => 'required|in:sarapan,makan_siang,snack,makan_malam',
            'tanggal' => 'required|date',
        ]);

        RiwayatMakanan::create([
            'user_id' => Auth::id(),
            'makanan_id' => $request->makanan_id,
            'waktu_makan' => $request->waktu_makan,
            'tanggal' => $request->tanggal,
        ]);

        return redirect()->back()->with('success', 'Riwayat makanan berhasil ditambahkan!');
    }


    


    
}
