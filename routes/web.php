<?php

use App\Http\Controllers\ConcessionController;
use App\Http\Controllers\KitchenController;
use App\Http\Controllers\OrderController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('navBar');
});

Route::resource('concessions', ConcessionController::class);
Route::resource('orders', OrderController::class)->except(['edit', 'update']);
Route::get('kitchen', [KitchenController::class, 'index'])->name('kitchen.index');
Route::post('kitchen/send/{id}', [KitchenController::class, 'sendToKitchen'])->name('kitchen.send');
Route::post('kitchen/status/{id}', [KitchenController::class, 'updateStatus'])->name('kitchen.updateStatus');
