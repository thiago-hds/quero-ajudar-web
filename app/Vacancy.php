<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Vacancy extends Model
{
    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'vacancies';

    public function causes()
    {
        return $this->morphToMany('App\Cause', 'causeable');
    }

    public function skills()
    {
        return $this->morphToMany('App\Skill', 'skillable');
    }

}
