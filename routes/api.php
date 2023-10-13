<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\CardController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\DeckController;
use App\Http\Controllers\ProgressController;
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

    Route::get('dashboard', [DashboardController::class, 'index'])->name('api.dashboard.index');

    Route::group(['prefix' => 'auth'], function () {
        Route::post('logout', [AuthController::class, 'logout'])->name('api.auth.logout');
        Route::post('update-password', [AuthController::class, 'updatePassword'])->name('api.auth.update-password');
    });

    Route::resource('decks', DeckController::class);

    Route::prefix('decks/{deck}')->group(function () {
        Route::get('cards', [CardController::class, 'index']);
        Route::post('cards', [CardController::class, 'store']);
    });

    Route::resource('cards', CardController::class)->except(['index', 'store']);
    Route::get('/decks/{deck}/cards/due', [CardController::class, 'getDueCards']);

    Route::post('/cards/{id}/review', [CardController::class, 'reviewCard']);

    Route::post('progress/{card}', [ProgressController::class, 'trackProgress'])->name('progress.track');
    Route::get('progress/{card}', [ProgressController::class, 'getProgress'])->name('progress.get');

});
