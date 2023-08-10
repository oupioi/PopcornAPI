<?php

use App\Http\Controllers\UserController;
use App\Http\Controllers\HistoryController;
use App\Http\Controllers\LikeController;
use App\Http\Controllers\FriendsController;
use App\Models\History;
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
Route::post('/user/deconnexion', [UserController::class, 'deconnexion']);



Route::group(['middleware' => ['auth:sanctum']], function () {
    Route::get('/user/historique', [HistoryController::class, 'index']);
    Route::post('/user/historique', [HistoryController::class, 'store']);
    Route::get('/user/historique/{id}', [HistoryController::class, 'show']);
    Route::get('/user/like/{id}', [LikeController::class, 'index']);
    Route::get('/user/friend', [FriendsController::class, 'allFriends']);
    Route::post('/user/friend', [FriendsController::class, 'addFriend']);
});

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});
