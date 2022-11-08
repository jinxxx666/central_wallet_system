<?php

use App\Http\Controllers\BalanceController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

Route::get('/balance', [BalanceController::class, 'show']);
Route::put('/balance', [BalanceController::class, 'cash_in']);
Route::put('/balance', [BalanceController::class, 'debit']);
