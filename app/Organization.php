<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Organization extends Model
{

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'website', 'description', 'logo', 'email', 'status'
    ];


    /**
     * Get the users for the organization.
     */
    public function users()
    {
        return $this->hasMany('App\User');
    }

    /**
     * Get the .
     */
    public function organizationType()
    {
        return $this->belongsTo('App\OrganizationType');
    }
    
    public function phones()
    {
        return $this->belongsToMany('App\Phone');
    }

    public function causes()
    {
        return $this->belongsToMany('App\Cause');
    }
}
