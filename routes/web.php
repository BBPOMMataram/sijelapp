<?php

use App\Http\Controllers\BiayaSampelController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\DetailTerimaSampelController;
use App\Http\Controllers\FrontController;
use App\Http\Controllers\KategoriController;
use App\Http\Controllers\LaporanController;
use App\Http\Controllers\MetodeUjiController;
use App\Http\Controllers\ParameterUjiController;
use App\Http\Controllers\PemilikSampelController;
use App\Http\Controllers\Pengaturan\ProfilController;
use App\Http\Controllers\PerihalSuratController;
use App\Http\Controllers\StatusUjiController;
use App\Http\Controllers\TerimaSampelController;
use App\Http\Controllers\TrackingSampelController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\Wadah1Controller;
use App\Http\Controllers\Wadah2Controller;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Storage;

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
Route::get('downloadlhu/{lhu}', function($lhu){
    return Storage::download($lhu);
})->where('lhu', '.*')
->name('download.lhu');

Route::middleware(['auth'])->group(function () {
    Route::prefix('admin')->group(function () {
        Route::get('/', [DashboardController::class, 'index'])->name('dashboard');
        Route::prefix('master')->group(function () {
            Route::resources([
                'pemiliksampel' => PemilikSampelController::class,
                'kategori' => KategoriController::class,
                'metodeuji' => MetodeUjiController::class,
                'parameteruji' => ParameterUjiController::class,
                'statusuji' => StatusUjiController::class,
                'biayauji' => BiayaSampelController::class,
                'usermanagement' => UserController::class,
                'wadah1' => Wadah1Controller::class,
                'wadah2' => Wadah2Controller::class,
                'perihalsurat' => PerihalSuratController::class,
            ]);
            Route::put('changephoto/{id}', [UserController::class, 'changephoto'])->name('usermanagement.changephoto');
            Route::put('resetpwd/{id}', [UserController::class, 'resetpwd'])->name('usermanagement.resetpwd');
            Route::get('dtpemiliksampel', [PemilikSampelController::class, 'dtpemiliksampel'])->name('dtpemiliksampel');
            Route::get('dtkategori', [KategoriController::class, 'dtkategori'])->name('dtkategori');
            Route::get('dtmetodeuji', [MetodeUjiController::class, 'dtmetodeuji'])->name('dtmetodeuji');
            Route::get('dtparameteruji', [ParameterUjiController::class, 'dtparameteruji'])->name('dtparameteruji');
        });
        Route::resource('terimasampel', TerimaSampelController::class);
        Route::get('dtterimasampel', [TerimaSampelController::class, 'dtterimasampel'])->name('dtterimasampel');
        Route::get('detailterimasampel/{idProdukSampel}', [DetailTerimaSampelController::class, 'index'])->name('detailterimasampel.index');
        Route::match(['put', 'patch'], 'detailterimasampel/{idProdukSampel}', [DetailTerimaSampelController::class, 'update'])->name('detailterimasampel.update');
        Route::delete('detailterimasampel/{idProdukSampel}', [DetailTerimaSampelController::class, 'destroy'])->name('detailterimasampel.destroy');
        Route::post('detailterimasampel', [DetailTerimaSampelController::class, 'store'])->name('detailterimasampel.store');

        Route::get('lastnourut/{idkategori}', [TerimaSampelController::class, 'lastnourut'])->name('lastnourut');

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
        Route::post('cancelstatussampel/{id}', [TrackingSampelController::class, 'cancelstep'])->name('statussampel.cancelstep');

        Route::get('dtstatusuji', [StatusUjiController::class, 'dtstatusuji'])->name('dtstatusuji');

        // print
        Route::get('printkajiulang/{idpermintaan}', [DetailTerimaSampelController::class, 'printkajiulang'])->name('print.kajiulang');
        Route::get('printfplp/{idpermintaan}', [DetailTerimaSampelController::class, 'printfplp'])->name('print.fplp');
        Route::get('printbasegel/{idproduksampel}', [DetailTerimaSampelController::class, 'printbasegel'])->name('print.basegel');
        Route::get('printbapenimbangan/{idproduksampel}', [DetailTerimaSampelController::class, 'printbapenimbangan'])->name('print.bapenimbangan');

        // report
        Route::prefix('laporan')->group(function () {
            Route::get('jumlahsampel', [LaporanController::class, 'jumlahsampel'])->name('laporan.jumlahsampel');
            Route::get('dtjumlahsampel/{tahun}', [LaporanController::class, 'dtjumlahsampel'])->name('dtjumlahsampel');
            Route::get('rekapsampel', [LaporanController::class, 'rekapsampel'])->name('laporan.rekapsampel');
            Route::get('dtrekapsampel', [LaporanController::class, 'dtrekapsampel'])->name('dtrekapsampel');
        });

        Route::prefix('setting')->group(function(){
            Route::get('profil', [ProfilController::class, 'index'])->name('setting.profil');
        });

        Route::post('changepwd', [ProfilController::class, 'changepwd'])->name('changepwd');
    });
    Route::get('logout', function () {
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

// tracking sampel
Route::get('dtdetailterimasampel/{idProdukSampel}', [DetailTerimaSampelController::class, 'dtdetailterimasampel'])->name('dtdetailterimasampel');
Route::get('dttrackingsampel/{id}', [FrontController::class, 'dttrackingsampel'])->name('dttrackingsampel');

Route::post('submittandaterima/{id}', [FrontController::class, 'submittandaterima'])->name('submittandaterima');

//biaya sampel
Route::get('dtbiayauji', [BiayaSampelController::class, 'dtbiayauji'])->name('dtbiayauji');
Route::get('dtjenissampel', [BiayaSampelController::class, 'dtjenissampel'])->name('dtjenissampel');

Route::get('dthargaproduk/{id?}', [BiayaSampelController::class, 'dthargaproduk'])->name('dthargaproduk');

Route::get('/storagelink', function () {
    Artisan::call('storage:link');
});
