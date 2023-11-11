<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\TestController;
use App\Http\Controllers\Api\AuthController;
use App\Http\Controllers\Api\V1\RoleController;
use App\Http\Controllers\Api\v1\UserController;
use App\Http\Controllers\Api\V1\RatingContoller;
use App\Http\Controllers\Api\V1\EvaluateeController;
use App\Http\Controllers\Api\v1\DepartmentController;
use App\Http\Controllers\Api\V1\QuestionaireContoller;

Route::group(['prefix'=>'v1','middleware'=>'auth:sanctum'],function(){

    Route::apiResource('questionaires',QuestionaireContoller::class)->only(['index']);
    Route::get('/questionaires/latest',[QuestionaireContoller::class,'latestQuestionaire']);
    Route::post('/questionaires/for-evaluatee',[QuestionaireContoller::class,'forEvaluatee']);


    Route::apiResource('evaluatees',EvaluateeController::class);
    Route::post('evaluatees/evaluated',[EvaluateeController::class,'evaluated']);


    Route::post('/rating',[RatingContoller::class,'store'])->withoutMiddleware('auth:sanctum');

    Route::apiResource('departments',DepartmentController::class)->only(['index'])->withoutMiddleware('auth:sanctum');

    Route::apiResource('roles',RoleController::class)->only(['index'])->withoutMiddleware('auth:sanctum');

    Route::apiResource('users',UserController::class)->only(['index']);
    // Route::get('users/user-info',[UserController::class,'getUserInfo']);
    Route::get('users/user',[UserController::class,'getUser']);
    Route::post('users/{user}/evaluatees-to-rate',[UserController::class,'getEvaluateesToRate']);
    // Route::post('users/evaluatees-to-rate',[UserController::class,'getEvaluateesToRate']);

});

Route::prefix('auth')->controller(AuthController::class)->group(function(){
    Route::post('/login','login');
    Route::post('/logout','logout')->middleware('auth:sanctum');
});


Route::get('/test',[TestController::class,'testModel']);
