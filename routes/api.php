<?php

use App\Http\Controllers\API\AlmacenController;
use App\Http\Controllers\API\EntradaController;
use App\Http\Controllers\API\InstitucionController;
use App\Http\Controllers\API\ProductoController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\RoleController;

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

Route::post('register', [AuthController::class, 'register']);
Route::post('login', [AuthController::class, 'login']);

Route::middleware(['auth:sanctum'])->group(function () {
    // Logout de la aplicacion
    Route::post('logout', [AuthController::class, 'logout']);
    // Perfil del Usuario logeado
    Route::get('/user/profile',[AuthController::class, 'userProfile']);

    // Api Roles

    // Api Institucion
    Route::apiResource('instituciones', InstitucionController::class);
    // Api Almacenes
    Route::apiResource('almacenes', AlmacenController::class);
    // Api productos
    Route::apiResource('productos', ProductoController::class);
    // Api entradas
    Route::apiResource('entradas', EntradaController::class);
    
});

