<?php

namespace App;

use Carbon\Carbon;
use Laravel\Airlock\HasApiTokens;
use Illuminate\Notifications\Notifiable;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Foundation\Auth\User as Authenticatable;

class User extends Authenticatable
{
    use HasApiTokens, Notifiable;

    public const ADMIN           = 'admin';
    public const ORGANIZATION    = 'organization';
    public const VOLUNTEER       = 'volunteer';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'first_name', 'last_name', 'email', 'password', 'profile', 'date_of_birth', 'status'
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
        'date_of_birth'     => 'date'
    ];

    public function isAdmin(){
        return $this->attributes['profile'] === self::ADMIN;
    }

    public function isVolunteer(){
        return $this->attributes['profile'] === self::VOLUNTEER;
    }

    public function volunteer()
    {
        return $this->hasOne('App\Volunteer', 'user_id');
    }

    /**
     * Get the organization of the user.
     */
    public function organization()
    {
        return $this->belongsTo('App\Organization');
    }

    public function phones()
    {
        return $this->morphMany('App\Phone', 'owner');
    }

    public function getDateOfBirthAttribute($value)
    {
        return Carbon::parse($value)->format('d/m/Y');
    }

    public function setDateOfBirthAttribute($value)
    {
        $this->attributes['date_of_birth'] = Carbon::createFromFormat('d/m/Y', $value)->toDateString();
    }


}
