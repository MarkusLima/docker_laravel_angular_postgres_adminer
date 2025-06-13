<?php

use App\Http\Controllers\api\GitHubController;
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

Route::middleware(['log.http'])->group(function () {
    Route::get('/user/{userName}', [GitHubController::class, 'getUser']);
    Route::get('/following/{userName}', [GitHubController::class, 'getFollowing']);
});

Route::get('/logs', [GitHubController::class, 'getLogs']);
Route::get('/logs/{id}', [GitHubController::class, 'getLogById']);
