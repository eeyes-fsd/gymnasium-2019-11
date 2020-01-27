<?php

namespace App\Models;

class Diet extends Model
{
    /**
     * @param $meal
     */
    public function setBreakfastAttribute($meal)
    {
        $this->attributes['breakfast'] = serialize($meal);
    }

    /**
     * @param $meal
     * @return mixed
     */
    public function getBreakfastAttribute($meal)
    {
        return unserialize($meal);
    }

    /**
     * @param $meal
     */
    public function setLunchAttribute($meal)
    {
        $this->attributes['lunch'] = serialize($meal);
    }

    /**
     * @param $meal
     * @return mixed
     */
    public function getLunchAttribute($meal)
    {
        return unserialize($meal);
    }

    /**
     * @param $meal
     */
    public function setDinnerAttribute($meal)
    {
        $this->attributes['dinner'] = serialize($meal);
    }

    /**
     * @param $meal
     * @return mixed
     */
    public function getDinnerAttribute($meal)
    {
        return unserialize($meal);
    }
}
