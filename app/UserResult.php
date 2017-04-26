<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class UserResult extends Model
{
    public $timestamps = false;

    protected $fillable = [
        'user_id', 'step_id', 'passed', 'solution'
    ];

    public function user()
    {
        return $this->belongsTo('App\User', 'user_id');
    }

    public function step()
    {
        return $this->belongsTo('App\CircuitNode', 'step_id');
    }

    public function attributesToArray()
    {
        return [
            "id" => $this->id,
            "user_id" => intval($this->user_id),
            "step_id" => intval($this->step_id),
            "passed" => boolval($this->passed),
            "solution" => $this->solution
        ];
    }
}
