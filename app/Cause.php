<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Cause extends Model
{
    public function organizations()
    {
        return $this->morphedByMany('App\Organization', 'causeable');
    }

    public function vacancies()
    {
        return $this->morphedByMany('App\Vacancy', 'causeable');
    }

    public function volunteers()
    {
        return $this->morphedByMany('App\Volunteer', 'causeable');
    }
}
