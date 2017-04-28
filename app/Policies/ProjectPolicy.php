<?php

namespace App\Policies;

use App\Project;
use App\User;

class ProjectPolicy
{
    public function update(User $user, Project $project)
    {
        return $user->is($project->owner()) || $user->isAdmin();
    }

    public function delete(User $user, Project $project)
    {
        return !$project->isDefault() &&
            ($user->is($project->owner()) || $user->isAdmin());
    }
}
