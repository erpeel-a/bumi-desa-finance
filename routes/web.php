<?php

use App\Http\Controllers\Auth\AuthController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\UnitController;
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
    return redirect()->route('dashboard');
});

Route::get('login', [AuthController::class, 'login'])->name('login');
Route::post('login', [AuthController::class, 'processLogin'])->name('process.login');
Route::post('logout', [AuthController::class, 'logout'])->name('logout');

Route::group(['middleware' => ['auth']], function () {
    Route::get('dashboard', [DashboardController::class, 'index'])->name('dashboard');
    Route::resource('units', UnitController::class)->only(['index', 'store', 'destroy']);
    Route::post('units/detail', [UnitController::class, 'show'])->name('show.units'); // using post

    Route::prefix('unit')->group(function () {
        Route::get('{unit:slug}', [UnitController::class, 'unit'])->name('unit.index');
        Route::get('{unit:slug}/create', [UnitController::class, 'unitCreate'])->name('unit.create');
        Route::post('{unit:slug}', [UnitController::class, 'unitStore'])->name('unit.store');
        Route::get('{unit:slug}/{id}', [UnitController::class, 'unitEdit'])->name('unit.edit');
        Route::put('{unit:slug}/{id}', [UnitController::class, 'unitUpdate'])->name('unit.update');
    });
});