<?php

use App\Http\Controllers\userController;
use App\Http\Controllers\userDataController;
use App\Http\Middleware\TokenVerificationMiddleware;
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
Route::post('/user-registration', [userController::class, 'userRegistration']);
Route::post('/user-login', [userController::class, 'userLogin']);
Route::post('/sentotp', [userController::class, 'sendOtpCode']);
Route::post('/otpverify', [userController::class, 'verifyOtp']);

//token verify
Route::post('/resetpassword', [userController::class, 'resetPassword'])->middleware([TokenVerificationMiddleware::class]);

Route::get('/', function () {
    view('pages.welcome');
});
Route::get('/',[UserController::class,'signupPage']);
