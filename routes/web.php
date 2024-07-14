<?php

declare(strict_types=1);

use App\Character\Controllers\CreateCharacterController;
use App\Character\Controllers\GetCharacterController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/characters', [GetCharacterController::class, 'getCharacters']);
Route::get('/characters/{id}', [GetCharacterController::class, 'getCharacter']);
Route::post('/characters', [CreateCharacterController::class, 'createCharacter']);
