<?php

namespace App;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class OrganizationType extends Model
{
    use HasFactory;

    /**
     * Get the organizations with this organization_type.
     */
    public function organizations()
    {
        return $this->hasMany('App\Organization');
    }
}
