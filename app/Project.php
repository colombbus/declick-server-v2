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

    public function isDefault()
    {
        $defaultProject = $this->owner()->defaultProject()->first();
        if (!$defaultProject) {
            return false;
        }
        return $this->is($defaultProject);
    }

    public function mainProject()
    {
        return $this->belongsTo('App\ProjectResource', 'main_program_id');
    }

    public function attributesToArray()
    {
        return [
            "id" => $this->id,
            "name" => $this->name,
            "is_default" => $this->isDefault(),
            "is_exercise" => boolval($this->is_exercise),
            "is_public" => boolval($this->is_public),
            "scene_height" => ($this->scene_height === null)
                ? null
                : intval($this->scene_height),
            "scene_width" => ($this->scene_width === null)
                ? null
                : intval($this->scene_width),
            "entry_point_id" => intval($this->entry_point_id),
            "description" => $this->description,
            "instructions" => $this->instructions,
            "main_program_id" => intval($this->main_program_id),
        ];
    }
}
