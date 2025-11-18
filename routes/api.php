<?php

declare(strict_types=1);

use App\Categories\Infrastructure\Controllers\Get\GetAllCategories\GetAllCategoriesController;
use App\Categories\Infrastructure\Controllers\Get\GetAllCategoriesWithoutRequestedGame\GetAllCategoriesWithoutRequestedGameController;
use App\Categories\Infrastructure\Controllers\Get\GetCategories\GetCategoriesController;
use App\Categories\Infrastructure\Controllers\Get\GetCategory\GetCategoryController;
use App\Categories\Infrastructure\Controllers\Post\CreateCategory\CreateCategoryController;
use App\CategoryGames\Infrastructure\Controllers\Post\CreateCategoryGame\CreateCategoryGameController;
use App\Characters\Infrastructure\Controllers\Get\GetCharacter\GetCharacterController;
use App\Characters\Infrastructure\Controllers\Get\GetCharacters\GetCharactersController;
use App\Characters\Infrastructure\Controllers\Get\GetCharactersWithGame\GetCharactersWithGameController;
use App\Characters\Infrastructure\Controllers\Get\GetCharacterWithGame\GetCharacterWithGameController;
use App\Characters\Infrastructure\Controllers\Get\GetCharacterWithLinkedItems\GetCharacterWithLinkedItemsController;
use App\Characters\Infrastructure\Controllers\Post\CreateCharacter\CreateCharacterController;
use App\ComponentFields\Infrastructure\Controllers\Get\GetComponentField\GetComponentFieldController;
use App\ComponentFields\Infrastructure\Controllers\Get\GetComponentFields\GetComponentFieldsController;
use App\ComponentFields\Infrastructure\Controllers\Patch\UpdatePartiallyComponentField\UpdatePartiallyComponentFieldController;
use App\ComponentFields\Infrastructure\Controllers\Post\CreateComponentField\CreateComponentFieldController;
use App\ComponentFields\Infrastructure\Controllers\Put\UpdateComponentField\UpdateComponentFieldController;
use App\Components\Infrastructure\Controllers\Get\GetComponent\GetComponentController;
use App\Components\Infrastructure\Controllers\Get\GetComponents\GetComponentsController;
use App\Components\Infrastructure\Controllers\Post\CreateComponent\CreateComponentController;
use App\Games\Infrastructure\Controllers\Get\GetAllGames\GetAllGamesController;
use App\Games\Infrastructure\Controllers\Get\GetAllGamesWithoutRequestedCategory\GetAllGamesWithoutRequestedCategoryController;
use App\Games\Infrastructure\Controllers\Get\GetGame\GetGameController;
use App\Games\Infrastructure\Controllers\Get\GetGames\GetGamesController;
use App\Games\Infrastructure\Controllers\Get\GetGameWithCategoriesAndPlayableItems\GetGameWithCategoriesAndPlayableItemsController;
use App\Games\Infrastructure\Controllers\Patch\UpdatePartiallyGame\UpdatePartiallyGameController;
use App\Games\Infrastructure\Controllers\Post\CreateGame\CreateGameController;
use App\Games\Infrastructure\Controllers\Put\UpdateGame\UpdateGameController;
use App\ItemFields\Infrastructure\Controllers\Get\GetItemField\GetItemFieldController;
use App\ItemFields\Infrastructure\Controllers\Get\GetItemFields\GetItemFieldsController;
use App\ItemFields\Infrastructure\Controllers\Patch\UpdatePartiallyItemField\UpdatePartiallyItemFieldController;
use App\ItemFields\Infrastructure\Controllers\Post\CreateItemField\CreateItemFieldController;
use App\ItemFields\Infrastructure\Controllers\Put\UpdateItemFieldController;
use App\Items\Infrastructure\Controllers\Get\GetItem\GetItemController;
use App\Items\Infrastructure\Controllers\Get\GetItems\GetItemsController;
use App\Items\Infrastructure\Controllers\Post\CreateItem\CreateItemController;
use App\LinkedItemFields\Infrastructure\Controllers\Get\GetLinkedItemField\GetLinkedItemFieldController;
use App\LinkedItemFields\Infrastructure\Controllers\Get\GetLinkedItemFields\GetLinkedItemFieldsController;
use App\LinkedItemFields\Infrastructure\Controllers\Patch\UpdatePartiallyLinkedItemField\UpdatePartiallyLinkedItemFieldController;
use App\LinkedItemFields\Infrastructure\Controllers\Post\CreateLinkedItemField\CreateLinkedItemFieldController;
use App\LinkedItemFields\Infrastructure\Controllers\Put\UpdateLinkedItemField\UpdateLinkedItemFieldController;
use App\LinkedItems\Infrastructure\Controllers\Get\GetLinkedItem\GetLinkedItemController;
use App\LinkedItems\Infrastructure\Controllers\Get\GetLinkedItems\GetLinkedItemsController;
use App\LinkedItems\Infrastructure\Controllers\Post\CreateLinkedItem\CreateLinkedItemController;
use App\Parameters\Infrastructure\Controllers\Get\GetParameter\GetParameterController;
use App\Parameters\Infrastructure\Controllers\Get\GetParameters\GetParametersController;
use App\Parameters\Infrastructure\Controllers\Post\CreateParameter\CreateParameterController;
use App\PlayableItemFields\Infrastructure\Controllers\Get\GetPlayableItemField\GetPlayableItemFieldController;
use App\PlayableItemFields\Infrastructure\Controllers\Get\GetPlayableItemFields\GetPlayableItemFieldsController;
use App\PlayableItemFields\Infrastructure\Controllers\Patch\UpdatePartiallyPlayableItemField\UpdatePartiallyPlayableItemFieldController;
use App\PlayableItemFields\Infrastructure\Controllers\Post\CreatePlayableItemField\CreatePlayableItemFieldController;
use App\PlayableItemFields\Infrastructure\Controllers\Put\UpdatePlayableItemField\UpdatePlayableItemFieldController;
use App\PlayableItems\Infrastructure\Controllers\Get\GetPlayableItem\GetPlayableItemController;
use App\PlayableItems\Infrastructure\Controllers\Get\GetPlayableItems\GetPlayableItemsController;
use App\PlayableItems\Infrastructure\Controllers\Post\CreatePlayableItem\CreatePlayableItemController;
use App\Users\Infrastructure\Controllers\Post\Login\LoginController;
use App\Users\Infrastructure\Controllers\Post\Logout\LogoutController;
use App\Users\Infrastructure\Controllers\Post\Register\RegisterController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:api');

