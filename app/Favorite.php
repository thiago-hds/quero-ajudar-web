<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Favorite extends Model
{

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'volunteer_id',
    ];

    /**
     * Get the owning favoritable model.
     */
    public function favoritable()
    {
        return $this->morphTo();
    }

    /**
     * Get the volunteer that owns the favorite.
     */
    public function volunteer()
    {
        return $this->belongsTo('App\Volunteer');
    }
}
