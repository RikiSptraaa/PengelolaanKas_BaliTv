<?php

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\auth\LoginController;
use App\Http\Controllers\auth\LogoutController;
use App\Http\Controllers\auth\RegisterController;
use App\Http\Controllers\auth\AuthenticateController;
use App\Http\Controllers\OutgoingCashController;
use App\Http\Controllers\IncomingCashController;
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
    return view('welcome');
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
    Route::resource('/pengeluaran-kas', OutgoingCashController::class);
    Route::resource('/penerimaan-kas', IncomingCashController::class);
});