Route::post('/register', RegisterController::class);
Route::post('/login', LoginController::class);

Route::middleware('auth:api')->group(function () {
    Route::post('/logout', LogoutController::class);

    Route::get('/characters', GetCharactersController::class);
    Route::get('/characters/with_game', GetCharactersWithGameController::class);
    Route::get('/characters/{id}', GetCharacterController::class);
    Route::get('/characters/{id}/with_game', GetCharacterWithGameController::class);
    Route::get('/characters/{id}/with_linked_items', GetCharacterWithLinkedItemsController::class);
    Route::post('/characters', CreateCharacterController::class);

    Route::get('/games', GetGamesController::class);
    Route::get('/games_all', GetAllGamesController::class);
    Route::get('/games_all_without_requested_category', GetAllGamesWithoutRequestedCategoryController::class);
    Route::get('/games/{id}', GetGameController::class);
    Route::get('/games/{id}/with_categories_and_playable_items', GetGameWithCategoriesAndPlayableItemsController::class);
    Route::post('/games', CreateGameController::class);
    Route::put('/games/{id}', UpdateGameController::class);
    Route::patch('/games/{id}', UpdatePartiallyGameController::class);

    Route::get('/categories', GetCategoriesController::class);
    Route::get('/categories_all', GetAllCategoriesController::class);
    Route::get('/categories_all_without_requested_game', GetAllCategoriesWithoutRequestedGameController::class);
    Route::get('/categories/{id}', GetCategoryController::class);
    Route::post('/categories', CreateCategoryController::class);

    Route::post('/category_games', CreateCategoryGameController::class);

    Route::get('/parameters', GetParametersController::class);
    Route::get('/parameters/{id}', GetParameterController::class);
    Route::post('/parameters', CreateParameterController::class);

    // COMPONENTS
    Route::get('/components', GetComponentsController::class);
    Route::get('/components/{id}', GetComponentController::class);
    Route::post('/components', CreateComponentController::class);

    Route::get('/component_fields', GetComponentFieldsController::class);
    Route::get('/component_fields/{id}', GetComponentFieldController::class);
    Route::post('/component_fields', CreateComponentFieldController::class);
    Route::put('/component_fields/{id}', UpdateComponentFieldController::class);
    Route::patch('/component_fields/{id}', UpdatePartiallyComponentFieldController::class);

    // ITEMS
    Route::get('/items', GetItemsController::class);
    Route::get('/items/{id}', GetItemController::class);
    Route::post('/items', CreateItemController::class);

    Route::get('/item_fields', GetItemFieldsController::class);
    Route::get('/item_fields/{id}', GetItemFieldController::class);
    Route::post('/item_fields', CreateItemFieldController::class);
    Route::put('/item_fields/{id}', UpdateItemFieldController::class);
    Route::patch('/item_fields/{id}', UpdatePartiallyItemFieldController::class);

    // PLAYABLE_ITEMS
    Route::get('/playable_items', GetPlayableItemsController::class);
    Route::get('/playable_items/{id}', GetPlayableItemController::class);
    Route::post('/playable_items', CreatePlayableItemController::class);

    Route::get('/playable_item_fields', GetPlayableItemFieldsController::class);
    Route::get('/playable_item_fields/{id}', GetPlayableItemFieldController::class);
    Route::post('/playable_item_fields', CreatePlayableItemFieldController::class);
    Route::put('/playable_item_fields/{id}', UpdatePlayableItemFieldController::class);
    Route::patch('/playable_item_fields/{id}', UpdatePartiallyPlayableItemFieldController::class);

    // LINKED_ITEMS
    Route::get('/linked_items', GetLinkedItemsController::class);
    Route::get('/linked_items/{id}', GetLinkedItemController::class);
    Route::post('/linked_items', CreateLinkedItemController::class);

    Route::get('/linked_item_fields', GetLinkedItemFieldsController::class);
    Route::get('/linked_item_fields/{id}', GetLinkedItemFieldController::class);
    Route::post('/linked_item_fields', CreateLinkedItemFieldController::class);
    Route::put('/linked_item_fields/{id}', UpdateLinkedItemFieldController::class);
    Route::patch('/linked_item_fields/{id}', UpdatePartiallyLinkedItemFieldController::class);
});
