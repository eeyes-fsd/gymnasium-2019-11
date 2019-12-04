<?php

namespace App\Models;

/**
 * Class Recipe
 * @package App\Models
 *
 * @property int $id
 * @property string $name
 * @property string $cover
 * @property string | null $description
 * @property int $breakfast_id
 * @property int $lunch_id
 * @property int $dinner_id
 * @property Meal $breakfast
 * @property Meal $lunch
 * @property Meal $dinner
 * @property \Illuminate\Database\Eloquent\Collection $users
 * @property \Carbon\Carbon $created_at
 * @property \Carbon\Carbon $updated_at
 */
class Recipe extends Model
{
    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function breakfast()
    {
        return $this->belongsTo('App\Models\Meal','breakfast_id');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function lunch()
    {
        return $this->belongsTo('App\Models\Meal','lunch_id');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function dinner()
    {
        return $this->belongsTo('App\Models\Meal','dinner_id');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function users()
    {
        return $this->belongsToMany('App\Models\User')->withTimestamps();
    }
}
