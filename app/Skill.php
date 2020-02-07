<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Skill extends Model
{
    public function vacancies()
    {
        return $this->morphedByMany('App\Vacancy', 'causeable');
    }

    public function volunteers()
    {
        return $this->morphedByMany('App\Volunteer', 'causeable');
    }
}
