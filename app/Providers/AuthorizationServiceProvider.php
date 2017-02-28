<?php

namespace App\Providers;

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\ServiceProvider;

use App\Authorization;
use App\Policies\AuthorizationPolicy;
use App\Policies\ProjectPolicy;
use App\Policies\ProjectResourcePolicy;
use App\Policies\UserPolicy;
use App\Project;
use App\ProjectResource;
use App\User;

class AuthorizationServiceProvider extends ServiceProvider
{
    /**
     * Boot the authorization services for the application.
     *
     * @return void
     */
    public function boot()
    {
        Gate::policy(Authorization::class, AuthorizationPolicy::class);
        Gate::policy(Project::class, ProjectPolicy::class);
        Gate::policy(ProjectResource::class, ProjectResourcePolicy::class);
        Gate::policy(User::class, UserPolicy::class);

        Auth::viaRequest('api', function ($request) {
            $headers = getallheaders();

            if (isset($headers['Authorization'])) {

                list($type, $value) =
                    explode(' ', $headers['Authorization'], 2);

                if ($type === 'Token') {
                    $authorization = Authorization
                        ::where(['token' => $value])
                        ->first();

                    if ($authorization) {
                        return $authorization->owner();
                    }
                }
            }
        });
    }
}
