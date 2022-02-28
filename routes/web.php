<?php

use Illuminate\Support\Facades\DB;
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

Route::get('/', function () {
    return view('welcome');
});

Route::match(['get', 'post'], '/data/search', [\App\Http\Controllers\SearchController::class, 'search'])->name('search');

Auth::routes([
    'register' => false
]);

Route::get('/test-connection', function () {
    try {
        DB::connection('sqlsrv')->getPdo();
        return array('tes' => 'success');
    } catch (\Exception $e) {
        return array('tes' => 'error', 'msg' => $e);
    }
})->middleware('auth');

Route::get('admin/get-skpk-data', [\App\Http\Controllers\SimdaController::class, 'getSkpk'])->name('admin.getSkpk')
    ->middleware(['auth', 'role:admin']);

Route::get('profile/username', [\App\Http\Controllers\ProfileController::class, 'index'])->name('profile.index')
    ->middleware('auth');

Route::post('profile/upload', [\App\Http\Controllers\ProfileController::class, 'uploadFoto'])->name('profile.upload')
    ->middleware(['auth']);

Route::post('profile/updateUser', [\App\Http\Controllers\ProfileController::class, 'updateUser'])->name('profile.updateUser')
    ->middleware('auth');

Route::post('profile/store', [\App\Http\Controllers\ProfileController::class, 'store'])->name('profile.store')
    ->middleware('auth');

Route::get('profile/change-password', [\App\Http\Controllers\ProfileController::class, 'changePasswordView'])->name('profile.change-password-view')
    ->middleware('auth');

Route::post('profile/change-password', [\App\Http\Controllers\ProfileController::class, 'changePassword'])->name('profile.change-password')
    ->middleware('auth');

// Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');
Route::get('/admin/agenda/cetak/{id}', [App\Http\Controllers\AgendaController::class, 'cetak'])->name('agenda.cetak')
    ->middleware(['auth', 'profile', 'role:front-office']);

Route::put('/admin/agenda/mark', [App\Http\Controllers\AgendaController::class, 'mark'])->name('agenda.mark')
    ->middleware(['auth', 'profile', 'role:front-office']);

Route::get('/admin/agenda/list', [App\Http\Controllers\AgendaController::class, 'listAgenda'])->name('agenda.list')
    ->middleware(['auth', 'profile', 'role:front-office']);

Route::resource('/admin/agenda', App\Http\Controllers\AgendaController::class)
    ->middleware(['auth', 'profile', 'role:front-office']);

Route::get('/admin/laporan/register', [App\Http\Controllers\LaporanController::class, 'index'])->name('laporan.register')
    ->middleware('auth');

Route::get('/admin/laporan/register/cetak', [App\Http\Controllers\LaporanController::class, 'cetakRegister'])->name('laporan.register.cetak')
    ->middleware('auth');

Route::get('/simda/spm/all/{oldSpm?}', [App\Http\Controllers\SimdaController::class, 'spm_all'])->name('spm_all')
    ->where('oldSpm', '(.*)')
    ->middleware(['auth', 'profile']);

Route::resource('admin/user', App\Http\Controllers\UserController::class)
    ->middleware(['auth', 'profile', 'role:admin']);

Route::get('/admin/verifikasi', [App\Http\Controllers\VerifikasiContoller::class, 'index'])->name('verifikasi.index')
    ->middleware(['auth', 'profile', 'role:verifikator-belanja-daerah|verifikator-penatausahaan']);

Route::get('/admin/verifikasi/list/{id}', [App\Http\Controllers\VerifikasiContoller::class, 'show'])->name('verifikasi.show')
    ->middleware(['auth', 'profile', 'role:verifikator-belanja-daerah|verifikator-penatausahaan']);

Route::get('/admin/verifikasi/{id}/create', [App\Http\Controllers\VerifikasiContoller::class, 'create'])->name('verifikasi.create')
    ->middleware(['auth', 'profile', 'role:verifikator-belanja-daerah|verifikator-penatausahaan']);

Route::post('/admin/verifikasi/{id}/store', [App\Http\Controllers\VerifikasiContoller::class, 'store'])->name('verifikasi.store')
    ->middleware(['auth', 'profile', 'role:verifikator-belanja-daerah|verifikator-penatausahaan']);

Route::delete('/admin/verifikasi/{id}', [App\Http\Controllers\VerifikasiContoller::class, 'destroy'])->name('verifikasi.destroy')
    ->middleware(['auth', 'profile', 'role:verifikator-belanja-daerah|verifikator-penatausahaan']);

Route::put('/admin/verifikasi/mark', [App\Http\Controllers\VerifikasiContoller::class, 'mark'])->name('verifikasi.mark')
    ->middleware(['auth', 'profile', 'role:verifikator-belanja-daerah|verifikator-penatausahaan']);

