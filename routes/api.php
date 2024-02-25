<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UsuarioController;
use App\Http\Controllers\CargoController;
use App\Http\Controllers\AuthController;




/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

Route::resource('usuarios', UsuarioController::class);
Route::resource('cargos', CargoController::class);
Route::get('todoslosusuarios', [UsuarioController::class, 'TodosLosUsuarios']);
Route::get('usuariosporcargo', [UsuarioController::class, 'UsuariosPorCargo']);

// Route::resource('Auth', AuthController::class);
