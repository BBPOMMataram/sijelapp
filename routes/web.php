<?php

use App\Http\Controllers\DashboardController;
use App\Http\Controllers\FrontController;
use App\Http\Controllers\PemilikSampelController;
use Illuminate\Support\Facades\Route;

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

Route::get('/', [FrontController::class, 'trackingsampel'])->name('home');
Route::get('/tarif', [FrontController::class, 'tarifpengujian'])->name('tarifpengujian');

// Route::middleware(['auth'])->group(function () {
    Route::get('admin', function () {
        return view('admin.index');
    });
    Route::prefix('admin')->group(function () {
        Route::get('/', [DashboardController::class, 'index'])->name('dashboard');
        Route::prefix('master')->group(function () {
            Route::resource('pemiliksampel', PemilikSampelController::class);
            Route::get('dtpemiliksampel', [PemilikSampelController::class, 'dtpemiliksampel'])->name('dtpemiliksampel');
        });
    });
// });