<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Address extends Model
{

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'zipcode', 'street', 'number', 'neighborhood', 'city_id'
    ];

    public function city()
    {
        return $this->belongsTo('App\City');
    }

    public function addressable()
    {
        return $this->morphTo();
    }

    public function getLocation()
    {
        return sprintf("%s - %s", $this->city->name, $this->city->state->abbr);
    }
}
