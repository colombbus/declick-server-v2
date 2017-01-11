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
        return $this->hasOne('App\Project', 'id', 'default_project_id');
    }
}
