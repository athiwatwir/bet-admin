<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AccountSettingController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\UsersController;
use App\Http\Controllers\MembersController;
use App\Http\Controllers\AdminsController;

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
    return view('Auth\login');
})->name('login');

Auth::routes();

// Route::get('/home', 'HomeController@index')->name('home');

Route::middleware(['admin'])->group(function () {
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');

    Route::get('/account-setting', [AccountSettingController::class, 'index'])->name('account-setting');
    Route::post('/account-setting/update/{id}', [AccountSettingController::class, 'update']);
    Route::post('/account-setting/change-password/{id}', [AccountSettingController::class , 'changePassword']);

    Route::get('/users', [UsersController::class, 'index'])->name('users');
    Route::get('/users/active/{id}/{username}', [UsersController::class, 'active']);
    Route::get('/users/delete/{id}/{username}', [UsersController::class, 'delete']);
    Route::get('/users/view/{id}', [UsersController::class, 'view'])->name('view');

    Route::get('/admins', [AdminsController::class, 'index'])->name('admins');
    Route::get('/admins/active/{id}/{username}', [AdminsController::class, 'active']);
    Route::get('/admins/delete/{id}/{username}', [AdminsController::class, 'delete']);
    Route::post('/admins/register', [AdminsController::class, 'register']);

    Route::get('/members', [MembersController::class, 'index'])->name('members');
});
