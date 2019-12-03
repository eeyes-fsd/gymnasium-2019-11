<?php

namespace App\Models;

/**
 * Class Recipe
 * @package App\Models
 */
class Recipe extends Model
{
    public function setRecipeAttribute($value)
    {
        $this->attributes= serialize($value);
    }
    public function getRecipeAttribute()
    {
        return unserialize();
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function users()
    {
        return $this->belongsToMany('App\Models\User')->withTimestamps();
    }
}
