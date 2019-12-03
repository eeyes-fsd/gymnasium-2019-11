<?php
/**
 * Created by PhpStorm.
 * User: Bright
 * Date: 2019/11/19
 * Time: 20:12
 */

namespace App\Models;
use Illuminate\Database\Eloquent\Model;

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
}