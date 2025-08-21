<?php

declare(strict_types=1);

use App\Categories\Infrastructure\Controllers\Api\CreateCategoryController;
use App\Categories\Infrastructure\Controllers\Api\GetCategoryController;
use App\CategoryGames\Infrastructure\Controllers\CreateCategoryGameController;
use App\Characters\Infrastructure\Controllers\Api\CreateCharacterController;
use App\Characters\Infrastructure\Controllers\Api\GetCharacterController;
use App\ComponentFields\Infrastructure\Controllers\Api\CreateComponentFieldController;
use App\ComponentFields\Infrastructure\Controllers\Api\GetComponentFieldsController;
use App\ComponentFields\Infrastructure\Controllers\Api\UpdateComponentFieldController;
use App\Components\Infrastructure\Controllers\Api\CreateComponentController;
use App\Components\Infrastructure\Controllers\Api\GetComponentController;
use App\Games\Infrastructure\Controllers\Api\CreateGameController;
use App\Games\Infrastructure\Controllers\Api\GetGameController;
use App\Games\Infrastructure\Controllers\Api\UpdateGameController;
use App\ItemFields\Infrastructure\Controllers\Api\CreateItemFieldController;
use App\ItemFields\Infrastructure\Controllers\Api\GetItemFieldsController;
use App\ItemFields\Infrastructure\Controllers\Api\UpdateItemFieldController;
use App\Items\Infrastructure\Controllers\Api\CreateItemController;
use App\Items\Infrastructure\Controllers\Api\GetItemController;
use App\LinkedItemFields\Infrastructure\Controllers\Api\CreateLinkedItemFieldController;
use App\LinkedItemFields\Infrastructure\Controllers\Api\GetLinkedItemFieldsController;
use App\LinkedItemFields\Infrastructure\Controllers\Api\UpdateLinkedItemFieldController;
use App\LinkedItems\Infrastructure\Controllers\Api\CreateLinkedItemController;
use App\LinkedItems\Infrastructure\Controllers\Api\GetLinkedItemController;
use App\Parameters\Infrastructure\Controllers\Api\CreateParameterController;
use App\Parameters\Infrastructure\Controllers\Api\GetParameterController;
use App\PlayableItemFields\Infrastructure\Controllers\Api\CreatePlayableItemFieldController;
use App\PlayableItemFields\Infrastructure\Controllers\Api\GetPlayableItemFieldsController;
use App\PlayableItemFields\Infrastructure\Controllers\Api\UpdatePlayableItemFieldController;
use App\PlayableItems\Infrastructure\Controllers\Api\CreatePlayableItemController;
use App\PlayableItems\Infrastructure\Controllers\Api\GetPlayableItemController;
use App\Users\Infrastructure\Controllers\Api\AuthenticationController;
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
    Route::get('/games_all', [GetGameController::class, 'getAllGames']);
    Route::get('/games_all_without_requested_category', [GetGameController::class, 'getAllGamesWithoutRequestedCategory']);
    Route::get('/games/{id}', [GetGameController::class, 'getGame']);
    Route::get('/games/{id}/with_categories_and_playable_items', [GetGameController::class, 'getGameWithCategoriesAndPlayableItems']);
    Route::post('/games', [CreateGameController::class, 'createGame']);
    Route::put('/games/{id}', [UpdateGameController::class, 'updateGame']);
    Route::patch('/games/{id}', [UpdateGameController::class, 'updatePartiallyGame']);

    Route::get('/categories', [GetCategoryController::class, 'getCategories']);
    Route::get('/categories_all', [GetCategoryController::class, 'getAllCategories']);
    Route::get('/categories_all_without_requested_game', [GetCategoryController::class, 'getAllCategoriesWithoutRequestedGame']);
    Route::get('/categories/{id}', [GetCategoryController::class, 'getCategory']);
    Route::post('/categories', [CreateCategoryController::class, 'createCategory']);

    Route::post('/category_games', [CreateCategoryGameController::class, 'createCategoryGame']);

    Route::get('/parameters', [GetParameterController::class, 'getParameters']);
    Route::get('/parameters/{id}', [GetParameterController::class, 'getParameter']);
    Route::post('/parameters', [CreateParameterController::class, 'createParameter']);

    // COMPONENTS
    Route::get('/components', [GetComponentController::class, 'getComponents']);
    Route::get('/components/{id}', [GetComponentController::class, 'getComponent']);
    Route::post('/components', [CreateComponentController::class, 'createComponent']);

    Route::get('/component_fields', [GetComponentFieldsController::class, 'getComponentFields']);
    Route::get('/component_fields/{id}', [GetComponentFieldsController::class, 'getComponentField']);
    Route::post('/component_fields', [CreateComponentFieldController::class, 'createComponentField']);
    Route::put('/component_fields/{id}', [UpdateComponentFieldController::class, 'updateComponentField']);
    Route::patch('/component_fields/{id}', [UpdateComponentFieldController::class, 'updatePartiallyComponentField']);

    // ITEMS
    Route::get('/items', [GetItemController::class, 'getItems']);
    Route::get('/items/{id}', [GetItemController::class, 'getItem']);
    Route::post('/items', [CreateItemController::class, 'createItem']);

    Route::get('/item_fields', [GetItemFieldsController::class, 'getItemFields']);
    Route::get('/item_fields/{id}', [GetItemFieldsController::class, 'getItemField']);
    Route::post('/item_fields', [CreateItemFieldController::class, 'createItemField']);
    Route::put('/item_fields/{id}', [UpdateItemFieldController::class, 'updateItemField']);
    Route::patch('/item_fields/{id}', [UpdateItemFieldController::class, 'updatePartiallyItemField']);

    // PLAYABLE_ITEMS
    Route::get('/playable_items', [GetPlayableItemController::class, 'getPlayableItems']);
    Route::get('/playable_items/{id}', [GetPlayableItemController::class, 'getPlayableItem']);
    Route::post('/playable_items', [CreatePlayableItemController::class, 'createPlayableItem']);

    Route::get('/playable_item_fields', [GetPlayableItemFieldsController::class, 'getPlayableItemFields']);
    Route::get('/playable_item_fields/{id}', [GetPlayableItemFieldsController::class, 'getPlayableItemField']);
    Route::post('/playable_item_fields', [CreatePlayableItemFieldController::class, 'createPlayableItemField']);
    Route::put('/playable_item_fields/{id}', [UpdatePlayableItemFieldController::class, 'updatePlayableItemField']);
    Route::patch('/playable_item_fields/{id}', [UpdatePlayableItemFieldController::class, 'updatePartiallyPlayableItemField']);

    // LINKED_ITEMS
    Route::get('/linked_items', [GetLinkedItemController::class, 'getLinkedItems']);
    Route::get('/linked_items/{id}', [GetLinkedItemController::class, 'getLinkedItem']);
    Route::post('/linked_items', [CreateLinkedItemController::class, 'createLinkedItem']);

    Route::get('/linked_item_fields', [GetLinkedItemFieldsController::class, 'getLinkedItemFields']);
    Route::get('/linked_item_fields/{id}', [GetLinkedItemFieldsController::class, 'getLinkedItemField']);
    Route::post('/linked_item_fields', [CreateLinkedItemFieldController::class, 'createLinkedItemField']);
    Route::put('/linked_item_fields/{id}', [UpdateLinkedItemFieldController::class, 'updateLinkedItemField']);
    Route::patch('/linked_item_fields/{id}', [UpdateLinkedItemFieldController::class, 'updatePartiallyLinkedItemField']);
});
