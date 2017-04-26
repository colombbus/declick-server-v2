<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\User;
use App\UserResult;

class UserResultController extends Controller
{
    public function index($userId)
    {
        $user = User::findOrFail($userId);

        return response()->json($user->results)->setEncodingOptions(JSON_NUMERIC_CHECK);
    }

    public function create(Request $request, $userId)
    {
        $user = User::findOrFail($userId);

        $previousResult = UserResult::where([
            'step_id' => $request->input('step_id'),
            'user_id' => $userId
        ])->first();

        /*
        if ($previousResult) {
            $previousResult->delete();
        }
        */

        $values = array_only($request->input(), [
            'step_id',
            'passed',
            'solution'
        ]);

        $result = $user->results()->create($values);

        return response($result, 201);
    }

    public function delete($userId)
    {
        $user = User::findOrFail($userId);

        $user->results()->delete();

        return response('', 204);
    }
}
