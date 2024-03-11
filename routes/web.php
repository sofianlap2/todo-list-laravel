<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\TodoController;
use App\Http\Controllers\TodosController;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::get('/', function () {

    if (Auth::check()) {
        return redirect()->route('todo');
    } else {
        return redirect()->route('login.loginIndex');
    }
    //return view('welcome');
});

Route::get('register', [AuthController::class, 'index'])->middleware('guest')->name('register.index');
Route::post('register', [AuthController::class, 'inscription'])->middleware('guest')->name('register.inscription');
Route::get('login', [AuthController::class, 'loginIndex'])->middleware('guest')->name('login.loginIndex');
Route::post('login', [AuthController::class, 'doLogin'])->middleware('guest')->name('login.doLogin');
Route::delete('logout', [AuthController::class, 'logout'])->middleware('guest')->name('login.logout');

Route::get('profile/{id}', [AuthController::class, 'getProfile'])->name('profile.getProfile')->middleware('auth')->middleware('role:user');
Route::put('profile/{id}', [AuthController::class, 'updateProfile'])->name('profile.updateProfile')->middleware('auth')->middleware('role:user');



Route::resource('todo', TodoController::class)->middleware('auth')->middleware('role:user');

Route::get('todo/{todo}', [TodoController::class, 'destroy'])->name('todo.destroy')->middleware('auth')->middleware('role:user');

Route::resource('todos', TodosController::class)->middleware('auth')->middleware('role:admin');

Route::get('/forgot-password', [AuthController::class, 'forgotPasswordIndex'])->middleware('guest')->name('password.request');

Route::post('/forgot-password', [AuthController::class, 'forgotPasswordSend'])->middleware('guest')->name('password.email');

Route::get('/reset-password/{token}', [AuthController::class, 'resetPassword'])->middleware('guest')->name('password.reset');

Route::get('/reset-password', [AuthController::class, 'changePassword'])->middleware('guest')->name('password.update');
