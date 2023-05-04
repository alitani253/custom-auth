<?php

use App\Http\Controllers\AuthManager;
use App\Http\Controllers\ForgetPasswordManager;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;
use Symfony\Component\HttpKernel\Profiler\Profile;

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
    return view('welcome');
})->name('home');


Route::get('/login',[AuthManager::class,'login'])->name('login');
Route::post('/login',[AuthManager::class,'loginPost'])->name('login.post');
Route::get('/registration', [AuthManager::class,'registration'])->name('registration');
Route::post('/registration',[AuthManager::class,'registrationPost'])->name('registration.post');
Route::get('/logout',[AuthManager::class,'logout'])->name('logout');
Route::group(['middlweare'=>'auth'], function(){
    Route::get('/Profile', function(){
        return "Profile Test";
    });
});
Route::get('/forget-password',[ForgetPasswordManager::class, 'forgetPassword'])->name('forget.password');
Route::post('/forget-password',[ForgetPasswordManager::class, 'forgetPasswordPost'])->name('forget.password.post');
Route::get('/reset-password/{token}',[ForgetPasswordManager::class, 'resetPassword'])->name('reset.password');
Route::post('/reset-password',[ForgetPasswordManager::class, 'resetPasswordPost'])->name('reset.password.post');


