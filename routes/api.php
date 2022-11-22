<?php

use App\Http\Controllers\DeletePrescriptionController;
use App\Http\Controllers\DownloadPrescription;
use App\Http\Controllers\DownloadPrescriptionController;
use App\Http\Controllers\StoreSubmissionController;
use App\Http\Controllers\LoginController;
use App\Http\Controllers\RegisterController;
use App\Http\Controllers\UploadPrescriptionController;
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
Route::post('/submission', StoreSubmissionController::class)->name('submission.store')->middleware('auth:sanctum');
Route::post('login', LoginController::class)->name('user.login')->middleware('guest');
Route::post('register', RegisterController::class)->name('user.register')->middleware('guest');
Route::post('submission/{submission}/prescription', UploadPrescriptionController::class)->name('submission.prescription.upload')->middleware('auth:sanctum', 'submission.upload');
Route::get('submission/{submission}/prescription', DownloadPrescriptionController::class)->name('submission.prescription.download')->middleware('auth:sanctum', 'submission.download');
Route::delete('submission/{submission}/prescription', DeletePrescriptionController::class)->name('submission.prescription')->middleware('auth:sanctum', 'submission.delete');

