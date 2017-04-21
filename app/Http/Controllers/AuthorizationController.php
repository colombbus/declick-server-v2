<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

use App\Authorization;
use App\User;

class AuthorizationController extends Controller
{
    public function index(Request $request)
    {
        $user = $request->user();

        if (!$user) {
            return [];
        }

        return $user->authorizations;
    }

    public function create(Request $request)
    {
        $errors = [];
        $failure = false;

        if ($request->input('username') === null) {
            $failure = true;
            $errors[] = 'MISSING_FIELD_USERNAME';
        }

        if ($request->input('password') === null) {
            $failure = true;
            $errors[] = 'MISSING_FIELD_PASSWORD';
        }

        if ($failure) {
            return response(['errors' => $errors], 400);
        }

        $filters = array_only($request->input(), ['username']);

        $owner = User::where($filters)->first();
        if ($owner === null) {
            $errors[] = 'NO_MATCH_FOUND';
            return response(['errors' => $errors], 401);
        }

        if (!Hash::check($request->input('password'), $owner->password_hash)) {
            $errors[] = 'NO_MATCH_FOUND';
            return response(['errors' => $errors], 401);
        }

        $values = ['token' => Str::random(32)];
        $authorization = $owner->authorizations()->create($values);

        return response($authorization, 201, [
            'Location' =>
                route('authorizations', ['id' => $authorization->id]),
        ]);
    }

    public function show($id)
    {
        $authorization = Authorization::findOrFail($id);

        $this->authorize('show', $authorization);

        return $authorization;
    }

    public function delete($id)
    {
        $authorization = Authorization::findOrFail($id);

        $this->authorize('delete', $authorization);

        $authorization->delete();

        return response('', 204);
    }

    public function deleteCurrent(Request $request)
    {
        $headers = getallheaders();
        list($type, $value) = explode(' ', $headers['Authorization'], 2);

        $authorization =
            Authorization::where(['token' => $value])->firstOrFail();

        $this->authorize('delete', $authorization);

        $authorization->delete();

        return response('', 204);
    }
}
