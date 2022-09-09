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
    // attempt quiz with quiz_id and current_user_id
    public function attemptQuiz(Request $request) 
    {
        $user_id = Auth::id();

        Quizlog::create([
            'user_id' => $user_id,
            'quiz_id' => $request->quiz_id,
        ]);

        return response()->json('New quizlog created!');
    }

    // fetch set of questions based on quiz_id
    public function fetchQuizQuestions(Request $request)
    {
        $question_set = Question::where('quiz_id', $request->quiz_id)->paginate(2);

        return response()->json($question_set);
    }

    // fetch the three choices based on question_id
    public function fetchQuestionChoices(Request $request)
    {
        $choices = Choice::where('question_id', $request->question_id)->get();

        return response()->json($choices);
    }

    // answer question item
    public function answerQuestionItem(Request $request) 
    {   
        $answer = Answer::create([
            'question_id' => $request->question_id,
            'quizlog_id' => $request->quizlog_id,
            'choice_id' => $request->choice_id,
        ]);

        $data = [
            'answer' => $answer
        ];

        return response()->json($data);
    }

    // fetch quiz results
    public function fetchQuizResults(Request $request)
    {
        $answerCount = Answer::where('quizlog_id', $request->quizlog_id)
            ->whereHas('choice', function ($query) {
                $query->where('is_correct', 1);
            })
            ->count();

        $data = [
            'correct_answers' => $answerCount
        ];

        return response()->json($data);
    }
}
