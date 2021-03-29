<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AccountSettingController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\UsersController;

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
Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');

Route::middleware(['auth'])->group(function () {
    Route::get('/account-setting', [AccountSettingController::class, 'index'])->name('account-setting');
    Route::post('/account-setting/update/{id}', [AccountSettingController::class, 'update']);
    Route::post('/account-setting/change-password/{id}', [AccountSettingController::class , 'changePassword']);

    Route::get('/users', [UsersController::class, 'index'])->name('users');
});
