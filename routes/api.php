<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\NovelController;

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

Route::post('novel/create', [NovelController::class, 'createNovel']);
Route::post('novel/update/{id}', [NovelController::class, 'updateNovel']);
Route::get('novel/get/{id}', [NovelController::class, 'getNovel']);
Route::get('novel/get', [NovelController::class, 'getAllNovel']);
Route::delete('novel/delete/{id}', [NovelController::class, 'deleteNovel']);

