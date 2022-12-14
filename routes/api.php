<?php

use App\Http\Controllers\ActivityController;
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
    Route::get('/quiz/all', [LessonController::class, 'fetchQuizzes']);
    Route::post('/quiz/attempt', [LessonController::class, 'attemptQuiz']);
    Route::get('/quizlog', [LessonController::class, 'fetchQuizlog']);
    Route::get('/quiz/questions', [LessonController::class, 'fetchQuizQuestionsWithChoices']);
    Route::post('/question/answer', [LessonController::class, 'answerQuestionItem']);
    Route::get('/quiz/{id}', [LessonController::class, 'fetchQuiz']);
    Route::post('/save-all-answers', [LessonController::class, 'saveAllAnswers']);
    Route::get('/quiz-results', [LessonController::class, 'fetchQuizResults']);

    //ACTIVITY
    Route::get('/activities', [ActivityController::class, 'fetchUserActivities']);
    Route::get('/all-activities', [ActivityController::class, 'fetchAllUsersActivities']);
}); 
