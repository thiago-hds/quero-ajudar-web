<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class OrganizationType extends Model
{
    /**
     * Get the organizations with this organization_type.
     */
    public function organizations()
    {
        return $this->hasMany('App\Organization');
    }
}
