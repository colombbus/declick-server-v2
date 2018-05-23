<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Project;
use App\ProjectResource;

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
            'is_exercise',
            'is_public',
            'scene_height',
            'scene_width',
            'entry_point_id',
            'description',
            'instructions'
        ]);

        $project->update($values);

        $mainProjectId = $request->input('main_program_id');

        if ($mainProjectId) {
            $resource = ProjectResource::find($mainProjectId);
            if ($resource) {
                $project->mainProject()->associate($resource);
                $project->save();
            }
        }

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

    public function import(Request $request, $id)
    {
        ProjectController::importProject($request->user(), $id);

        return response('', 204);
    }

    public static function importProject ($user, $projectId) {
        $sourceProject = Project::findOrFail($projectId);

        $destinationProject = null;

        $currentProject = $user->currentProject()->first();

        if (!$currentProject) {
            $destinationProject = $user->defaultProject()->first();
        } else {
            $destinationProject = $currentProject;
        }

        // $this->authorize('create', [ProjectResource::class, $destinationProject]);

        $resources = $sourceProject->resources()->get();

        $sourceDirectory = storage_path('app/projects/' . $sourceProject->id . '/resources/');

        $destinationDirectory = storage_path('app/projects/' . $destinationProject->id . '/resources/');

        if (!file_exists($destinationDirectory)) {
            mkdir($destinationDirectory, 0755, true);
        }

        foreach ($resources as $resource) {
            // check that resource does not already exist in destination project
            if ($destinationProject->resources()->where("file_name", $resource->file_name)->count() == 0) {
                // copy resource
                $newResource = $resource->replicate();
                $destinationProject->resources()->save($newResource);
                $sourceFile = $sourceDirectory.$resource->id;
                if (file_exists($sourceFile)) {
                    $destinationFile = $destinationDirectory.$newResource->id;
                    \Illuminate\Support\Facades\File::copy($sourceFile, $destinationFile);
                }
            }
        }
    }

    public function show_exercices () {
        return Project::where('is_exercices',1)->get();
    }
}
