<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\VerificationCodesController;
use App\Http\Controllers\Api\UsersController;
use App\Http\Controllers\Api\CaptchasController;
use App\Http\Controllers\Api\AuthorizationsController;
use App\Http\Controllers\Api\InformationController;
use App\Http\Controllers\Api\BloodGlucoseController;
use App\Http\Controllers\Api\FoodController;
use App\Http\Controllers\Api\ComplicationController;
use App\Http\Controllers\Api\RecipeController;

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
        // 注册用户
        Route::post('users', [UsersController::class, 'store']);
        // 图片验证码
        Route::post('captchas', [CaptchasController::class, 'store']);
        // 获取 JWT token
        Route::post('authorizations', [AuthorizationsController::class, 'store']);
        Route::put('authorizations/current', [AuthorizationsController::class, 'update']);
        Route::delete('authorizations/current', [AuthorizationsController::class, 'destroy']);

        Route::middleware('auth:api')->group(function() {

            Route::get('user', [UsersController::class, 'show']);
            
            Route::post('information', [InformationController::class, 'store']);
            Route::patch('information', [InformationController::class, 'update']);
            Route::get('information', [InformationController::class, 'show']);

            Route::post('blood_glucose', [BloodGlucoseController::class, 'store']);
            Route::get('blood_glucose', [BloodGlucoseController::class, 'show']);

            Route::get('food', [FoodController::class, 'show']);
            Route::post('food', [FoodController::class, 'store']);
            Route::patch('food', [FoodController::class, 'update']);
            Route::delete('food', [FoodController::class, 'delete']);

            Route::get('complication', [ComplicationController::class, 'show']);
            Route::post('complication', [ComplicationController::class, 'store']);
            Route::patch('complication', [ComplicationController::class, 'update']);
            Route::delete('complication', [ComplicationController::class, 'delete']);

            Route::get('recipeStore', [RecipeController::class, 'store']);
            Route::get('recipe', [RecipeController::class, 'show']);
        });
});
