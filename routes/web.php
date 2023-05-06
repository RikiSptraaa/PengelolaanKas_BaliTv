<?php

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\auth\LoginController;
use App\Http\Controllers\auth\LogoutController;
use App\Http\Controllers\auth\RegisterController;
use App\Http\Controllers\auth\AuthenticateController;
use App\Http\Controllers\OutgoingCashController;
use App\Http\Controllers\IncomingCashController;
use App\Http\Controllers\ReportController;
use App\Http\Controllers\UsersController;
use App\Models\IncomingCash;

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

Route::get('/', function () {
    return redirect(route('home'));
});


// Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home')->middleware('auth');

// Auth::routes();

Route::post('/logout', LogoutController::class)->name('logout')->middleware('auth');
Route::group(['middleware' => 'guest'], function () {
    Route::get('/login', LoginController::class)->name('login');
    Route::post('/login', AuthenticateController::class)->name('auth');
    Route::get('/register', [RegisterController::class, 'index']);
    Route::post('/register', [RegisterController::class, 'store'])->name('register');
});

Route::group(['middleware' => 'auth'], function () {
    Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');
    Route::resource('/users', UsersController::class)->middleware('SuperAdmin');

    Route::get('/pengeluaran-kas/cetak', [OutgoingCashController::class, 'print'])->name('pengeluaran-kas.print');
    Route::resource('/pengeluaran-kas', OutgoingCashController::class);


    Route::get('/penerimaan-kas/cetak', [IncomingCashController::class, 'print'])->name('penerimaan-kas.print');
    Route::resource('/penerimaan-kas', IncomingCashController::class);

    Route::get('/laporan/neraca', [ReportController::class, 'index_neraca']);
    Route::post('/laporan/neraca', [ReportController::class, 'show_neraca']);
    Route::get('/laporan/neraca/cetak', [ReportController::class, 'print_neraca']);

    Route::get('/laporan/perubahan-equitas', [ReportController::class, 'index_equity']);
    Route::post('/laporan/perubahan-equitas', [ReportController::class, 'show_equity']);
    Route::get('/laporan/perubahan-equitas/cetak', [ReportController::class, 'print_equity']);

    Route::get('/laporan/laba', [ReportController::class, 'index']);
    Route::post('/laporan/laba', [ReportController::class, 'show']);
    Route::get('/laporan/laba/cetak', [ReportController::class, 'printLaba']);

    Route::get("/download/{file}", function ($file) {
        dd($file);
        // return 
    });
    

});
