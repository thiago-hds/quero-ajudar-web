<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Favorite extends Model
{

    /**
     * Get the owning favoritable model.
     */
    public function favoritable()
    {
        return $this->morphTo();
    }
}
