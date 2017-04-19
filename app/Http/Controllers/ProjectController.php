<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Project;

class ProjectController extends Controller
{
    public function index()
    {
        return Project::all();
    }

    public function create(Request $request)
    {
        $this->validate($request, [
            'name' => 'required|max:255',
        ]);

        $owner = $request->user();

        $values = array_only($request->input(), [
            'name',
            'is_exercise',
            'is_public',
            'scene_height',
            'scene_width',
            'entry_point_id',
            'description',
            'instructions'
        ]);

        $project = $owner->projects()->create($values);

        return response($project, 201, [
            'Location' => route('projects', ['id' => $project->id]),
        ]);
    }

    public function update(Request $request, $id)
    {
        $project = Project::findOrFail($id);

        $this->authorize('update', $project);

        $this->validate($request, [
            'name' => 'max:255',
        ]);

        $values = array_only($request->input(), [
            'name',
            'scene_height',
            'scene_width',
            'entry_point_id',
            'description',
            'instructions'
        ]);

        $project->update($values);

        return $project;
    }

    public function show($id)
    {
        return Project::findOrFail($id);
    }

    public function delete($id)
    {
        $project = Project::findOrFail($id);

        $this->authorize('delete', $project);

        $project->delete();

        return response('', 204);
    }

    public function show_exercices () {
      return Project::where('is_exercices',1)->get();
    }
}
