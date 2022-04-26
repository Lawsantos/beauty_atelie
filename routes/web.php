<?php

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

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth'])->name('dashboard');

require __DIR__.'/auth.php';

Route::group([ 'prefix' => 'clients', 'middleware' => 'auth'],function (){
    Route::get('', [\App\Http\Controllers\ClientController::class, 'index'])->name('clients.index');
    Route::get('{client}/reserve', [\App\Http\Controllers\ClientController::class, 'show'])->name('clients.show');
    Route::get('create', [\App\Http\Controllers\ClientController::class, 'create'])->name('clients.create');
    Route::post('', [\App\Http\Controllers\ClientController::class,'store'])->name('clients.store');
    Route::get('{client}', [\App\Http\Controllers\ClientController::class, 'edit'])->name('clients.edit');
    Route::post('{client}', [\App\Http\Controllers\ClientController::class, 'update'])->name('clients.update');
    Route::delete('{client}', [\App\Http\Controllers\ClientController::class, 'destroy'])->name('clients.destroy');
});

Route::group([ 'prefix' => 'reserves', 'middleware' => 'auth'],function () {
    Route::get('', [\App\Http\Controllers\ReserveController::class, 'index'])->name('reserves.index');
    Route::get('create/{client}', [\App\Http\Controllers\ReserveController::class,'create'])->name('reserves.create');
    Route::post('{client}', [\App\Http\Controllers\ReserveController::class, 'store'])->name('reserves.store');
    Route::get('{reserve}', [\App\Http\Controllers\ReserveController::class,'edit'])->name('reserves.edit');
    Route::post('{reserve}', [\App\Http\Controllers\ReserveController::class, 'update'])->name('reserves.update');
    Route::delete('{reserve}', [\App\Http\Controllers\ReserveController::class, 'destroy'])->name('reserves.destroy');
});
