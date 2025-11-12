<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\BodegaController;
use App\Http\Controllers\ProductoController;
use App\Http\Controllers\InventarioController;
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


Route::get('/productos/total-desc', [ProductoController::class, 'indexTotalDesc']);

Route::post('/productos', [ProductoController::class, 'store']);

Route::post('/inventarios', [InventarioController::class, 'store']);

Route::post('/inventarios/transfer', [InventarioController::class, 'transfer']);
