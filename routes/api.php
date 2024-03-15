<?php

use Illuminate\Http\Request;
use App\Http\Controllers\ApiControllers\TodoControllerApi;
use App\Http\Controllers\AuthControllerApi as ControllersAuthControllerApi;
use App\Http\Controllers\TodoControllerApi as ControllersTodoControllerApi;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/

/*Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});*/


Route::post('register', [ControllersAuthControllerApi::class, 'inscription'])->name('apiregister.inscription');
Route::post('login', [ControllersAuthControllerApi::class, 'doLogin'])->name('apilogin.doLogin');
Route::delete('logout', [ControllersAuthControllerApi::class, 'logout'])->name('apilogin.logout');


Route::middleware('auth:sanctum')->resource('todo', ControllersTodoControllerApi::class);

Route::middleware('auth:sanctum')->get('todo/{todo}', [ControllersTodoControllerApi::class, 'destroy'])->name('apitodo.destroy');

//Route::resource('todos', TodosController::class)->middleware('auth')->middleware('role:admin');