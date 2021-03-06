<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

use App\Http\Controllers\Api\V1\Auth\PassportAuthController;
use App\Http\Controllers\Api\V1\Auth\GameCallbackController;

use App\Http\Controllers\Api\V1\UsersController;
use App\Http\Controllers\Api\V1\WalletsController;
use App\Http\Controllers\Api\V1\PaymentTransactionsController;
use App\Http\Controllers\Api\V1\GamesController;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

// Route::middleware('auth:api')->get('/user', function (Request $request) {
//     return $request->user();
// });

Route::post('register', [PassportAuthController::class, 'register']);
Route::post('login', [PassportAuthController::class, 'login']);

Route::prefix('menu')->group(function () {
    Route::get('games', [GamesController::class, 'menuGames']);
});

Route::post('game/call-back', [GameCallbackController::class, 'gameCallBack']);

Route::middleware(['auth:api'])->group(function () {
    Route::get('logout', [PassportAuthController::class, 'logout']);

    Route::prefix('user')->group(function () {
        Route::get('view', [UsersController::class, 'view']);
        Route::get('user-banking', [UsersController::class, 'userBanking']);
        Route::get('wallets', [WalletsController::class, 'userWallets']);
        Route::get('delete-wallet/{id}', [WalletsController::class, 'deleteWallet']);
        Route::get('histories-wallet', [PaymentTransactionsController::class, 'userPaymentTransactions']);

        Route::post('update', [UsersController::class, 'update']);
        Route::post('change-password', [UsersController::class, 'changePassword']);
        Route::post('user-banking', [UsersController::class, 'userBankingUpdate']);
        Route::post('user-banking-edit', [UsersController::class, 'userBankingEdit']);
        Route::post('create-wallet', [WalletsController::class, 'createWallet']);
        Route::post('add-wallet', [WalletsController::class, 'addWallet']);
        Route::post('transfer-wallet', [WalletsController::class, 'transferWallet']);
        Route::post('deposit-wallet', [WalletsController::class, 'depositWallet']);
        Route::post('withdraw-wallet', [WalletsController::class, 'withdrawWallet']);
    });

    Route::prefix('game')->group(function () {
        Route::get('play/{id}', [GamesController::class, 'playGame']);
    });
});
