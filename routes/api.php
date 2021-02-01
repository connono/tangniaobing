<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\VerificationCodesController;
use App\Http\Controllers\Api\UsersController;
use App\Http\Controllers\Api\CaptchasController;

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

//Route::middleware('auth:api')->get('/user', function (Request $request) {
//    return $request->user();
//});

Route::prefix('v1')
    ->name('api.v1.')
    ->middleware('throttle:1' . config('api.rate_limits.sign'))
    ->group(function() {
        Route::get('version', function() {
            return 'this is verison v1';
        })->name('version');
        // 短信验证码
        Route::post('verificationCodes', [VerificationCodesController::class, 'store']);
        Route::post('users', [UsersController::class, 'store']);
        Route::post('captchas', [CaptchasController::class, 'store']);
});
