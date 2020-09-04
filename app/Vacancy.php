<?php

namespace App;

use App\Enums\LocationType;
use App\Enums\PeriodicityType;
use App\Enums\RecurrenceType;
use App\Enums\UnitPerPeriodType;
use Illuminate\Database\Eloquent\Model;
use Carbon\Carbon;

class Vacancy extends Model
{

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
        'name', 'description', 'type', 'tasks', 'start_time',
        'promotion_start_date', 'promotion_end_date', 'enrollment_limit',
        'image', 'status', 'periodicity', 'unit_per_period', 'amount_per_period',
        'location_type'
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

    public function favorites()
    {
        return $this->morphMany('App\Favorite', 'favoritable');
    }

    public function causes()
    {
        return $this->morphToMany('App\Cause', 'causeable');
    }

    public function skills()
    {
        return $this->morphToMany('App\Skill', 'skillable');
    }

    public function enrollments()
    {
        return $this->hasMany('App\Enrollment');
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
        $this->attributes['promotion_start_date'] = null;
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
        $this->attributes['promotion_end_date'] = null;
        if($value !== null){
            $this->attributes['promotion_end_date'] = Carbon::createFromFormat('d/m/Y', $value)->toDateString();
        }

    }

    public function setDateAttribute($value)
    {
        $this->attributes['date'] = null;
        if($value !== null){
            $this->attributes['date'] = Carbon::createFromFormat('d/m/Y', $value)->toDateTimeString();
        }
    }

    public function setTimeAttribute($value)
    {
        $this->attributes['time'] = null;
        if($value !== null){
            $this->attributes['time'] = Carbon::createFromFormat('H:i', $value)->toDateTimeString();
        }
    }

    public function getDateAttribute()
    {
        if($this->attributes['date'] !== null){
            return Carbon::parse($this->attributes['date'])->format('d/m/Y');
        }
        return null;
    }

    public function getTimeAttribute()
    {
        if($this->attributes['time'] !== null){
            return Carbon::parse($this->attributes['time'])->format('H:i');
        }
        return null;
    }

    public function getFormattedFrequency()
    {
        if($this->type == RecurrenceType::RECURRENT){
            if($this->amount_per_period == null){
                return "à combinar";
            }
            else{
                $amount = $this->amount_per_period;
                if($this->unit_per_period == UnitPerPeriodType::HOURS){
                    $unit = $amount == 1? "hora" : "horas";
                }
                else if($this->unit_per_period == UnitPerPeriodType::DAYS){
                    $unit = $amount == 1? "dia" : "dias";
                }

                if($this->periodicity == PeriodicityType::DAILY){
                    $period = "diárias";
                }
                else if($this->periodicity == PeriodicityType::WEEKLY){
                    $period = "semanais";
                }
                else if($this->periodicity == PeriodicityType::MONTHLY){
                    $period = "mensais";
                }

                return sprintf("%d %s %s", $amount, $unit, $period);
            }
        }
        else{
            return null;
        }
    }

    public function getFormattedDate(){
        if($this->type == RecurrenceType::UNIQUE_EVENT){
            if($this->date == null){
                return "à combinar";
            }
            else{
                return $this->date;
            }
        }
        return null;
    }

    public function getFormattedTime(){
        if($this->time == null){
            return "à combinar";
        }
        else{
            return $this->time;
        }
    }

    public function getFormattedLocation(){
        if($this->location_type == LocationType::REMOTE){
            return "remoto";
        }
        else if($this->location_type == LocationType::NEGOTIABLE){
            return "à combinar";
        }
        else if($this->location_type == LocationType::ORGANIZATION_ADDRESS ){
            if($organization = Organization::find($this->organization_id) &&
                isset($organization->address)){
                return $organization->address->getFormattedAddress();
            }
        }
        else if($this->address != null){
            return $this->address->getFormattedAddress();
        }
        return null;
    }

}
