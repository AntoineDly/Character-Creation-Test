<?php

declare(strict_types=1);

use App\Categories\Controllers\Api\AssociateCategoryController;
use App\Categories\Controllers\Api\CreateCategoryController;
use App\Categories\Controllers\Api\GetCategoryController;
use App\Characters\Controllers\Api\CreateCharacterController;
use App\Characters\Controllers\Api\GetCharacterController;
use App\Components\Controllers\Api\CreateComponentController;
use App\Components\Controllers\Api\GetComponentController;
use App\DefaultComponentFields\Controllers\Api\CreateDefaultComponentFieldController;
use App\DefaultComponentFields\Controllers\Api\UpdateDefaultComponentFieldController;
use App\DefaultItemFields\Controllers\Api\CreateDefaultItemFieldController;
use App\DefaultItemFields\Controllers\Api\UpdateDefaultItemFieldController;
use App\Fields\Controllers\Api\CreateFieldController;
use App\Fields\Controllers\Api\UpdateFieldController;
use App\Games\Controllers\Api\CreateGameController;
use App\Games\Controllers\Api\GetGameController;
use App\Games\Controllers\Api\UpdateGameController;
use App\Items\Controllers\Api\CreateItemController;
use App\LinkedItems\Controllers\Api\CreateLinkedItemController;
use App\Parameters\Controllers\Api\CreateParameterController;
use App\Users\Controllers\Api\AuthenticationController;
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
    Route::put('/games/{id}', [UpdateGameController::class, 'updateGame']);
    Route::patch('/games/{id}', [UpdateGameController::class, 'updatePartiallyGame']);

    Route::get('/categories', [GetCategoryController::class, 'getCategories']);
    Route::get('/categories/{id}', [GetCategoryController::class, 'getCategory']);
    Route::post('/categories', [CreateCategoryController::class, 'createCategory']);
    Route::post('/categories/associate_game', [AssociateCategoryController::class, 'associateGame']);

    Route::get('/components', [GetComponentController::class, 'getComponents']);
    Route::get('/components/{id}', [GetComponentController::class, 'getComponent']);
    Route::post('/components', [CreateComponentController::class, 'createComponent']);

    Route::post('/parameters', [CreateParameterController::class, 'createParameter']);

    Route::post('/default_item_fields', [CreateDefaultItemFieldController::class, 'createDefaultItemField']);
    Route::put('/default_item_fields/{id}', [UpdateDefaultItemFieldController::class, 'updateDefaultItemField']);
    Route::patch('/default_item_fields/{id}', [UpdateDefaultItemFieldController::class, 'updatePartiallyDefaultItemField']);

    Route::post('/default_component_fields', [CreateDefaultComponentFieldController::class, 'createDefaultComponentField']);
    Route::put('/default_component_fields/{id}', [UpdateDefaultComponentFieldController::class, 'updateDefaultComponentField']);
    Route::patch('/default_component_fields/{id}', [UpdateDefaultComponentFieldController::class, 'updatePartiallyDefaultComponentField']);

    Route::post('/fields', [CreateFieldController::class, 'createField']);
    Route::put('/fields/{id}', [UpdateFieldController::class, 'updateField']);
    Route::patch('/fields/{id}', [UpdateFieldController::class, 'updatePartiallyField']);

    Route::post('/items', [CreateItemController::class, 'createItem']);

    Route::post('/linked_items', [CreateLinkedItemController::class, 'createLinkedItem']);
});
