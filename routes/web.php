<?php

declare(strict_types=1);

use App\Character\Controllers\GetCharacterController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/characters', [GetCharacterController::class, 'getCharacters']);
Route::get('/character/{id}', [GetCharacterController::class, 'getCharacter']);
