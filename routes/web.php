<?php

use App\Http\Controllers\OrderController;

Route::get('/', function () {
    return redirect()->route('orders.index');
});

Route::resource('orders', OrderController::class);

// Tambahkan ini untuk fitur export CSV
Route::get('/orders/export/csv', [OrderController::class, 'exportCsv'])->name('orders.export.csv');

