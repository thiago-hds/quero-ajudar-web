<?php

namespace App;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Volunteer extends Model
{
    use HasFactory;

    /**
     * The primary key associated with the table.
     *
     * @var string
     */
    protected $primaryKey = 'user_id';

    /**
     * Get the route key for the model.
     *
     * @return string
     */
    public function getRouteKeyName()
    {
        return 'user_id';
    }

    /**
     * Scope a query to filter users.
     *
     * @param  \Illuminate\Database\Eloquent\Builder  $query
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function scopeFilter($query, $filters)
    {
        $query->when($filters['name'] ?? false, function ($query, $name) {
            $query->whereHas('user', function ($query) use ($name) {
                return $query->whereRaw("CONCAT(first_name, ' ', last_name) like '%{$name}%'");
            });
        });

        $query->when($filters['email'] ?? false, function ($query, $email) {
            $query->whereHas('user', function ($query) use ($email) {
                $query->where('email', 'like', "%{$email}%");
            });
        });

        $query->when($filters['organization_id'] ?? false, function ($query, $organization_id) {
            $query->where('organization_id', $organization_id);
        });

        // can't use conditional clause here because it doesn't run when status = 0
        if (isset($filters['status'])) {
            $query->whereHas('user', function ($query) use ($filters) {
                $query->where('status', $filters['status']);
            });
        }

        $query->when($filters['cause_id'] ?? false, function ($query, $cause_id) {
            $query->whereHas('causes', function ($query) use ($cause_id) {
                $query->where('id', '=', $cause_id);
            });
        });

        $query->when($filters['skill_id'] ?? false, function ($query, $skill_id) {
            $query->whereHas('causes', function ($query) use ($skill_id) {
                $query->where('id', '=', $skill_id);
            });
        });
    }

    public function user()
    {
        return $this->belongsTo('App\User');
    }

    public function causes()
    {
        return $this->morphToMany('App\Cause', 'causeable', null, null, null, 'user_id');
    }

    public function skills()
    {
        return $this->morphToMany('App\Skill', 'skillable', null, null, null, 'user_id');
    }

    public function applications()
    {
        return $this->hasMany('App\Application');
    }

    public function favorites()
    {
        return $this->hasMany('App\Favorite');
    }



    // public function getVacancyRecommendations()
    // {
    //     $process = new Process(
    //         ["./virtualenv/bin/python", "recommender.py", "recommend", $this->user_id]
    //     );
    //     $process->setWorkingDirectory(base_path() . "/recommender");
    //     $process->run();

    //     // executes after the command finishes
    //     if (!$process->isSuccessful()) {
    //         throw new ProcessFailedException($process);
    //     }

    //     $recommendations =  $process->getOutput();
    //     return $recommendations;
    // }


    // public function updateRecommendations()
    // {
    //     $process = new Process(
    //         ["./virtualenv/bin/python", "recommender.py", "recommend", $this->user_id, '&']
    //     );
    //     $process->setWorkingDirectory(base_path() . "/recommender");
    //     $process->run();

    //     // executes after the command finishes
    //     if (!$process->isSuccessful()) {
    //         throw new ProcessFailedException($process);
    //     }


    //     return true;
    // }
}
