<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Symfony\Component\Process\Exception\ProcessFailedException;
use Symfony\Component\Process\Process;

class Volunteer extends Model
{

    /**
     * The primary key associated with the table.
     *
     * @var string
     */
    protected $primaryKey = 'user_id';

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

    public function getVacancyRecommendations(){
        $process = new Process(
            ["python3.8", "recommender.py", "recommend", $this->user_id]
        );
        $process->setWorkingDirectory(base_path() . "/recommender");
        $process->run();

        // executes after the command finishes
        if (!$process->isSuccessful()) {
            throw new ProcessFailedException($process);
        }

        $recommendations =  $process->getOutput();
        return $recommendations;
    }
    
}
