<?php

namespace App\Policies;

use App\User;

class UserPolicy
{
    public function indexProjects(User $user, User $target)
    {
        return $user->is($target) || $user->isAdmin();
    }

    public function showDefaultProject(User $user, User $target)
    {
        return $user->is($target) || $user->isAdmin();
    }

    public function update(User $user, User $target)
    {
        return $user->is($target) || $user->isAdmin();
    }

    public function changeRights(User $user)
    {
        return $user->isAdmin();
    }

    public function delete(User $user, User $target)
    {
        return $user->is($target) || $user->isAdmin();
    }
}
