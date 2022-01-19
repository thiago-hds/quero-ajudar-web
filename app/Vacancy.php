<?php

namespace App;

use App\Enums\LocationType;
use App\Enums\PeriodicityType;
use App\Enums\RecurrenceType;
use App\Enums\UnitPerPeriodType;
use Illuminate\Database\Eloquent\Model;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Builder;

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
        'promotion_start_date', 'promotion_end_date', 'application_limit',
        'image', 'status', 'periodicity', 'unit_per_period', 'amount_per_period',
        'location_type'
    ];

    public function scopeFilter($query, $filters)
    {
        $query->when($filters['name'] ?? false, function ($query, $name) {
            $query->where('name', 'like', "%{$name}%");
        });

        $query->when($filters['status'] ?? false, function ($query, $status) {
            $query->where('status', $status);
        });

        $query->when($filters['type'] ?? false, function ($query, $type) {
            $query->where('type', $type);
        });

        $query->when($filters['organization_id'] ?? false, function ($query, $organization_id) {
            $query->where('organization_id', $organization_id);
        });

        $query->when($filters['cause_id'] ?? false, function ($query, $causeId) {
            $query->whereHas('causes', function ($query) use ($causeId) {
                $query->where('id', $causeId);
            });
        });

        $query->when($filters['skill_id'] ?? false, function ($query, $skillId) {
            $query->whereHas('skills', function ($query) use ($skillId) {
                $query->where('id', $skillId);
            });
        });

        $query->when($filters['address_city'] ?? false, function ($query, $cityId) {
            $query->whereHas('address.city', function ($query) use ($cityId) {
                $query->where('id', $cityId);
            });
        });

        $query->when($filters['address_state'] ?? false, function ($query, $stateAbbr) {
            $query->whereHas('address.city.state', function ($query) use ($stateAbbr) {
                $query->where('abbr', $stateAbbr);
            });
        });
    }

    /**
     * Get the vacancy's organization.
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

    public function applications()
    {
        return $this->hasMany('App\Application');
    }

    public function getPromotionStartDateAttribute($value)
    {
        if ($value !== null) {
            return Carbon::parse($value)->format('d/m/Y');
        }
        return null;
    }

    public function setPromotionStartDateAttribute($value)
    {
        $this->attributes['promotion_start_date'] = null;
        if ($value !== null) {
            $this->attributes['promotion_start_date'] = Carbon::createFromFormat('d/m/Y', $value)->toDateString();
        }
    }

    public function getPromotionEndDateAttribute($value)
    {
        if ($value !== null) {
            return Carbon::parse($value)->format('d/m/Y');
        }
        return null;
    }

    public function setPromotionEndDateAttribute($value)
    {
        $this->attributes['promotion_end_date'] = null;
        if ($value !== null) {
            $this->attributes['promotion_end_date'] = Carbon::createFromFormat('d/m/Y', $value)->toDateString();
        }
    }

    public function setDateAttribute($value)
    {
        $this->attributes['date'] = null;
        if ($value !== null) {
            $this->attributes['date'] = Carbon::createFromFormat('d/m/Y', $value)->toDateTimeString();
        }
    }

    public function setTimeAttribute($value)
    {
        $this->attributes['time'] = null;
        if ($value !== null) {
            $this->attributes['time'] = Carbon::createFromFormat('H:i', $value)->toDateTimeString();
        }
    }

    public function getDateAttribute()
    {
        if ($this->attributes['date'] !== null) {
            return Carbon::parse($this->attributes['date'])->format('d/m/Y');
        }
        return null;
    }

    public function getTimeAttribute()
    {
        if ($this->attributes['time'] !== null) {
            return Carbon::parse($this->attributes['time'])->format('H:i');
        }
        return null;
    }

    public function getFormattedFrequency()
    {
        if ($this->type == RecurrenceType::RECURRENT) {
            if ($this->amount_per_period == null) {
                return "Vaga recorrente";
            } else {
                $amount = $this->amount_per_period;
                if ($this->unit_per_period == UnitPerPeriodType::HOURS) {
                    $unit = $amount == 1 ? "hora" : "horas";
                } elseif ($this->unit_per_period == UnitPerPeriodType::DAYS) {
                    $unit = $amount == 1 ? "dia" : "dias";
                }

                if ($this->periodicity == PeriodicityType::DAILY) {
                    $period = "diárias";
                } elseif ($this->periodicity == PeriodicityType::WEEKLY) {
                    $period = "semanais";
                } elseif ($this->periodicity == PeriodicityType::MONTHLY) {
                    $period = "mensais";
                }

                return sprintf("%d %s %s", $amount, $unit, $period);
            }
        } elseif ($this->type == RecurrenceType::UNIQUE_EVENT) {
            if ($this->date) {
                return sprintf("%s %s", $this->date, $this-> time);
            } else {
                return "À combinar";
            }
        } else {
            return null;
        }
    }

    public function getFormattedDate()
    {
        if ($this->type == RecurrenceType::UNIQUE_EVENT) {
            if ($this->date == null) {
                return "À combinar";
            } else {
                return $this->date;
            }
        } else {
            return "Vaga recorrente";
        }
    }

    public function getFormattedTime()
    {
        if ($this->time == null) {
            return "À combinar";
        } else {
            return $this->time;
        }
    }

    public function getFormattedLocation($complete = true)
    {
        if ($this->location_type == LocationType::REMOTE) {
            return "Remoto";
        } elseif ($this->location_type == LocationType::NEGOTIABLE) {
            return "À combinar";
        } elseif ($this->location_type == LocationType::ORGANIZATION_ADDRESS) {
            if (
                ($organization = Organization::find($this->organization_id)) &&
                isset($organization->address)
            ) {
                if ($complete) {
                    return $organization->address->getFormattedAddress();
                } else {
                    return $organization->address->getLocation();
                }
            }
        } elseif ($this->address != null) {
            if ($complete) {
                return $this->address->getFormattedAddress();
            } else {
                return $this->address->getLocation();
            }
        }
        return null;
    }
}
