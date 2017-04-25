<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class CircuitNode extends Model
{
    public $timestamps = false;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name',
        'link',
        'parent_id',
        'position'
    ];

    /**
     * The attributes excluded from the model's JSON form.
     *
     * @var array
     */
    protected $hidden = [];

    public function children()
    {
        return $this->hasMany('App\CircuitNode', 'parent_id');
    }

    public function attributesToArray()
    {
        return [
            "id" => $this->id,
            "name" => $this->name,
            "link" => $this->link,
            "parent_id" => ($this->parent_id === null)
                ? null
                : intval($this->parent_id),
            "position" => intval($this->position)
        ];
    }
}
