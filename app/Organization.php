<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Organization extends Model
{

    /**
     * Get the users for the organization.
     */
    public function users()
    {
        return $this->hasMany('App\User');
    }
    
}
