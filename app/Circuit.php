<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Circuit extends Model
{
    public $timestamps = false;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name',
        'short_description',
        'description'
    ];

    /**
     * The attributes excluded from the model's JSON form.
     *
     * @var array
     */
    protected $hidden = [];

    public function rootNode()
    {
        return $this->belongsTo('App\CircuitNode', 'root_node_id');
    }

    public function nodes()
    {
        return $this->hasMany('App\CircuitNode');
    }
}
