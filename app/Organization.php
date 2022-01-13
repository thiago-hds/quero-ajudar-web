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

    public function scopeFilter($query, $filters)
    {
        $query->when(
            $filters['name'] ?? false, function ($query, $name) {
                $query->where('name', 'like', "%{$name}%");
            }
        );

        $query->when(
            $filters['email'] ?? false, function ($query, $email) {
                $query->where('email', 'like', "%{$email}%");
            }
        );

        // $query->when(
        //     $filters['name'] ?? false, function ($query, $name) {
        //         $query->where('name', 'like', "%{$name}%");
        //     }
        // );
    }

    /**
     * Get the users for the organization.
     */
    public function users()
    {
        return $this->hasMany('App\User');
    }

    /**
     * Get the address for the organization.
     */
    public function address()
    {
        return $this->morphOne('App\Address', 'addressable');
    }

    /**
     * Get the favorites for the organization.
     */
    public function favorites()
    {
        return $this->morphMany('App\Favorite', 'favoritable');
    }

    /**
     * Get the vacancies for the organization.
     */
    public function vacancies()
    {
        return $this->hasMany('App\Vacancy');
    }

    /**
     * Get the organization type
     */
    public function organizationType()
    {
        return $this->belongsTo('App\OrganizationType');
    }

    /**
     * Get the organization phones
     */
    public function phones()
    {
        return $this->morphMany('App\Phone', 'owner');
    }

    /**
     * Get the organization causes
     */
    public function causes()
    {
        return $this->morphToMany('App\Cause', 'causeable');
    }
}
