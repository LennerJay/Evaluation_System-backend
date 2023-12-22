<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\TestController;
use App\Http\Controllers\Api\AuthController;
use App\Http\Controllers\Api\v1\ClassController;
use App\Http\Controllers\Api\V1\RoleController;
use App\Http\Controllers\Api\v1\UserController;
use App\Http\Controllers\Api\V1\RatingContoller;
use App\Http\Controllers\Api\v1\EntityController;
use App\Http\Controllers\Api\V1\CriteriaContoller;
use App\Http\Controllers\Api\V1\QuestionContoller;
use App\Http\Controllers\Api\v1\SubjectController;
use App\Http\Controllers\Api\v1\UserInfoController;
use App\Http\Controllers\Api\v1\DashboardController;
use App\Http\Controllers\Api\V1\EvaluateeController;
use App\Http\Controllers\Api\v1\DepartmentController;
use App\Http\Controllers\Api\V1\QuestionaireContoller;
use App\Http\Controllers\Api\V1\SectionYearController;

Route::group(['prefix'=>'v1','middleware'=>'auth:sanctum'],function(){


    Route::post('/questionaires/for-evaluatee',[QuestionaireContoller::class,'forEvaluatee']);
    Route::get('/questionaires/max-respondents',[QuestionaireContoller::class,'getMaxRespondents']);
    Route::get('/questionaires/latest-questionaire',[QuestionaireContoller::class,'latestQuestionaire']);
    Route::apiResource('questionaires',QuestionaireContoller::class);
    Route::patch('/questionaires/{questionaire}/update-status',[QuestionaireContoller::class,'updateStatus']);
    Route::get('/questionaires/{questionaire}/with-criterias',[QuestionaireContoller::class,'withCriterias']);
    Route::post('/questionaires/{questionaire}/remove-criterias',[QuestionaireContoller::class,'removeCriteria']);


    Route::post('questions/by-criteria',[QuestionContoller::class,'getQuestionByCriteria']);
    Route::apiResource('questions',QuestionContoller::class)->only('store','update','destroy');


    Route::apiResource('evaluatees',EvaluateeController::class)->except('show');
    Route::post('evaluatees/evaluated',[EvaluateeController::class,'evaluated']);
    Route::post('evaluatees/evaluatee-info',[EvaluateeController::class,'evaluateeInfo']);

    Route::group(['prefix' => 'class','middleware' => 'isAdminStaff'],function(){
        Route::post('/store',[ClassController::class,'storeClass']);
        Route::post('/delete',[ClassController::class,'deleteClass']);
        Route::put('/update',[ClassController::class,'updateClass']);
    });


    Route::apiResource('entities',EntityController::class);
    Route::apiResource('departments',DepartmentController::class);
    Route::apiResource('roles',RoleController::class)->only(['index']);
    Route::apiResource('subjects',SubjectController::class);
    Route::apiResource('section-year',SectionYearController::class);
    Route::apiResource('criterias',CriteriaContoller::class);


    Route::post('/ratings',[RatingContoller::class,'store']);
    Route::post('ratings/outcomes' ,[RatingContoller::class,'outcomeRatings']);
    Route::post('/ratings/summary',[RatingContoller::class,'getRatingsSummary']);
    Route::post('/ratings/rating-info',[RatingContoller::class,'getRatingInfo']);

    Route::apiResource('users',UserController::class)->except(['show']);
    // Route::get('users/user-infos',[UserController::class,'getUserInfos']);
    Route::get('users/user',[UserController::class,'getUser']);
    Route::get('users/evaluatees-to-rate',[UserController::class,'getEvaluateesToRate']);
    Route::post('users/change-password',[UserController::class,'changePassword']);
    Route::post('users/{user}/reset-password',[UserController::class,'resetPassword']);


    Route::controller(UserInfoController::class)->group(function(){
        Route::post('/user-infos','showDetails');
        Route::post('/user-infos/store','store');
        Route::delete('/user-infos/{userInfo}','destroy');

    });


    Route::get('/dashboard/admin',[DashboardController::class,'admin']);
    Route::get('/dashboard/user',[DashboardController::class,'user']);

});

Route::prefix('auth')->controller(AuthController::class)->group(function(){
    Route::post('/login','login');
    Route::post('/logout','logout')->middleware('auth:sanctum');
});


Route::get('/test',[TestController::class,'testModel']);
