<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Cause extends Model
{
    public function organizations()
    {
        return $this->morphedByMany('App\Organization', 'causeable');
    }
}
