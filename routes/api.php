<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\CardController;
use App\Http\Controllers\DeckController;
use App\Http\Controllers\GPTBotController;
use Illuminate\Support\Facades\Route;

/*|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
 */

Route::group(['prefix' => 'auth'], function () {
    Route::post('login', [AuthController::class, 'login'])->name('api.auth.login');
    Route::post('register', [AuthController::class, 'register'])->name('api.auth.register');
});

Route::group(['middleware' => 'auth:sanctum'], function () {

    // auth
    Route::group(['prefix' => 'auth'], function () {
        Route::post('logout', [AuthController::class, 'logout'])->name('api.auth.logout');
        Route::post('update-password', [AuthController::class, 'updatePassword'])->name('api.auth.update-password');
    });

    // deck
    Route::resource('decks', DeckController::class);
    Route::prefix('decks/{deck}')->group(function () {
        Route::get('cards', [CardController::class, 'index']);
        Route::post('cards', [CardController::class, 'store']);
        Route::get('cards/due', [CardController::class, 'getDueCards']);
    });

    // card
    Route::resource('cards', CardController::class);
    Route::prefix('cards')->group(function () {
        Route::post('{id}/review', [CardController::class, 'reviewCard']);
        Route::get('{card}/image', [CardController::class, 'getImage'])->name('cards.get-image');
    });

    // gpt requests
    Route::post('/fetch-translation', [GPTBotController::class, 'getTranslation'])->name('gptbot.get-translation');
    Route::post('/generate-image', [GPTBotController::class, 'generateImage'])->name('gptbot.generate-image');
});
