<?php

use App\Http\Controllers\UserController;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
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

Route::post('/user/inscription', [UserController::class, 'inscription']);
Route::post('/user/connexion', [UserController::class, 'connexion']);

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});
