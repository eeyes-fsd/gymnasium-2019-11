<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Meal extends Model
{
    public function breakfast()
    {
        return $this->belongsTo('App\Models\Recipe', 'breakfast_id');
    }

    public function lunch()
    {
        return $this->belongsTo('App\Models\Recipe', 'lubch_id');
    }

    public function dinner()
    {
        return $this->belongsTo('App\Models\Recipe', 'dinner_id');
    }

    public function setIngredientsAttribute($value)
    {
        $this->attributes = serialize($value);
    }

    public function getIngredientsAttribute($ingredients)
    {
        return unserialize($ingredients);
    }
}
