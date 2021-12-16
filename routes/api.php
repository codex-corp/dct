<?php

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


# API routes for register
Route::post('/register', [\App\Http\Controllers\AuthController::class, 'register']);

# API routes for login
/**
 * {
    "success": true,
    "data": {
        "access_token": "**",
        "token_type": "Bearer"
    },
    "message": "Hi admin, Welcome to DCT support center!"
    }
 */
Route::post('/login', [\App\Http\Controllers\AuthController::class, 'login'])->name('login');

Route::group(['middleware' => ['auth:sanctum']], function () {

    Route::post('questions', [\App\Http\Controllers\QuestionsController::class, 'createQuestion']);

    Route::get('questions', [\App\Http\Controllers\QuestionsController::class, 'listQuestions']);

    Route::get('questions/{id}', [\App\Http\Controllers\QuestionsController::class, 'getQuestion']);

    Route::put('questions/{id}', [\App\Http\Controllers\QuestionsController::class, 'updateQuestion']);

    # API routes for logout
    Route::post('/logout', [App\Http\Controllers\AuthController::class, 'logout']);
});

//Route::apiResource('questions', questions::class);

//Route::get('/questions', function () {
//
//})->middleware(['auth:sanctum', 'ability:check-questions,create-questions']);
