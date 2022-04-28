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
use App\Http\Controllers\Api\V2\WMGameController;

use App\Http\Controllers\Api\V3\PaymentTransactionPromotionController;

// use App\Http\Controllers\Api\Games\CoreApiController;

use App\Helpers\CoreGameComponent as CoreGame;

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
    Route::get('game/description/{id}', [GamesController::class, 'gameDescription']);

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

            Route::get('user-level', [GamesController::class, 'getUserLevelApiGame']);

            Route::get('/pgsoft/player-summary', [WalletsController::class, 'getPlayerSummary']);
            Route::get('player-summary', [WalletsController::class, 'getPlayerSummary2']);
            Route::get('player-summaries/{gamecode}', [WalletsController::class, 'getPlayerSummary3']);
        });

        Route::prefix('logs')->group(function () {
            Route::post('user-activities', [LogsController::class, 'userLogs']);
        });
    });

    Route::post('test-get-token', [GamesController::class, 'createGameTk']);


    // Service For Update Realtime ////////////////////////////////////////////////////////
    Route::prefix('services')->group(function () {
        Route::get('update-game-wallet', [ServicesController::class, 'updateGameWallet']);
        Route::get('update-pgsoftgame-player-daily-summary', [ServicesController::class, 'updatePgSoftGamePlayerDailySummaryToDB']);
        Route::get('update-wmcasino-player-daily-summary', [ServicesController::class, 'updateWMCasinoPlayerDailySummaryToDB']);

    });
    // END Service For Update Realtime ////////////////////////////////////////////////////



    // WM-CASINO CALLBACK /////////////////////////////////////////////////////////////////
    Route::post('wm-prod/call-back', [GamesController::class, 'wmCallBackPost']);
    Route::get('wm-prod/call-back', [GamesController::class], 'wmCallBackGet');
    
});

Route::prefix('v2')->group(function () {
    Route::prefix('pgsoftgame')->group(function () {
        Route::get('user/{ops}', [PgSoftGameController::class, 'getUserData']);
        Route::get('wallet/{user}', [PgSoftGameController::class, 'getUserWallet']);
        // Route::get('player-daily-summary', [PgSoftGameController::class, 'saveToDB']);
        Route::get('update-player-daily-summary', [PgSoftGameController::class, 'saveToDB']);
    });

    Route::prefix('wmgame')->group(function () {
        Route::get('test-wm-hello', [WMGameController::class, 'testWMHello']);
        Route::post('test-member-register', [WMGameController::class, 'testMemberRegister']);
        Route::post('test-signing-game', [WMGameController::class, 'testSigninGame']);
        Route::post('test-logout-game', [WMGameController::class, 'testLogoutGame']);
        Route::post('test-change-balance', [WMGameController::class, 'testChangeBalance']);
        Route::post('test-get-balance', [WMGameController::class, 'testGetBalance']);
        Route::post('test-get-report', [WMGameController::class, 'testReport']);
    });
});

Route::prefix('v3')->group(function () {
    Route::prefix('payment-transaction-promotion')->group(function () {
        Route::get('wallet-list/{transaction_id}', [PaymentTransactionPromotionController::class, 'walletList']);
    });
});

Route::middleware(['auth:api'])->group(function () {
    Route::prefix('games')->group(function () {
        Route::get('call/{gamecode}/{action}/{amount?}', function ($gamecode, $action, $amount = NULL) {
            $accessToken = auth()->user()->token();
            $result = (new CoreGame)->checkpoint($accessToken->user_id, $gamecode, $action, $amount);
            return response()->json(['data' => $result]);
        });
    });
});