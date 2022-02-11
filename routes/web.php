<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Auth\AdminController;
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
use App\Http\Controllers\ReportsController;
use App\Http\Controllers\UserLevelController;
use App\Http\Controllers\BankGroupController;
use App\Http\Controllers\StaffRolesController;
use App\Http\Controllers\AdjustController;
use App\Http\Controllers\ApiSettingController;
use App\Http\Controllers\ApiGameController;

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

Route::get('/unauthenticated', function () {
    return view('unauthenticated');
})->name('unauthenticated');

Auth::routes();

// Route::get('/home', 'HomeController@index')->name('home');

Route::post('/login', [AdminController::class, 'adminLogin']);

Route::middleware(['auth:webadmin'])->group(function () {
    Route::get('/logout', [AdminController::class, 'adminLogout'])->name('admin-logout');

    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');
    Route::get('/test-helper', [DashboardController::class, 'testHelper']);

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
        Route::post('/change-password', [AdminsController::class, 'changePassword']);

        Route::get('/role', [StaffRolesController::class, 'index'])->name('role');
        Route::get('/role/create', [StaffRolesController::class, 'create'])->name('role-create');
        Route::post('/role/create', [StaffRolesController::class, 'store'])->name('role-store');
        Route::get('/role/edit/{id}', [StaffRolesController::class, 'edit'])->name('role-edit');
        Route::post('/role/update', [StaffRolesController::class , 'update'])->name('role-update');
        Route::get('/role/delete/{id}', [StaffRolesController::class, 'delete'])->name('role-delete');
        Route::get('/role/active/{id}', [StaffRolesController::class, 'active'])->name('role-active');
    });

    Route::get('/members', [MembersController::class, 'index'])->name('members');

    Route::prefix('/user-levels')->group(function () {
        Route::get('/', [UserLevelController::class, 'index']);
        Route::post('/create', [UserLevelController::class, 'create']);
        Route::post('/edit', [UserLevelController::class, 'update']);
        Route::get('/delete/{id}', [UserLevelController::class, 'delete']);
        Route::get('/active/{id}/{name}', [UserLevelController::class, 'active']);

        Route::Post('/setting-api-game', [UserLevelController::class, 'settingApiGame'])->name('userlevel-setting-api-game');
    });

    Route::prefix('/settings')->group(function () {
        Route::prefix('/bank-groups')->group(function () {
            Route::get('/', [BankGroupController::class, 'index'])->name('bankgroups');
            Route::post('/', [BankGroupController::class, 'create']);
            Route::post('/edit', [BankGroupController::class, 'edit']);
            Route::get('/delete/{id}', [BankGroupController::class, 'delete'])->name('bankgroup-delete');
            Route::get('/active/{id}', [BankGroupController::class, 'active']);

            Route::get('/view/{id}', [BankGroupController::class, 'view'])->name('bankgroup-view');
            Route::post('/add', [BankGroupController::class, 'add']);
            Route::get('/cancle/{id}', [BankGroupController::class, 'cancle']);
            Route::post('/transfer', [BankGroupController::class, 'transfer']);
        });

        Route::prefix('/api')->group(function () {
            Route::prefix('/games')->group(function () {
                Route::get('/', [ApiGameController::class, 'index'])->name('setting-api-game-index');
                Route::post('/', [ApiGameController::class, 'create'])->name('setting-api-game-create');
                Route::get('/edit/{id}', [ApiGameController::class, 'edit'])->name('setting-api-game-edit');
                Route::get('/active/{id}', [ApiGameController::class, 'active'])->name('setting-api-game-active');

                Route::post('/update-game', [ApiGameController::class, 'updateGameDetail'])->name('setting-api-game-update-name');
                Route::post('/update-config', [ApiGameController::class, 'updateConfig'])->name('setting-api-game-update-config');
                Route::post('/update-api', [ApiGameController::class, 'updateApi'])->name('setting-api-game-update-api-domain');
                Route::post('/update-token', [ApiGameController::class, 'updateToken'])->name('setting-api-game-update-token');

                Route::post('/add-api', [ApiGameController::class, 'addApi'])->name('setting-api-game-add-api-domain');
                Route::post('/add-token', [ApiGameController::class, 'addToken'])->name('setting-api-game-add-api-token');
            });
            Route::get('/user-level', [ApiSettingController::class, 'userLevelIndex'])->name('setting-api-userlevel-index');
        });
    });

    Route::get('/cbank', [CBankAccountController::class, 'index'])->name('cbank');

    Route::prefix('/reports')->group(function () {
        Route::get('/', [ReportsController::class, 'index'])->name('reports');
        Route::get('/search', [ReportsController::class, 'search']);
        Route::get('/games/index', [ReportsController::class, 'indexGameReport'])->name('report-game-index');
        Route::get('/games/view/{gamecode}', [ReportsController::class, 'viewGameReport'])->name('game-view-report');

        Route::get('/pgsoft', [ReportsController::class, 'pgsoft']);
        Route::get('/pgsoft/view/{player}', [ReportsController::class, 'pgsoftByPlayer'])->name('player-report');
        Route::get('/pgsoft/search', [ReportsController::class, 'searchPgSoft']);
    });

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
        Route::get('/payment', [PaymentTransactionController::class, 'index'])->name('transaction-all');
        Route::get('/payment-adjust', [PaymentTransactionController::class, 'adjust']);
        Route::get('/confirm-payment-transaction/{id}', [PaymentTransactionController::class, 'confirmPaymentTransaction']);
        Route::get('/void-payment-transaction/{id}', [PaymentTransactionController::class, 'voidPaymentTransaction']);

        Route::get('/deposit', [PaymentTransactionController::class, 'deposit'])->name('transaction-deposit');
        Route::get('/transfer', [PaymentTransactionController::class, 'transfer'])->name('transaction-transfer');
        Route::get('/withdraw', [PaymentTransactionController::class, 'withdraw'])->name('transaction-withdraw');
        Route::get('/adjust', [PaymentTransactionController::class, 'adjust'])->name('transaction-adjust');

        Route::post('/promotion-adjust', [WalletsController::class, 'promotionWalletAmount']);
    });

    Route::prefix('/adjust')->group(function () {
        Route::get('/', [AdjustController::class, 'index'])->name('adjust-index');
        Route::get('/update/{id}', [AdjustController::class, 'update'])->name('adjust-confirm');
        Route::get('/void/{id}', [AdjustController::class, 'void'])->name('adjust-void');
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