Route::get('/admin/verifikasi/list', [App\Http\Controllers\VerifikasiContoller::class, 'listVerifikasi'])->name('verifikasi.list')
    ->middleware(['auth', 'profile', 'role:verifikator-belanja-daerah|verifikator-penatausahaan']);

Route::get('/admin/pengelola', [App\Http\Controllers\PengelolaController::class, 'index'])->name('pengelola.index')
    ->middleware(['auth', 'profile', 'role:pengelola']);

Route::get('/admin/pengelola/{id}/create', [App\Http\Controllers\PengelolaController::class, 'create'])->name('pengelola.create')
    ->middleware(['auth', 'profile', 'role:pengelola']);

Route::post('/admin/pengelola/{id}/store', [App\Http\Controllers\PengelolaController::class, 'store'])->name('pengelola.store')
    ->middleware(['auth', 'profile', 'role:pengelola']);

Route::delete('/admin/pengelola/hapus-catatan/{id}', [App\Http\Controllers\PengelolaController::class, 'hapusCatatan'])->name('pengelola.hapusCatatan')
    ->middleware(['auth', 'profile', 'role:pengelola']);

Route::post('/admin/pengelola/update-spm', [App\Http\Controllers\PengelolaController::class, 'updateSpm'])->name('pengelola.updateSpm')
    ->middleware(['auth', 'profile', 'role:pengelola']);

Route::put('/admin/pengelola/mark', [App\Http\Controllers\PengelolaController::class, 'mark'])->name('pengelola.mark')
    ->middleware(['auth', 'profile', 'role:pengelola']);

Route::get('/admin/pengelola/list', [App\Http\Controllers\PengelolaController::class, 'listPengelola'])->name('pengelola.list')
    ->middleware(['auth', 'profile', 'role:pengelola']);

Route::get('/admin/pengelola/show/{id}', [App\Http\Controllers\PengelolaController::class, 'show'])->name('pengelola.show')
    ->middleware(['auth', 'profile', 'role:pengelola']);

Route::get('/admin/bud', [App\Http\Controllers\BudController::class, 'index'])->name('bud.index')
    ->middleware(['auth', 'profile', 'role:bud|kuasa-bud']);

Route::get('/admin/bud/{id}/create', [App\Http\Controllers\BudController::class, 'create'])->name('bud.create')
    ->middleware(['auth', 'profile', 'role:bud|kuasa-bud']);

Route::post('/admin/bud/{id}/store', [App\Http\Controllers\BudController::class, 'store'])->name('bud.store')
    ->middleware(['auth', 'profile', 'role:bud|kuasa-bud']);

Route::delete('/admin/bud/hapus-catatan/{id}', [App\Http\Controllers\BudController::class, 'hapusCatatan'])->name('bud.hapusCatatan')
    ->middleware(['auth', 'profile', 'role:bud|kuasa-bud']);

Route::post('/admin/bud/update-spm', [App\Http\Controllers\BudController::class, 'updateSpm'])->name('bud.updateSpm')
    ->middleware(['auth', 'profile', 'role:bud|kuasa-bud']);

Route::get('/admin/bud/{id}/show', [App\Http\Controllers\BudController::class, 'show'])->name('bud.show')
    ->middleware(['auth', 'profile', 'role:bud|kuasa-bud']);

Route::delete('/admin/bud/{id}', [App\Http\Controllers\BudController::class, 'destroy'])->name('bud.destroy')
    ->middleware(['auth', 'profile', 'role:bud|kuasa-bud']);

Route::put('/admin/bud/mark', [App\Http\Controllers\BudController::class, 'mark'])->name('bud.mark')
    ->middleware(['auth', 'profile', 'role:bud|kuasa-bud']);

Route::get('/admin/bud/list', [App\Http\Controllers\BudController::class, 'listBud'])->name('bud.list')
    ->middleware(['auth', 'profile', 'role:bud|kuasa-bud']);

Route::get('/admin/dashboard', [App\Http\Controllers\DashboardController::class, 'index'])->name('dashboard.index')
    ->middleware(['auth', 'profile']);

Route::get('/admin/updateBox', [App\Http\Controllers\DashboardController::class, 'updateBox'])->name('dashboard.updateBox')
    ->middleware(['auth', 'profile']);

Route::get('/timeline/{kode}', [App\Http\Controllers\DashboardController::class, 'timeline'])->name('dashboard.timeline');
Route::get('/kode/{kode}', [App\Http\Controllers\DashboardController::class, 'kode'])->name('dashboard.kode');

Route::get('admin/sp2d', [\App\Http\Controllers\SimdaController::class, 'sp2dAll'])->name('admin.sp2d')
    ->middleware('auth');
