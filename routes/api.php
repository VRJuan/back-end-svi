<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UsuarioController;
use App\Http\Controllers\CargoController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\ProductoController;

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

// Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
//     return $request->user();
// });
Route::post('auth/registrar', [AuthController::class, 'crearUsuario']);
Route::post('auth/iniciarsesion', [AuthController::class, 'loginUsuario']);
Route::resource('productos', ProductoController::class);

Route::middleware(['auth:sanctum'])->group(function () {
    Route::resource('usuarios', UsuarioController::class);
    Route::resource('cargos', CargoController::class);
    Route::get('todoslosusuarios', [UsuarioController::class, 'TodosLosUsuarios']);
    Route::get('usuariosporcargo', [UsuarioController::class, 'UsuariosPorCargo']);
    Route::get('auth/cerrarsesion', [AuthController::class, 'cerrarSesionUsuario']);
});


// Route::resource('Auth', AuthController::class);
