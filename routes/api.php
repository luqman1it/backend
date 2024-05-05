<?php


use App\Http\Controllers\AuthController;

use App\Http\Controllers\ProjectController;
use App\Http\Controllers\TypeController;
use Illuminate\Http\Request;
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

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

Route::controller(AuthController::class)->group(function () {
    Route::post('login', 'login');
    Route::post('register', 'register');
    Route::post('logout', 'logout')->middleware('auth:api');
    Route::post('refresh', 'refresh')->middleware('auth:api');

});



///////////ProjectRoutes//////////////
Route::controller(ProjectController::class)->group(function () {
    Route::get('/allprojects', 'index');
    Route::get('/showprojects/{project}', 'show');
    Route::post('/addprojects', 'store');
    Route::put('/editprojects/{project}', 'update');
    Route::delete('/deleteprojects/{project}', 'destroy');
});

////////////TypeRoutes///////////////
Route::controller(TypeController::class)->group(function () {
    Route::get('/alltypes', 'index');
    Route::get('/showtypes/{type}', 'show');
    Route::post('/addtypes', 'store');
    Route::put('/edittypes/{type}', 'update');
    Route::delete('/deletetype/{type}', 'destroy');
});

