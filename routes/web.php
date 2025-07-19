<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\adminController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::get('/', function () {
    return redirect()->route('login');
});

Route::get('/Login', [AuthController::class, 'login'])->name('login');
Route::post('/Login-proses', [AuthController::class, 'loginproses'])->name('loginproses');
Route::get('/Create-Account', [AuthController::class, 'indexregister'])->name('indexregister');
Route::post('/Logout', [AuthController::class, 'logout'])->name('logout');
Route::post('/register', [AuthController::class, 'register'])->name('register');

Route::middleware('auth')->group(function(){
    Route::middleware('can:admin')->group(function (){
        //dashboard
        Route::get('/Dashboard', [adminController::class, 'dashboard'])->name('dashboard');
        //makanan
        Route::get('/Data-Makanan', [adminController::class, 'makanan'])->name('makanan');
        Route::post('/Create-makanan', [adminController::class, 'storemakanan'])->name('storemakanan');
        Route::put('/Update-makanan/{id}', [adminController::class, 'updatemakanan'])->name('updatemakanan');
        Route::delete('/Delete-makanan/{id}', [adminController::class, 'destroymakanan'])->name('destroymakanan');
        //pembobotan
        Route::get('/Data-Bobot', [adminController::class, 'pembobotan'])->name('pembobotan');
        Route::post('/Create-Bobot', [adminController::class, 'createbobot'])->name('createbobot');
        Route::put('/Update-Bobot/{id}', [adminController::class, 'updatebobot'])->name('updatebobot');
        Route::delete('/Delete-Bobot/{id}', [adminController::class, 'destroybobot'])->name('destroybobot');
        //Topsis
        Route::get('/Topsis', [adminController::class, 'topsis'])->name('topsis');
        //manajemen user
        Route::get('/Manajemen-User', [adminController::class, 'usermanage'])->name('usermanage');
        Route::delete('/Delete-User/{id}', [adminController::class, 'destroyuser'])->name('destroyuser');
        //import
        Route::post('/Import-Excel', [adminController::class, 'import'])->name('import');
    });

    Route::middleware('can:user')->group(function () {
        Route::get('/Dashboard User', [UserController::class, 'indexuser'])->name('indexuser');
        Route::post('/create-data', [UserController::class, 'store'])->name('store');
        Route::post('/update-data/{id}', [UserController::class, 'update'])->name('update');
        Route::get('/Riwayat Makanan', [UserController::class, 'riwayat'])->name('riwayat');
        Route::post('/create-riwayat', [UserController::class, 'storeriwayat'])->name('storeriwayat');

    });
});
