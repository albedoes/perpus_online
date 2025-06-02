<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;
use App\Models\Buku;
use App\Http\Controllers\BukuController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\Auth\LoginController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

// Route untuk menampilkan daftar hewan
Route::get('/', function () {
    $buku = Buku::all();
    return view('buku', compact('buku'));
})->name('buku');
Route::get('/buku/{id}/baca', [BukuController::class, 'baca'])->name('buku.baca');


// Route untuk login dan logout
Route::get('/login', [LoginController::class, 'showLoginForm'])->name('login');
Route::post('/login', [LoginController::class, 'login']);
Route::post('/logout', [LoginController::class, 'logout'])->name('logout');

// Route dengan middleware auth (hanya untuk pengguna yang sudah login)
Route::middleware('auth')->group(function () {

    // Dashboard admin
    Route::get('/dashboard', [AdminController::class, 'dashboard'])->name('admin.dashboard');

    // Route untuk hewan (AnimalController)
    Route::get('/create', [BukuController::class, 'create'])->name('admin.create');
    Route::post('/store', [BukuController::class, 'store'])->name('admin.store');
    Route::get('/edit/{id}', [BukuController::class, 'edit'])->name('admin.edit');
    Route::put('/update/{id}', [BukuController::class, 'update'])->name('admin.update');
    Route::delete('/destroy/{id}', [BukuController::class, 'destroy'])->name('admin.destroy');
});