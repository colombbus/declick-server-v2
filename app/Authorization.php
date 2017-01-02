<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Authorization extends Model
{
    public $timestamps = false;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'token',
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
}
