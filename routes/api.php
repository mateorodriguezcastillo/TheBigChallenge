<?php

use App\Http\Controllers\AcceptSubmissionController;
use App\Http\Controllers\LoginController;
use App\Http\Controllers\GetSubmissionController;
use App\Http\Controllers\GetSubmissionsController;
use App\Http\Controllers\GetUserSubmissionsController;
use App\Http\Controllers\LogoutController;
use App\Http\Controllers\RegisterController;
use App\Http\Controllers\StoreSubmissionController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});
Route::prefix('/submission')
->name('submission.')
->group(function () {
  Route::get('/{submission}', GetSubmissionController::class)->name('show')->middleware('auth:sanctum', 'submission.show');
  Route::post('/', StoreSubmissionController::class)->name('store')->middleware('auth:sanctum');
  Route::put('/{submission}/accept', AcceptSubmissionController::class)->name('accept')->middleware('auth:sanctum', 'submission.accept');
  Route::get('/', GetSubmissionsController::class)->name('index')->middleware('auth:sanctum');
  Route::get('/user/{user}', GetUserSubmissionsController::class)->name('user')->middleware('auth:sanctum', 'submission.user');
});
Route::post('/logout', LogoutController::class)->middleware('auth:sanctum')->name('user.logout');
Route::post('login', LoginController::class)->name('user.login')->middleware('guest');
Route::post('register', RegisterController::class)->name('user.register')->middleware('guest');

