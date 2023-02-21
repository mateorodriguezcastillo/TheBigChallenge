<?php

use App\Http\Controllers\DeletePrescriptionController;
use App\Http\Controllers\DownloadPrescriptionController;
use App\Http\Controllers\StoreSubmissionController;
use App\Http\Controllers\AcceptSubmissionController;
use App\Http\Controllers\CompleteProfileController;
use App\Http\Controllers\LoginController;
use App\Http\Controllers\GetSubmissionController;
use App\Http\Controllers\GetSubmissionsController;
use App\Http\Controllers\GetUserSubmissionsController;
use App\Http\Controllers\LogoutController;
use App\Http\Controllers\RegisterController;
use App\Http\Controllers\VerifyEmailController;
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
Route::get('email/verify/{user}/{hash}', VerifyEmailController::class)->name('verification.verify')->middleware('guest');
Route::post('complete-profile', CompleteProfileController::class)->name('user.complete-profile')->middleware('auth:sanctum');
Route::post('submission/{submission}/prescription', UploadPrescriptionController::class)->name('submission.prescription.upload')->middleware('auth:sanctum', 'submission.upload');
Route::get('submission/{submission}/prescription', DownloadPrescriptionController::class)->name('submission.prescription.download')->middleware('auth:sanctum', 'submission.download');
Route::delete('submission/{submission}/prescription', DeletePrescriptionController::class)->name('submission.prescription')->middleware('auth:sanctum', 'submission.delete');


// Route::get('/{adress}', function ($adress) {
//     $array = explode(',', $adress);
//     $array2 = explode(' ', $array[2]);
//     $state = $array2[1];
//     if ($state == 'OH') {
//         return [
//             ["label" => 'Ault Care Insurance CO', "value" => 'ACICO'],
//             ["label" => 'Care Soruce', "value" => 'CS'],
//             ["label" => 'Med Mutual', "value" => 'MM'],
//             ["label" => 'Molina Healthcare', "value" => 'MH'],
//             ["label" => 'Oscar Health Insurance', "value" => 'OHI'],
//             ["label" => 'United Healthcare', "value" => 'UHC'],
//             ["label" => 'Wellcare', "value" => 'WC'],
//             ["label" => 'Other', "value" => 'Other'],
//         ];
//     } else {
//         return [
//             ["label" => 'Ault Care Insurance CO', "value" => 'ACICO'],
//         ];
//     }
// })->name('adress');


// Route::get('/aux/choices', function () {
//     return [
//         [
//             'label' => "Man",
//             'value' => 'man'
//         ],
//         [
//             'label' => "Woman",
//             'value' => 'woman'
//         ],
//         [
//             'label' => "Non-binary",
//             'value' => 'non-binary'
//         ],
//         [
//             'label' => "Other",
//             'value' => 'other'
//         ],
//     ];
// })->name('choices');
