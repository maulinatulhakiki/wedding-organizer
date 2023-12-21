<?php

use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Admin\PelangganController;
use App\Http\Controllers\Admin\PembayaranController;
use App\Http\Controllers\Admin\PemesananController;
use App\Models\Pelanggan;
use App\Models\Pemesanan;
use App\Models\Pembayaran;
use Illuminate\Support\Facades\Route;

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
    return view('auth.login'); //halaman index langsung ke login
});

// grup root untuk admin yang setiap url nya dimulai dengan admin, induk semua admin
Route::prefix('admin')->group(function (){
    //route untuk auth
    Route::group(['middleware'=>'auth'], function (){ //middleware mmebuat hak akses hanya untuk yang sudah admin
        //route untuk dashboard
        //pakai get karena tidak ada manipulasi data, name itu untuk memudahkan pemanggilan route di template html view
        Route::get('/dashboard', [DashboardController::class,'index'])->name('admin.dashboard.index'); 
        //route untuk pelanggan
        Route::resource('/pelanggan', PelangganController::class,['as'=>'admin']);
        //route untuk pembayaran
        Route::resource('/pembayaran', PembayaranController::class,['as'=>'admin']);
        //route untuk pembayaran
        Route::resource('/pemesanan', PemesananController::class,['as'=>'admin']);
       
    });

});