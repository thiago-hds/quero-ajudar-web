<?php

namespace App;

use App\Enums\ProfileType;
use Carbon\Carbon;
use Laravel\Sanctum\HasApiTokens;
use Illuminate\Notifications\Notifiable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;

class User extends Authenticatable
{
    use HasApiTokens;
    use Notifiable;
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'first_name', 'last_name', 'status', 'email',
        'password', 'profile', 'date_of_birth', 'organization_id'
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

    /**
     * Scope a query to filter users.
     *
     * @param  \Illuminate\Database\Eloquent\Builder $query
     * @param  array                                 $filters
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function scopeFilter($query, $filters)
    {

        $query->when(
            $filters['name'] ?? false, function ($query, $name) {
                $query->whereRaw("CONCAT(first_name, ' ', last_name) LIKE '%{$name}%'");
            }
        );

        $query->when(
            $filters['email'] ?? false, function ($query, $email) {
                $query->where('email', 'like', "%{$email}%");
            }
        );

        $query->when(
            $filters['profile'] ?? false, function ($query, $profile) {
                $query->where('profile', $profile);
            }
        );

        $query->when(
            $filters['organization_id'] ?? false, function ($query, $organization_id) {
                $query->where('organization_id', $organization_id);
            }
        );

        // can't use conditional clause here because it doesn't run when status = 0
        if (isset($filters['status'])) {
            $query->where('status', $filters['status']);
        }
    }

    /**
     * Checks if user is admin
     *
     * @return boolean
     */
    public function isAdmin(): bool
    {
        return $this->attributes['profile'] === ProfileType::ADMIN;
    }

    /**
     * Checks if user is volunteer
     *
     * @return boolean
     */
    public function isVolunteer()
    {
        return $this->attributes['profile'] === ProfileType::VOLUNTEER;
    }

    /**
     * Checks if user is organization
     *
     * @return boolean
     */
    public function isOrganization()
    {
        return $this->attributes['profile'] === ProfileType::ORGANIZATION;
    }

    /**
     * Get the volunteer model related with this user
     */
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

    /**
     * Get the user's complete name
     */
    public function getCompleteNameAttribute($value)
    {
        return sprintf("%s %s", $this->first_name, $this->last_name);
    }

    /**
     * Get the user's date of birth formatted
     */
    public function getDateOfBirthAttribute($value)
    {
        return Carbon::parse($value)->format('d/m/Y');
    }

    /**
     * Set the user's date of birth
     */
    public function setDateOfBirthAttribute($value)
    {
        $this->attributes['date_of_birth'] = Carbon::createFromFormat('d/m/Y', $value)->toDateString();
    }
}
