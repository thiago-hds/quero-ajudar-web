<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Enrollment extends Model
{
    public function volunteer()
    {
        return $this->belongsTo('App\Volunteer');
    }

    public function vacancy()
    {
        return $this->belongsTo('App\Vacancy');
    }

    public function phone()
    {
        return $this->morphOne('App\Phone', 'owner');
    }
}
