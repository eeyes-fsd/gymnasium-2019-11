<?php
/**
 * Created by PhpStorm.
 * User: Bright
 * Date: 2019/11/19
 * Time: 20:12
 */

namespace App\Models;


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
}