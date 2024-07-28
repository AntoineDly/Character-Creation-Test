<?php

declare(strict_types=1);

use App\Categories\Controllers\AssociateCategoryController;
use App\Categories\Controllers\CreateCategoryController;
use App\Categories\Controllers\GetCategoryController;
use App\Character\Controllers\CreateCharacterController;
use App\Character\Controllers\GetCharacterController;
use App\Game\Controllers\CreateGameController;
use App\Game\Controllers\GetGameController;
use App\User\Controllers\AuthenticationController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:api');

Route::post('/register', [AuthenticationController::class, 'register']);
Route::post('/login', [AuthenticationController::class, 'login']);

Route::middleware('auth:api')->group(function () {
    Route::post('/logout', [AuthenticationController::class, 'logout']);

    Route::get('/characters', [GetCharacterController::class, 'getCharacters']);
    Route::get('/characters/with_game', [GetCharacterController::class, 'getCharactersWithGame']);
    Route::get('/characters/{id}', [GetCharacterController::class, 'getCharacter']);
    Route::get('/characters/{id}/with_game', [GetCharacterController::class, 'getCharacterWithGame']);
    Route::post('/characters', [CreateCharacterController::class, 'createCharacter']);

    Route::get('/games', [GetGameController::class, 'getGames']);
    Route::get('/games/{id}', [GetGameController::class, 'getGame']);
    Route::post('/games', [CreateGameController::class, 'createGame']);

    Route::get('/categories', [GetCategoryController::class, 'getCategories']);
    Route::get('/categories/{id}', [GetCategoryController::class, 'getCategory']);
    Route::post('/categories', [CreateCategoryController::class, 'createCategory']);
    Route::post('/categories/associate_game', [AssociateCategoryController::class, 'associateGame']);
});
