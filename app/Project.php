<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Project extends Model
{
    public $timestamps = false;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name',
        'is_exercise',
        'is_public',
        'scene_height',
        'scene_width',
        'entry_point_id',
        'description',
        'instructions'
    ];

    /**
     * The attributes excluded from the model's JSON form.
     *
     * @var array
     */
    protected $hidden = [];

    public function owner()
    {
        return $this->belongsTo('App\User', 'owner_id')->first();
    }

    public function resources()
    {
        return $this->hasMany('App\ProjectResource');
    }
}
