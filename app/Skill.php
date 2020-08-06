<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Skill extends Model
{

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'fontawesome_icon_unicode'
    ];
    
    public function vacancies()
    {
        return $this->morphedByMany('App\Vacancy', 'causeable');
    }

    public function volunteers()
    {
        return $this->morphedByMany('App\Volunteer', 'causeable');
    }
}
