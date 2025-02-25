<?php

namespace App\Http\Controllers;

use App\Models\Question;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class QuizController extends Controller
{
    public function index()
    {
        $questions = Question::with('options')->get();
        $questions = $questions->map(function ($question) {
            return [
                'id' => $question->id,
                'question_text' => $question->question_text,
                'options' => $question->options->map(function ($option) {
                    return [
                        'id' => $option->id,
                        'option_text' => $option->option_text,
                    ];
                })
            ];
        });
        return response()->json($questions);
    }

    public function store(Request $request)
    {
        $user = Auth::user();
        $user->quizzes()->delete();

        foreach ($request->questions as $question) {
            $user->quizzes()->create([
                'question_id' => $question['id'],
                'option_id' => $question['selectedOption'],
            ]);
        }
        return response()->json(['message' => 'Quiz submitted successfully']);
    }

    public function show()
    {
        $quiz = Auth::user()->quizzes()->get();
        $questions = Question::with('options')->get();

        return response()->json([
            'questions' => $questions,
            'quiz' => $quiz
        ]);
    }
}
