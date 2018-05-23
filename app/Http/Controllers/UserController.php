<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

use App\User;

class UserController extends Controller
{
    public function index(Request $request)
    {
        if ($request->query('search')) {
            $search = $request->query('search');
            return User::where('username', 'LIKE', "%$search%")->paginate(14);
        }
        return User::paginate(14);
    }

    public function testUsernameAvailable(Request $request)
    {
        if ($request->input('username') !== null) {
            $filters = ['username' => $request->input('username')];
            $user = User::where($filters)->first();
            return ['result' => $user === null];
        }
    }

    public function create(Request $request)
    {
        $this->validate($request, [
            'username' => 'required|min:5|max:255|unique:users|alpha_num',
            'email' => 'sometimes|max:255|email|unique:users',
            'password' => 'min:6|max:255|required|alpha_num',
        ]);

        $values = array_only($request->input(), ['username', 'email', 'current_project_id']);
        $values['password_hash'] = Hash::make($request->input(['password']));
        $user = User::create($values);

        $project = $user->projects()->create([]);
        $user->defaultProject()->associate($project);
        $user->save();

        ProjectController::importProject($user, 402);

        return response($user, 201, [
            'Location' => route('users', ['id' => $user->id])
        ]);
    }

    public function show($id)
    {
        return User::findOrFail($id);
    }

    public function showCurrentUser(Request $request)
    {
        return $request->user();
    }

    public function indexProjects($id)
    {
        $user = User::findOrFail($id);

        $this->authorize('indexProjects', $user);

        return $user->projects()->get();
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

        $values = array_only($request->input(), ['email', 'current_project_id']);
        $user->fill($values);

        if ($request->input('is_admin') !== null) {
            $this->authorize('changeRights', $user);
            $user->is_admin = $request->input('is_admin');
        }

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
