<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Carbon\Carbon;

class Vacancy extends Model
{

    public const RECURRENT           = 'recurrent';
    public const UNIQUE_EVENT        = 'unique_event';

    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'vacancies';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'description', 'type', 'tasks', 'time',
        'promotion_start_date', 'promotion_end_date', 'enrollment_limit',
        'image', 'status'
    ];

    /**
     * Get the organization of the user.
     */
    public function organization()
    {
        return $this->belongsTo('App\Organization');
    }

    public function address()
    {
        return $this->morphOne('App\Address', 'addressable');
    }

    public function causes()
    {
        return $this->morphToMany('App\Cause', 'causeable');
    }

    public function skills()
    {
        return $this->morphToMany('App\Skill', 'skillable');
    }

    public function getPromotionStartDateAttribute($value)
    {
        if($value !== null){
            return Carbon::parse($value)->format('d/m/Y');
        }
        return null;
    }

    public function setPromotionStartDateAttribute($value)
    {
        if($value !== null){
            $this->attributes['promotion_start_date'] = Carbon::createFromFormat('d/m/Y', $value)->toDateString();
        }
    }

    public function getPromotionEndDateAttribute($value)
    {
        if($value !== null){
            return Carbon::parse($value)->format('d/m/Y');
        }
        return null;
    }

    public function setPromotionEndDateAttribute($value)
    {
        if($value !== null){
            $this->attributes['promotion_end_date'] = Carbon::createFromFormat('d/m/Y', $value)->toDateString();
        }
    }

    public function setTimeAttribute($value)
    {
        if($value !== null){
            $this->attributes['time'] = Carbon::createFromFormat('d/m/Y H:i', $value)->toDateTimeString();
        }
    }

    public function getDateAttribute()
    {
        if($this->attributes['time'] !== null){
            return Carbon::parse($this->attributes['time'])->format('d/m/Y');
        }
        return null;
    }

    public function getHourAttribute()
    {
        if($this->attributes['time'] !== null){
            return Carbon::parse($this->attributes['time'])->format('H:i');
        }
        return null;
    }



}
