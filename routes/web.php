<?php

use App\Http\Controllers\ClientController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\ReserveController;
use Illuminate\Support\Facades\Route;

Route::redirect('/', 'dashboard');

Route::get('/dashboard', DashboardController::class)->middleware(['auth'])->name('dashboard');

require __DIR__.'/auth.php';

Route::group([ 'prefix' => 'clients', 'middleware' => 'auth'], function (){
    Route::get('', [ClientController::class, 'index'])->name('clients.index');
    Route::get('{client}/reserves', [ClientController::class, 'show'])->name('clients.show');
    Route::get('create', [ClientController::class, 'create'])->name('clients.create');
    Route::post('', [ClientController::class,'store'])->name('clients.store');
    Route::get('{client}', [ClientController::class, 'edit'])->name('clients.edit');
    Route::post('{client}', [ClientController::class, 'update'])->name('clients.update');
    Route::delete('{client}', [ClientController::class, 'destroy'])->name('clients.destroy');
});

Route::group(['prefix' => 'reserves', 'middleware' => 'auth'], function () {

    Route::get('', [ReserveController::class, 'index'])->name('reserves.index');
    Route::get('create/{client}', [ReserveController::class, 'create'])->name('reserves.create');
    Route::post('{client}', [ReserveController::class,'store'])->name('reserves.store');
    Route::get('{reserve}', [ReserveController::class, 'edit'])->name('reserves.edit');
    Route::post('{reserve}', [ReserveController::class, 'update'])->name('reserves.update');
    Route::delete('{reserve}', [ReserveController::class, 'destroy'])->name('reserves.destroy');

});

Route::get('calendar', function () {
    return view('welcome');
});
