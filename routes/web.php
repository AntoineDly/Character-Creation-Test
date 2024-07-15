<?php

declare(strict_types=1);

use App\Character\Controllers\CreateCharacterController;
use App\Character\Controllers\GetCharacterController;
use App\Game\Controllers\CreateGameController;
use App\Game\Controllers\GetGameController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/characters', [GetCharacterController::class, 'getCharacters']);
Route::get('/characters/with_game', [GetCharacterController::class, 'getCharactersWithGame']);
Route::get('/characters/{id}', [GetCharacterController::class, 'getCharacter']);
Route::get('/characters/{id}/with_game', [GetCharacterController::class, 'getCharacterWithGame']);
Route::post('/characters', [CreateCharacterController::class, 'createCharacter']);

Route::get('/games', [GetGameController::class, 'getGames']);
Route::get('/games/{id}', [GetGameController::class, 'getGame']);
Route::post('/games', [CreateGameController::class, 'createGame']);
