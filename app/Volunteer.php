<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Volunteer extends Model
{

    /**
     * The primary key associated with the table.
     *
     * @var string
     */
    protected $primaryKey = 'user_id';

    public function user()
    {
        return $this->belongsTo('App\User');
    }

    public function causes()
    {
        return $this->morphToMany('App\Cause', 'causeable', null, null, null, 'user_id');
    }

    public function skills()
    {
        return $this->morphToMany('App\Skill', 'skillable', null, null, null, 'user_id');
    }
    
}
