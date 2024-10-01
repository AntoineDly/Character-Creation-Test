<?php

declare(strict_types=1);

use App\Categories\Controllers\AssociateCategoryController;
use App\Categories\Controllers\CreateCategoryController;
use App\Categories\Controllers\GetCategoryController;
use App\Characters\Controllers\CreateCharacterController;
use App\Characters\Controllers\GetCharacterController;
use App\Components\Controllers\CreateComponentController;
use App\Components\Controllers\GetComponentController;
use App\DefaultComponentFields\Controllers\CreateDefaultComponentFieldController;
use App\DefaultItemFields\Controllers\CreateDefaultItemFieldController;
use App\Fields\Controllers\CreateFieldController;
use App\Games\Controllers\CreateGameController;
use App\Games\Controllers\GetGameController;
use App\Games\Controllers\UpdateGameController;
use App\Items\Controllers\CreateItemController;
use App\LinkedItems\Controllers\CreateLinkedItemController;
use App\Parameters\Controllers\CreateParameterController;
use App\Users\Controllers\AuthenticationController;
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
    Route::get('/characters/{id}/with_linked_items', [GetCharacterController::class, 'getCharacterWithLinkedItems']);
    Route::post('/characters', [CreateCharacterController::class, 'createCharacter']);

    Route::get('/games', [GetGameController::class, 'getGames']);
    Route::get('/games/{id}', [GetGameController::class, 'getGame']);
    Route::post('/games', [CreateGameController::class, 'createGame']);
    Route::put('/games', [UpdateGameController::class, 'updateGame']);

    Route::get('/categories', [GetCategoryController::class, 'getCategories']);
    Route::get('/categories/{id}', [GetCategoryController::class, 'getCategory']);
    Route::post('/categories', [CreateCategoryController::class, 'createCategory']);
    Route::post('/categories/associate_game', [AssociateCategoryController::class, 'associateGame']);

    Route::get('/components', [GetComponentController::class, 'getComponents']);
    Route::get('/components/{id}', [GetComponentController::class, 'getComponent']);
    Route::post('/components', [CreateComponentController::class, 'createComponent']);

    Route::post('/parameters', [CreateParameterController::class, 'createParameter']);

    Route::post('/default_item_fields', [CreateDefaultItemFieldController::class, 'createDefaultItemField']);

    Route::post('/default_component_fields', [CreateDefaultComponentFieldController::class, 'createDefaultComponentField']);

    Route::post('/fields', [CreateFieldController::class, 'createField']);

    Route::post('/items', [CreateItemController::class, 'createItem']);

    Route::post('/linked_items', [CreateLinkedItemController::class, 'createLinkedItem']);
});
