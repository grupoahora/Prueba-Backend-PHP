<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\BodegaController;

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

Route::get('/bodegas', [BodegaController::class, 'index']);

Route::post('/bodegas', [BodegaController::class, 'store']);
use App\Http\Controllers\ProductoController;

Route::get('/productos/total-desc', [ProductoController::class, 'indexTotalDesc']);

Route::post('/productos', [ProductoController::class, 'store']);
