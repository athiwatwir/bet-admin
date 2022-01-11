<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

use App\Http\Controllers\Api\V1\Auth\PassportAuthController;

use App\Http\Controllers\Api\V1\UsersController;
use App\Http\Controllers\Api\V1\WalletsController;
use App\Http\Controllers\Api\V1\PaymentTransactionsController;
use App\Http\Controllers\Api\V1\GamesController;
use App\Http\Controllers\Api\V1\LogsController;
use App\Http\Controllers\Api\V1\ServicesController;

use App\Http\Controllers\Api\V2\PgSoftGameController;

use App\Http\Controllers\Api\V3\PaymentTransactionPromotionController;

use App\Http\Controllers\Api\Games\CoreApiController;

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
Route::prefix('v1')->group(function () {
    Route::post('register', [PassportAuthController::class, 'register']);
    Route::post('login', [PassportAuthController::class, 'login']);
    Route::post('forgot-password', [PassportAuthController::class, 'forgotPassword']);
    Route::post('confirm-otp', [PassportAuthController::class, 'confirmOtp']);
    Route::post('reset-password', [PassportAuthController::class, 'resetPassword']);

    Route::prefix('menu')->group(function () {
        Route::get('games', [GamesController::class, 'menuGames']);
    });

    Route::get('game/demo/{table}', [GamesController::class, 'gameDemo']);

    Route::middleware(['auth:api'])->group(function () {
        Route::get('logout', [PassportAuthController::class, 'logout']);

        Route::prefix('user')->group(function () {
            Route::get('view', [UsersController::class, 'view']);
            Route::get('user-banking', [UsersController::class, 'userBanking']);
            Route::get('wallets', [WalletsController::class, 'userWallets']);
            Route::get('delete-wallet/{id}', [WalletsController::class, 'deleteWallet']);
            Route::get('histories-wallet', [PaymentTransactionsController::class, 'userPaymentTransactions']);
            Route::get('level', [UsersController::class, 'level']);

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
            Route::get('login/{table}', [GamesController::class, 'gameLogin']);
            Route::get('wallet/{game}', [WalletsController::class, 'getUserWallet_v2']);

            Route::get('/pgsoft/player-summary', [WalletsController::class, 'getPlayerSummary']);
        });

        Route::prefix('logs')->group(function () {
            Route::post('user-activities', [LogsController::class, 'userLogs']);
        });
    });

    Route::post('test-get-token', [GamesController::class, 'createGameTk']);

    Route::prefix('services')->group(function () {
        Route::get('update-game-wallet', [ServicesController::class, 'updateGameWallet']);
    });
});

Route::prefix('v2')->group(function () {
    Route::prefix('pgsoftgame')->group(function () {
        Route::get('user/{ops}', [PgSoftGameController::class, 'getUserData']);
        Route::get('wallet/{user}', [PgSoftGameController::class, 'getUserWallet']);
        // Route::get('player-daily-summary', [PgSoftGameController::class, 'saveToDB']);
        Route::get('update-player-daily-summary', [PgSoftGameController::class, 'saveToDB']);
    });
});

Route::prefix('v3')->group(function () {
    Route::prefix('payment-transaction-promotion')->group(function () {
        Route::get('wallet-list/{transaction_id}', [PaymentTransactionPromotionController::class, 'walletList']);
    });
});

Route::prefix('games')->group(function () {
    Route::middleware(['auth:api'])->group(function () {
        Route::get('call/{gamecode}/{action}/{amount?}', [CoreApiController::class, 'checkpoint']);
    });
});