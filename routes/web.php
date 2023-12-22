<?php

use Illuminate\Support\Facades\Route;
// use App\Http\Controllers\Api\QuestionContoller;
use App\Http\Controllers\TestController;
use App\Http\Controllers\Auth\AuthController;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\InstructorController;
use App\Http\Controllers\Auth\LogoutController;
use App\Http\Controllers\QuestionaireController;
use App\Http\Controllers\Api\V1\QuestionContoller;


// /*
// |--------------------------------------------------------------------------
// | Web Routes
// |--------------------------------------------------------------------------
// |
// | Here is where you can register web routes for your application. These
// | routes are loaded by the RouteServiceProvider and all of them will
// | be assigned to the "web" middleware group. Make something great!
// |
// */

// Route::get('/', function () {
//     return view('welcome');
// });
Route::get('/test',[TestController::class,'testRating']);
// Route::get('/questionaires',[QuestionaireController::class,'index']);
// Route::resource('questionaires.questions',QuestionContoller::class)->only(['index']);
// // // Route::get('/instructors/{$id}',[InstructorController::class,'index'])->name('instructors');
// // // Route::resource('questionaires',QuestionaireContoller::class)->only(['index']);

// Route::get('/instructors',[InstructorController::class,'index']);
// Route::get('/instructors/{id}/evaluation-form',[InstructorController::class,'show'])->name('evaluation-form');
// Route::get('/instructors/{id}/question/{question}/evaluation-form',[InstructorController::class,'showForm'])->name('evaluation-form-question');



// Route::prefix('auth')->group(function () {
//     Route::post('/login', LoginController::class)->middleware('guest');
//     Route::post('/logout', LogoutController::class)->middleware('auth:sanctum');
// });

Route::prefix('auth')->controller(AuthController::class)->group(function(){
    Route::post('/login','login');
    Route::post('/logout','logout')->middleware('auth:sanctum');
});
