<?php

namespace App;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Organization extends Model
{
    use HasFactory;

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

    public function address()
    {
        return $this->morphOne('App\Address', 'addressable');
    }

    public function favorites()
    {
        return $this->morphMany('App\Favorite', 'favoritable');
    }

    /**
     * Get the users for the organization.
     */
    public function vacancies()
    {
        return $this->hasMany('App\Vacancy');
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
        return $this->morphMany('App\Phone', 'owner');
    }

    public function causes()
    {
        return $this->morphToMany('App\Cause', 'causeable');
    }
}
