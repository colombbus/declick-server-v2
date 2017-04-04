<?php

namespace App\Policies;

use App\Authorization;
use App\User;

class AuthorizationPolicy
{
    public function show(User $user, Authorization $authorization)
    {
        return $user->is($authorization->owner()) || $user->isAdmin();
    }

    public function delete(User $user, Authorization $authorization)
    {
        return $user->is($authorization->owner()) || $user->isAdmin();
    }
}
