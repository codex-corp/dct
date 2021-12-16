<?php

namespace App\Http\Controllers;

use App\Http\Helpers\ApiUtils;
use App\Models\Question;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Validator;

class QuestionsController extends Controller
{
    use ApiUtils;

    public function createQuestion(Request $request): JsonResponse
    {

        $user = $request->user();
        if ($this->isAdmin($user) || $this->isCustomer($user)) {
            $validator = Validator::make($request->all(), $this->postValidationRules());

            if ($validator->passes()) {
                $question = new Question();
                $question->title = $request->input('title');
                $question->message = $request->input('message');
                $question->question_id = Str::random();
                $question->status = 'not_answered';
                $question->user_id = $user->id;
                $question->save();

                return $this->sendResponse($question, 'Question Created');
            }
            return $this->sendError('All fields are required.', $validator->errors(), 400);
        }
        return $this->sendError('Unauthorized Access', [], 401);
    }

    public function listQuestions(Request $request): JsonResponse
    {
        $user = $request->user();
        if ($this->isAdmin($user) || $this->isCustomer($user)) {
            $questions = Question::where('user_id', $user->id)->with('answers')->get();
            return $this->sendResponse($questions, 'List of questions');
        }
        return $this->sendError('Unauthorized Access', [], 401);
    }

    public function getQuestion(Request $request, $id): JsonResponse
    {
        $user = $request->user();
        if ($this->isAdmin($user) || $this->isCustomer($user)) {
            try{
                $questions = Question::where('id', $id)->where('user_id', $user->id)->with('answers')->firstOrFail();
            }catch(\Exception $e){
                return $this->sendError('No Results', [], 403);
            }
            return $this->sendResponse($questions, 'List of questions');
        }
        return $this->sendError('Unauthorized Access', [], 401);
    }
}
