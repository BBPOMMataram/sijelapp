<?php

use App\Http\Controllers\DashboardController;
use App\Http\Controllers\DetailTerimaSampelController;
use App\Http\Controllers\FrontController;
use App\Http\Controllers\KategoriController;
use App\Http\Controllers\LaporanController;
use App\Http\Controllers\MetodeUjiController;
use App\Http\Controllers\ParameterUjiController;
use App\Http\Controllers\PemilikSampelController;
use App\Http\Controllers\TerimaSampelController;
use App\Http\Controllers\TrackingSampelController;
use Illuminate\Routing\RouteGroup;
use Illuminate\Support\Facades\Auth;
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

Route::middleware(['auth'])->group(function () {
    Route::prefix('admin')->group(function () {
        Route::get('/', [DashboardController::class, 'index'])->name('dashboard');
        Route::prefix('master')->group(function () {
            //pemilik sampel
            Route::resources([
                'pemiliksampel' => PemilikSampelController::class,
                'kategori' => KategoriController::class,
                'metodeuji' => MetodeUjiController::class,
                'parameteruji' => ParameterUjiController::class,
            ]);
            Route::get('dtpemiliksampel', [PemilikSampelController::class, 'dtpemiliksampel'])->name('dtpemiliksampel');
            Route::get('dtkategori', [KategoriController::class, 'dtkategori'])->name('dtkategori');
            Route::get('dtmetodeuji', [MetodeUjiController::class, 'dtmetodeuji'])->name('dtmetodeuji');
            Route::get('dtparameteruji', [ParameterUjiController::class, 'dtparameteruji'])->name('dtparameteruji');
        });
        //terimasampel
        Route::resource('terimasampel', TerimaSampelController::class);
        Route::get('dtterimasampel', [TerimaSampelController::class, 'dtterimasampel'])->name('dtterimasampel');
        //detailterimasampel
        Route::get('detailterimasampel/{idProdukSampel}', [DetailTerimaSampelController::class, 'index'])->name('detailterimasampel.index');
        Route::match(['put', 'patch'], 'detailterimasampel/{idProdukSampel}', [DetailTerimaSampelController::class, 'update'])->name('detailterimasampel.update');
        Route::delete('detailterimasampel/{idProdukSampel}', [DetailTerimaSampelController::class, 'destroy'])->name('detailterimasampel.destroy');
        Route::post('detailterimasampel/{idPermintaan}', [DetailTerimaSampelController::class, 'store'])->name('detailterimasampel.store');

        Route::delete('listparameterdetailterimasampel/{id}', [DetailTerimaSampelController::class, 'deleteparameteruji'])->name('deleteparameteruji');
        Route::post('listparameterdetailterimasampel/{id}', [DetailTerimaSampelController::class, 'storeparameteruji'])->name('storeparameteruji');
        //data parameter per produksampel for update list parameter
        Route::get('listparameterdetailterimasampel/{id}', [DetailTerimaSampelController::class, 'datadetailparameteruji'])->name('datadetailparameteruji');

        Route::get('statussampel', [TrackingSampelController::class, 'index'])->name('statussampel.index');
        Route::post('statussampel/{id}', [TrackingSampelController::class, 'nextstep'])->name('statussampel.nextstep');
        Route::get('dtstatussampel', [TrackingSampelController::class, 'dtstatussampel'])->name('dtstatussampel');
        Route::get('liststatussampel', [TrackingSampelController::class, 'liststatussampel'])->name('liststatussampel');
        Route::get('sampelselesai', [TrackingSampelController::class, 'sampelselesai'])->name('sampelselesai');
        Route::get('dtsampelselesai', [TrackingSampelController::class, 'dtsampelselesai'])->name('dtsampelselesai');

        // print
        Route::get('printkajiulang/{idProdukSampel}', [DetailTerimaSampelController::class, 'printkajiulang'])->name('print.kajiulang');
        Route::get('printfplp/{idProdukSampel}', [DetailTerimaSampelController::class, 'printfplp'])->name('print.fplp');

        // report
        Route::prefix('laporan')->group(function () {
            Route::get('/jumlahsampel', [LaporanController::class, 'jumlahsampel'])->name('laporan.jumlahsampel');
            Route::get('rekapsampel', [LaporanController::class, 'rekapsampel'])->name('laporan.rekapsampel');
            Route::get('dtrepaksampel', [LaporanController::class, 'dtrekapsampel'])->name('dtrekapsampel');
    });
    });
    Route::get('logout', function(){
        Auth::logout();
        return redirect()->route('login');
    })->name('logout');
});

Auth::routes();

Route::match(['get', 'post'], 'register', function () {
    abort(404);
});

Route::match(['get', 'post'], 'password/reset', function () {
    abort(404);
});

Route::get('dtdetailterimasampel/{idProdukSampel}', [DetailTerimaSampelController::class, 'dtdetailterimasampel'])->name('dtdetailterimasampel');
Route::get('dttrackingsampel/{id}', [FrontController::class, 'dttrackingsampel'])->name('dttrackingsampel');

Route::post('submittandaterima/{id}', [FrontController::class, 'submittandaterima'])->name('submittandaterima');
// Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');
