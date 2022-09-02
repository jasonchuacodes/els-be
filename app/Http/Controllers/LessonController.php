<?php

namespace App\Http\Controllers;

use App\Models\Answer;
use App\Models\Choice;
use App\Models\Question;
use App\Models\Quiz;
use App\Models\Quizlog;
use Illuminate\Contracts\Database\Eloquent\Builder;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class LessonController extends Controller
{
    // fetch all quizzes
    public function fetchQuizzes()
    {
        $quizzes = Quiz::all();

        return response()->json($quizzes);
    }

    // fetch quiz
    public function fetchQuiz($id)
    {
        $quiz = Quiz::find($id);

        return response()->json($quiz);
    }

    // fetch all questions
    public function fetchAllQuestions()
    {
        $questions = Question::all();

        return response()->json($questions);
    }

    // fetch questions based on quiz_id
    public function fetchQuizQuestions($id)
    {
        $quiz = Quiz::with('questions')
            ->where('id', $id)
            ->get();

        return response()->json($quiz);
    }

    // fetch choices based on question_id
    public function fetchQuestion($id)
    {
        $question = Question::with('choices')
            ->where('id', $id)
            ->get();

        return response()->json($question);
    }

    public function fetchAnswers(Request $request)
    {
        $user_id = Auth::id();
        $user_answers = Quizlog::with('answers')->where('user_id', $user_id)->get();

        return response()->json($user_answers);
    }

    public function fetchChoices()
    {
        $choices = Choice::all();

        return response()->json($choices);
    }
    // display quiz results if correct or incorrect
    public function fetchQuizResults($id)
    {
        // $answers = Answer::where('quizlog_id', $id)->get();

        // $correct = 0;
        // foreach ($answers as $answer) {
        //     $choice = Choice::where(
        //         'id',
        //         $answer->choice_id
        //     )->where('is_correct', 1)->get();
        //     $correct += $choice->count();
        // }

        $answerCount = Answer::where('quizlog_id', $id)->whereHas('choice', function ($query) {
            $query->where('is_correct', 1);
        })->get();

        $data = [
            'correct_answers' => $answerCount //2
        ];

        return response()->json($data);
    }
}
