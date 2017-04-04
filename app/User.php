<?php

namespace App;

use Laravel\Lumen\Auth\Authorizable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Contracts\Auth\Access\Authorizable as AuthorizableContract;

class User extends Model implements AuthorizableContract
{
    use Authorizable;

    public $timestamps = false;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'username', 'email', 'password_hash'
    ];

    /**
     * The attributes excluded from the model's JSON form.
     *
     * @var array
     */
    protected $hidden = [
        'password_hash',
    ];

    public function isAdmin()
    {
        return $this->is_admin;
    }

    public function authorizations()
    {
        return $this->hasMany('App\Authorization', 'owner_id');
    }

    public function projects()
    {
        return $this->hasMany('App\Project', 'owner_id');
    }

    public function defaultProject()
    {
        return $this->belongsTo('App\Project', 'default_project_id');
    }

    public function results()
    {
        return $this->hasMany('App\UserResult', 'user_id');
    }
}
