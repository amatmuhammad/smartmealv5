<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

class AuthController extends Controller
{
    //
    public function login(){
        return view('partials.login');
    }

    public function indexregister(){
        return view('partials.register');
    }

    // public function loginproses(Request $request)
    // {
    //     // dd($request->all());
    //     // Validasi input
    //     $request->validate([
    //         'email'    => 'required|email',
    //         'password' => 'required',
    //     ]);

    //     $credentials = $request->only('email', 'password');

    //     if (Auth::attempt($credentials)) {
    //         // Login berhasil
    //         $user = Auth::user();

    //         if (Gate::allows('admin')) {
    //             return redirect()->route('dashboard')->with('success', 'Berhasil login sebagai Admin');
    //         } elseif (Gate::allows('user')) {
    //             return redirect()->route('indexuser')->with('success', 'Berhasil login sebagai User');
    //         }

    //         // Jika role tidak dikenali
    //         Auth::logout();
    //         return redirect()->back()->with('error', 'Role tidak dikenali');
    //     }

    //     // Login gagal
    //     return redirect()->back()->with('error', 'Email atau password salah');
    // }

    public function loginproses(Request $request)
    {
        $request->validate([
            'email'    => 'required|email',
            'password' => 'required',
        ]);

        $credentials = $request->only('email', 'password');
        $remember = $request->filled('remember'); // <--- ini kunci pentingnya!

        if (Auth::attempt($credentials, $remember)) { // <-- tambahkan $remember di sini
            $user = Auth::user();

            if (Gate::allows('admin')) {
                return redirect()->route('dashboard')->with('success', 'Berhasil login sebagai Admin'.', '. $user->name);
            } elseif (Gate::allows('user')) {
                return redirect()->route('indexuser', ['waktu' => 'sarapan'])->with('success', 'Berhasil login sebagai User'.', '. $user->name);
            }

            Auth::logout();
            return redirect()->back()->with('error', 'Role tidak dikenali');
        }

        return redirect()->back()->with('error', 'Email atau password salah');
    }


    // Menangani proses logout
    public function logout()
    {
        Auth::logout();
        return redirect('Login');
    }

    public function register(Request $request)
    {
      
        $validator = Validator::make($request->all(),[
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|min:8',
        ]);

        // Buat pengguna baru
        User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password), // Hash password
            'is_admin' => false, // Default untuk user biasa
        ]);

        // User::create($data);

        // Redirect ke halaman tertentu setelah menyimpan
        return redirect('Login')->with('success', 'Berhasil membuat akun'); // Ganti dengan rute yang sesuai
    }

}
