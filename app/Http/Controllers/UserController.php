<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

use App\User;

class UserController extends Controller
{
    public function index()
    {
        return User::all();
    }

    public function create(Request $request)
    {
        $this->validate($request, [
            'username' => 'required|max:255|unique:users',
            'email' => 'max:255|email|unique:users',
            'password' => 'max:255|required',
        ]);

        $values = array_only($request->input(), ['username', 'email']);
        $values['password_hash'] = Hash::make($request->input(['password']));

        $user = User::create($values);

        return response($user, 201, [
            'Location' => route('users', ['id' => $user->id])
        ]);
    }

    public function show($id)
    {
        return User::findOrFail($id);
    }

    public function indexProjects($id)
    {
        $user = User::findOrFail($id);

        $this->authorize('indexProjects', $user);

        return $user->projects();
    }

    public function showDefaultProject($id)
    {
        $user = User::findOrFail($id);

        $this->authorize('showDefaultProject', $user);

        return $user->defaultProject()->first();
    }

    public function update(Request $request, $id)
    {
        $user = User::findOrFail($id);

        $this->authorize('update', $user);

        $this->validate($request, [
            'email' => 'max:255|email|unique:users',
            'password' => 'max:255',
        ]);

        $values = array_only($request->input(), ['email']);
        $user->fill($values);

        if ($request->input('password')) {
            $user->password_hash = Hash::make($request->input(['password']));
        }

        $user->save();

        return response($user, 200);
    }

    public function delete($id)
    {
        $user = User::findOrFail($id);

        $this->authorize('delete', $user);

        $user->delete();

        return response('', 204);
    }
}
