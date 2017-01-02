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
        $this->validate($request, [
            'username' => 'required|exists:users',
            'password' => 'required',
        ]);

        $filters = array_only($request->input(), ['username']);

        $owner = User::where($filters)->firstOrfail();

        if (!Hash::check($request->input('password'), $owner->password_hash)) {
            abort(401);
        }

        $values = [
            'token' => Str::random(32),
        ];

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
}
