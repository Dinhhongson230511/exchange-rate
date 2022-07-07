<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ExchangeRate\ExchangeRateController;
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

Route::prefix('exchange-rate')->group(function () {
    Route::get('/', [ExchangeRateController::class, 'index']);
    Route::get('/get-rate', [ExchangeRateController::class, 'exchangeRate']);
});
