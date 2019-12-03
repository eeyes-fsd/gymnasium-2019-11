<?php

namespace App\Models;


/**
 * Class Recipe
 * @package App\Models
 */

class Recipe extends Model
{
    public function breakfast($value)
    {
        return $this->hasOne('App\Models\Meal','breakfast_id');
    }
    public function lunch($value)
    {
        return $this->hasOne('App\Models\Meal','lunch_id');
    }
    public function dinner($value)
    {
        return $this->hasOne('App\Models\Meal','dinner_id');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function users()
    {
        return $this->belongsToMany('App\Models\User')->withTimestamps();
    }
}
