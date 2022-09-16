<?php

namespace App\Http\Controllers;

use App\Models\Activity;
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
    public function fetchQuizzes()
    {
        $user = Auth::user();

        if ($user) {
            $quiz = Quiz::all();
        } else {
            return response()->json('Unauthorized user. Please log in');
        }

        return response()->json($quiz);
    }

    // attempt quiz with quiz_id and current_user_id
    public function attemptQuiz(Request $request)
    {
        $user_id = Auth::id();

        $id = Quizlog::create([
            'user_id' => $user_id,
            'quiz_id' => $request->quiz_id,
        ])->id;

        $data = [
            'message' => 'New quizlog created!',
            'quizlog_id' => $id
        ];

        return response()->json($data);
    }

    // fetch set of questions based on quiz_id
    // public function fetchQuizlog(Request $request)
    // {
    //     $quizlog = Quizlog::where('id', $request->quizlog_id)->get();
    //     return response()->json($quizlog);
    // }

    public function fetchQuiz($id)
    {
        // $quiz = Quiz::find($id);
        $quiz = Quiz::with('questions')->where('id', $id)->first();

        return response()->json($quiz);
    }

    public function fetchQuizQuestionsWithChoices(Request $request)
    {
        $question_set = Question::with('choices')
        ->where('quiz_id', $request->quiz_id)
        ->get();

        return response()->json($question_set);
    }

    // saveAllAnswers
    public function saveAllAnswers(Request $request)
    {
        $user = Auth::user();
        $user_id = Auth::id();
        $quiz = Quiz::find($request->quiz_id);
        
        Activity::create([
            'activity' => $user->first_name . ' answered ' . $quiz->title,
            'activitiable_id' => $user_id,
            'activitiable_type' => 'App\Models\Answer'
        ]);

        $arr = $request->answers;

        foreach($arr as $item) {
            Answer::updateOrCreate(
                [
                    'question_id' => $item['question_id'],
                    'quizlog_id' => $item['quizlog_id']
                ],
                [
                    'choice_id' => $item['choice_id']
                ]
            );
        }

        return response()->json('Saved all answers!');
    }

    // fetch quiz results
    public function fetchQuizResults(Request $request)
    {
       

        $answers = Answer::where('quizlog_id', $request->quizlog_id)
        ->with('question')
        ->with('choice')
        ->get();
    

        $correctAnswerCount = Answer::where('quizlog_id', $request->quizlog_id)
            ->whereHas('choice', function ($query) {
                $query->where('is_correct', 1);
            })
            ->count();
            
        $data = [
            'answers' => $answers,
            'correct_answers' => $correctAnswerCount
        ];

        return response()->json($data);
    }
}
