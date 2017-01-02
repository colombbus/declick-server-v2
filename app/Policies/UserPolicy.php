<?php

namespace App\Policies;

use App\User;

class UserPolicy
{
    public function indexProjects(User $user, User $target)
    {
        return $user->is($target);
    }

    public function showDefaultProject(User $user, User $target)
    {
        return $user->is($target);
    }

    public function update(User $user, User $target)
    {
        return $user->is($target);
    }

    public function delete(User $user, User $target)
    {
        return $user->is($target);
    }
}
