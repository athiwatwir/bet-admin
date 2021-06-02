<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AccountSettingController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\UsersController;
use App\Http\Controllers\MembersController;
use App\Http\Controllers\AdminsController;
use App\Http\Controllers\CBankAccountController;
use App\Http\Controllers\PaymentTransactionController;
use App\Http\Controllers\BanksController;
use App\Http\Controllers\WalletsController;
use App\Http\Controllers\GameGroupsController;
use App\Http\Controllers\GamesController;
use App\Http\Controllers\FootballLeagueController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () {
    return view('auth/login');
})->name('login');

Auth::routes();

// Route::get('/home', 'HomeController@index')->name('home');

Route::middleware(['admin'])->group(function () {
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');

    Route::get('/account-setting', [AccountSettingController::class, 'index'])->name('account-setting');
    Route::post('/account-setting/update/{id}', [AccountSettingController::class, 'update']);
    Route::post('/account-setting/change-password/{id}', [AccountSettingController::class , 'changePassword']);

    Route::prefix('/users')->group(function () {
        Route::get('/', [UsersController::class, 'index'])->name('users');
        Route::get('/active/{id}/{username}', [UsersController::class, 'active']);
        Route::get('/delete/{id}/{username}', [UsersController::class, 'delete']);
        Route::get('/{username}/{id}/view', [UsersController::class, 'view'])->name('view');
        Route::get('/{username}/{id}/wallet', [WalletsController::class, 'index'])->name('wallet');
        Route::post('/edit/profile', [UsersController::class, 'editProfile']);
        Route::post('/edit/bank', [UsersController::class, 'editBank']);
        Route::post('/wallet/increase-wallet-amount', [WalletsController::class, 'increaseWalletAmount']);
        Route::post('/wallet/decrease-wallet-amount', [WalletsController::class, 'decreaseWalletAmount']);
    });

    Route::prefix('/admins')->group(function () {
        Route::get('/', [AdminsController::class, 'index'])->name('admins');
        Route::get('/active/{id}/{username}', [AdminsController::class, 'active']);
        Route::get('/delete/{id}/{username}', [AdminsController::class, 'delete']);
        Route::get('/{username}/{id}/view', [AdminsController::class, 'view'])->name('view');
        Route::post('/register', [AdminsController::class, 'register']);
        Route::post('/edit/profile', [AdminsController::class, 'edit']);
        Route::post('/re-password', [AdminsController::class, 'rePassword']);
    });

    Route::get('/members', [MembersController::class, 'index'])->name('members');

    Route::get('/cbank', [CBankAccountController::class, 'index'])->name('cbank');

    Route::get('/banks', [BanksController::class, 'index'])->name('banks');
    Route::get('/banks/active/{id}/{bank_name}', [BanksController::class, 'active']);
    Route::get('/banks/delete/{id}/{bank_name}', [BanksController::class, 'delete']);
    Route::post('/banks/add', [BanksController::class, 'add']);
    Route::post('/banks/edit', [BanksController::class, 'edit']);


    Route::post('/create-cbank', [CBankAccountController::class, 'createCBank']);
    Route::post('/edit-cbank', [CBankAccountController::class, 'editCBank']);
    Route::get('/delete-cbank/{id}', [CBankAccountController::class, 'deleteCBank']);
    Route::get('/active-cbank/{id}/{account_name}/{account_number}', [CBankAccountController:: class, 'activeCBank']);

    Route::prefix('/transaction')->group(function () {
        Route::get('/payment', [PaymentTransactionController::class, 'index']);
        Route::get('/confirm-payment-transaction/{id}', [PaymentTransactionController::class, 'confirmPaymentTransaction']);
        Route::get('/void-payment-transaction/{id}', [PaymentTransactionController::class, 'voidPaymentTransaction']);
    });

    Route::prefix('/games')->group(function () {
        Route::get('/', [GamesController::class, 'index'])->name('games');
        Route::get('/active/{id}/{game_name}', [GamesController::class, 'active']);
        Route::get('/delete/{id}/{game_name}', [GamesController::class, 'delete']);
        Route::post('/create', [GamesController::class, 'create']);
        Route::post('/edit', [GamesController::class, 'edit']);

        Route::prefix('/groups')->group(function () {
            Route::get('/', [GameGroupsController::class, 'index'])->name('game_groups');
            Route::get('/delete/{id}/{group_name}', [GameGroupsController::class, 'delete']);
            Route::get('/{group_name}/{id}/game-list', [GameGroupsController::class, 'gameList']);
            Route::get('/active/{id}/{group_name}', [GameGroupsController::class, 'active']);
            Route::post('/create', [GameGroupsController::class, 'create']);
            Route::post('/edit', [GameGroupsController::class, 'edit']);
            Route::post('/game-transfer', [GameGroupsController::class, 'gameTransfer']);
            Route::post('/active', [GameGroupsController::class, 'groupActive']);
        });
    });

    Route::prefix('/football')->group(function () {
        Route::prefix('/leagues')->group(function () {
            Route::get('/', [FootballLeagueController::class, 'leagueIndex']);
            Route::get('/active/{id}/{league_name}', [FootballLeagueController::class, 'leagueActive']);
            Route::get('/delete/{id}/{league_name}', [FootballLeagueController::class, 'leagueDelete']);
            Route::post('/create', [FootballLeagueController::class, 'leagueCreate']);
            Route::post('/edit', [FootballLeagueController::class, 'leagueEdit']);
        });
        Route::prefix('/teams')->group(function () {
            Route::get('/', [FootballLeagueController::class, 'teamIndex']);
            Route::get('/{league_id}/{league_name}/list', [FootballLeagueController::class, 'leagueListTeam']);
            Route::get('/active/{id}/{team_name}', [FootballLeagueController::class, 'teamActive']);
            Route::get('/delete/{id}/{team_name}', [FootballLeagueController::class, 'teamDelete']);
            Route::post('/create', [FootballLeagueController::class, 'teamCreate']);
            Route::post('/edit', [FootballLeagueController::class, 'teamEdit']);
        });
        Route::prefix('/matchs')->group(function () {
            Route::get('/', [FootballLeagueController::class, 'matchIndex']);
            Route::get('/{league_id}/{league_name}/list', [FootballLeagueController::class, 'leagueListMatch']);
            Route::get('/delete/{id}', [FootballLeagueController::class, 'matchDelete']);
            Route::get('/end/{id}', [FootballLeagueController::class, 'matchEnd']);
            Route::post('/create', [FootballLeagueController::class, 'matchCreate']);
            Route::post('/edit', [FootballLeagueController::class, 'matchEdit']);
            Route::post('/update-score', [FootballLeagueController::class, 'matchUpdateScore']);
        });
    });
});
