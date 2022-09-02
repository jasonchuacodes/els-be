<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\FollowingController;
use App\Http\Controllers\LessonController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\VerificationController;
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

// Public Routes
Route::post('/register', [AuthController::class, 'register']);
Route::post('/login', [AuthController::class, 'login']);
Route::get('/users', [UserController::class, 'index']);

Route::get('/verify', [VerificationController::class, 'verify'])
    ->name('verification.verify');
Route::post('/verification-notification', [VerificationController::class, 'resend'])
    ->middleware(['throttle:6,1'])
    ->name('verification.send');

// Private
Route::middleware('auth:sanctum')->group(function () {
    Route::get('/users/{id}', [UserController::class, 'show']);
    Route::post('/logout', [AuthController::class, 'logout']);

    // FOLLOW
    Route::post('/{id}/follow', [FollowingController::class, 'follow']);
    Route::get('/{id}/is-following', [FollowingController::class, 'isFollowing']);
    Route::post('/{id}/unfollow', [FollowingController::class, 'unfollow']);
    Route::get('/{id}/followers', [FollowingController::class, 'followers']);
    Route::get('/{id}/followings', [FollowingController::class, 'followings']);

    // LESSON
    Route::get('/all-quizzes', [LessonController::class, 'fetchQuizzes']);
    Route::get('/quiz/{id}', [LessonController::class, 'fetchQuiz']);
    Route::get('/all-questions', [LessonController::class, 'fetchAllQuestions']);
    Route::get('/quiz/{id}/questions', [LessonController::class, 'fetchQuizQuestions']);
    Route::get('/question/{id}', [LessonController::class, 'fetchQuestion']);

    Route::get('/choices', [LessonController::class, 'fetchChoices']);
    Route::get('/answers', [LessonController::class, 'fetchAnswers']);
    Route::get('/check', [LessonController::class, 'quizloganswers']);

    Route::get('/quiz/{id}/results', [LessonController::class, 'fetchQuizResults']);
});
