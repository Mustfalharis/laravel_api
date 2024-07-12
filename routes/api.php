<?php

use App\Http\Controllers\Api\V1\CategoireController;
use App\Http\Controllers\Auth\AuthController;
use App\Models\Categorie;
use Illuminate\Support\Facades\Route;

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

Route::controller(AuthController::class)->group(function () {
    Route::post('login', 'login');
    Route::post('register', 'register')->middleware("sanitizeInput");
    Route::get('logout', 'logout');
    Route::get('refresh', 'refresh');
});


// Route::post('categoire',[CategoireController::class,'store'])->middleware("sanitizeInput");
// Route::put('categoire/{id}',[CategoireController::class,'update'])->middleware("sanitizeInput");

Route::prefix('v1')
    ->namespace('App\Http\Controllers\Api\V1')
    ->middleware("VerifyToken")
    ->group(function () {
        Route::get("categoire", [CategoireController::class, 'index']);
        Route::get("categoire/{id}", [CategoireController::class, 'show']);

    });
