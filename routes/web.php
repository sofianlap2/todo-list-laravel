<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\SecondTodoController;
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

    if(Auth::check()) {
        return redirect()->route('todo');
    } else {
        return redirect()->route('login.loginIndex');
    }
    //return view('welcome');
});

Route::get('register', [AuthController::class, 'index'])->name('register.index');
Route::post('register', [AuthController::class, 'inscription'])->name('register.inscription');
Route::get('login', [AuthController::class, 'loginIndex'])->name('login.loginIndex');
Route::post('login', [AuthController::class, 'doLogin'])->name('login.doLogin');
Route::delete('logout', [AuthController::class, 'logout'])->name('login.logout');

Route::get('profile/{id}', [AuthController::class, 'getProfile'])->name('profile.getProfile');
Route::put('profile/{id}', [AuthController::class, 'updateProfile'])->name('profile.updateProfile');



Route::resource('todo', SecondTodoController::class)->middleware('auth');

Route::get('todo/{todo}', [SecondTodoController::class, 'destroy'])->name('todo.destroy')->middleware('auth');