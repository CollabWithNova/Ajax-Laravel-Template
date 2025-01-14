<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\auditeeController;
use App\Http\Controllers\JenisKegiatanController;
use App\Http\Controllers\positionController;

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
    return redirect('login');
});
Auth::routes();

Route::get('/home', function() {
    return redirect('login');
});
Route::middleware(['auth', 'user-access:user'])->group(function () {
    Route::get('/home', [HomeController::class, 'index'])->name('home');
});
Route::middleware(['auth', 'user-access:admin'])->group(function () {
    Route::get('/admin/home', [HomeController::class, 'adminHome'])->name('admin.home');
});
Route::middleware(['auth', 'user-access:manager'])->group(function () {
    Route::get('/manager/home', [HomeController::class, 'managerHome'])->name('manager.home');
});

Route::prefix('admin')->group(function() {
    Route::get('/', [auditeeController::class, 'index'])->name('admin.audite');
    Route::get('dataTables', [auditeeController::class, 'Datatable'])->name('admin.Datatable');
    Route::post('store', [auditeeController::class, 'store'])->name('admin.store');
    Route::get('edit/{id?}', [auditeeController::class, 'edit'])->name('admin.edit');
    Route::put('update/{id?}', [auditeeController::class, 'update'])->name('admin.update');
    Route::delete('destroy/{id?}', [auditeeController::class, 'destroy'])->name('admin.delete');
});

Route::prefix('kegiatan')->group(function() {
    Route::get('/', [JenisKegiatanController::class, 'index'])->name('kegiatan.index');
    Route::get('dataTables', [JenisKegiatanController::class, 'Datatable'])->name('kegiatan.Datatable');
    Route::post('store', [JenisKegiatanController::class, 'store'])->name('kegiatan.store');
    Route::get('edit/{id?}', [JenisKegiatanController::class, 'edit'])->name('kegiatan.edit');
    Route::put('update/{id?}', [JenisKegiatanController::class, 'update'])->name('kegiatan.update');
    Route::delete('destroy/{id?}', [JenisKegiatanController::class, 'destroy'])->name('kegiatan.delete');
});

Route::prefix('position')->group(function() {
    Route::get('/', [positionController::class, 'index'])->name('position.index');
    Route::get('dataTables', [positionController::class, 'Datatable'])->name('position.Datatable');
    Route::post('store', [positionController::class, 'store'])->name('position.store');
    Route::get('edit/{id?}', [positionController::class, 'edit'])->name('position.edit');
    Route::put('update/{id?}', [positionController::class, 'update'])->name('position.update');
    Route::delete('destroy/{id?}', [positionController::class, 'destroy'])->name('position.delete');
});


// Route::prefix('admin')->group(function() {
//     Route::get('/', [StaffController::class, 'index'])->name('admin');
// });