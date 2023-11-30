<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\TestController;

use App\Http\Controllers\Api\AuthController;
use App\Http\Controllers\Api\V1\CriteriaContoller;
use App\Http\Controllers\Api\V1\RoleController;
use App\Http\Controllers\Api\v1\UserController;
use App\Http\Controllers\Api\V1\RatingContoller;
use App\Http\Controllers\Api\v1\EntityController;
use App\Http\Controllers\Api\v1\DashboardController;
use App\Http\Controllers\Api\V1\EvaluateeController;
use App\Http\Controllers\Api\v1\DepartmentController;
use App\Http\Controllers\Api\V1\QuestionaireContoller;
use App\Http\Controllers\Api\V1\SectionYearController;
use App\Http\Controllers\Api\v1\SubjectController;
use App\Http\Controllers\Api\v1\UserInfoController;

Route::group(['prefix'=>'v1','middleware'=>'auth:sanctum'],function(){

    Route::get('/questionaires/with-criterias',[QuestionaireContoller::class,'withCriterias']);
    Route::post('/questionaires/for-evaluatee',[QuestionaireContoller::class,'forEvaluatee']);
    Route::get('/questionaires/latest-questionaire',[QuestionaireContoller::class,'latestQuestionaire']);
    Route::apiResource('questionaires',QuestionaireContoller::class);
    Route::patch('/questionaires/{questionaire}/update-status',[QuestionaireContoller::class,'updateStatus']);

    // Route::get()
    Route::apiResource('criterias',CriteriaContoller::class);
    Route::get('/criterias/{criteria}/questions',[CriteriaContoller::class,'withQuestions']);


    Route::apiResource('evaluatees',EvaluateeController::class)->only(['index','store','destroy']);
    Route::post('evaluatees/evaluated',[EvaluateeController::class,'evaluated']);
    Route::post('evaluatees/evaluatee-info',[EvaluateeController::class,'evaluateeInfo']);
    Route::post('evaluatees/{user}/evaluatees-to-rate',[EvaluateeController::class,'getEvaluateesToRate']);


    Route::apiResource('entities',EntityController::class);



    Route::post('/ratings',[RatingContoller::class,'store']);

    Route::apiResource('departments',DepartmentController::class);

    Route::apiResource('roles',RoleController::class)->only(['index']);

    Route::apiResource('users',UserController::class)->only(['index','store']);
    Route::get('users/user-infos',[UserController::class,'getUserInfos']);
    Route::get('users/user',[UserController::class,'getUser']);

    Route::apiResource('user-infos',UserInfoController::class)->except(['index','show']);
    Route::get('/user-infos',[UserInfoController::class,'showDetails']);


    Route::apiResource('subjects',SubjectController::class);


    Route::apiResource('section-year',SectionYearController::class);

    Route::get('/dashboard/admin',[DashboardController::class,'admin']);
    Route::get('/dashboard/user',[DashboardController::class,'user']);

});

Route::prefix('auth')->controller(AuthController::class)->group(function(){
    Route::post('/login','login');
    Route::post('/logout','logout')->middleware('auth:sanctum');
});


Route::get('/test',[TestController::class,'testModel']);
