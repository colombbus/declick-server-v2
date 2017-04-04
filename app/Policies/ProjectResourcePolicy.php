<?php

namespace App\Policies;

use App\Project;
use App\ProjectResource;
use App\User;

class ProjectResourcePolicy
{
    public function create(User $user, Project $project)
    {
        return $user->is($project->owner()) || $user->isAdmin();
    }

    public function update(User $user, ProjectResource $resource)
    {
        return $user->is($resource->project()->owner()) || $user->isAdmin();
    }

    public function updateContent(User $user, ProjectResource $resource)
    {
        return $user->is($resource->project()->owner()) || $user->isAdmin();
    }

    public function delete(User $user, ProjectResource $resource)
    {
        return $user->is($resource->project()->owner()) || $user->isAdmin();
    }
}
