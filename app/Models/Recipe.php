<?php

namespace App\Models;

/**
 * Class Recipe
 * @package App\Models
 *
 * @property int $id
 * @property string $name
 * @property string $cover
 * @property int $price
 * @property string | null $description
 * @property array $breakfast
 * @property array $lunch
 * @property array $dinner
 * @property \Illuminate\Database\Eloquent\Collection $users
 * @property \Carbon\Carbon $created_at
 * @property \Carbon\Carbon $updated_at
 */
class Recipe extends Model
{
    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function users()
    {
        return $this->belongsToMany('App\Models\User')->withTimestamps()->withPivot(['id']);
    }

    /**
     * @param $breakfast
     * @return mixed
     */
    public function getBreakfastAttribute($breakfast)
    {
        return unserialize($breakfast);
    }

    /**
     * @param $breakfast
     */
    public function setBreakfastAttribute($breakfast)
    {
        $this->attributes['breakfast'] = serialize($breakfast);
    }

    /**
     * @param $lunch
     * @return mixed
     */
    public function getLunchAttribute($lunch)
    {
        return unserialize($lunch);
    }

    /**
     * @param $lunch
     */
    public function setLunchAttribute($lunch)
    {
        $this->attributes['lunch'] = serialize($lunch);
    }

    /**
     * @param $dinner
     * @return mixed
     */
    public function getDinnerAttribute($dinner)
    {
        return unserialize($dinner);
    }

    /**
     * @param $dinner
     */
    public function setDinnerAttribute($dinner)
    {
        $this->attributes['breakfast'] = serialize($dinner);
    }
}
