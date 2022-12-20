<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\HomeController;

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

Route::get('/{path?}', function () {
    return view('home');
})->where('path', '^(?!api).*?');

Route::group(['prefix' => 'api'], function () {

    Route::get('/login', [AuthController::class, 'showLogin'])->name('user.login.page');
    Route::post('/login', [AuthController::class, 'login'])->name('user.login');
    Route::get('/register', [AuthController::class, 'showRegister'])->name('user.register.page');
    Route::post('/register', [AuthController::class, 'register'])->name('user.register');
    Route::get('home', [HomeController::class, 'index'])->name('home');


    // Route::post('/register', [\App\Http\Controllers\Api\RegisterController::class, 'register']);
    // Route::get('account/verify/{token}', [App\Http\Controllers\Api\RegisterController::class,'verifyAccount'])->name('user.verify');
    Route::middleware(['auth', 'is-active'])->group(function () {      
        Route::get('/signout', [AuthController::class, 'signout'])->name('user.signout');
    });
});