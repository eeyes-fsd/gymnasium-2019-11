<?php

namespace App\Models;

/**
 * Class Meal
 * @package App\Models
 *
 * @property int $id
 * @property array $ingredients
 * @property int $fat
 * @property int $carbohydrate
 * @property int $protein
 * @property string $step
 * @property \Carbon\Carbon $created_at
 * @property \Carbon\Carbon $updated_at
 */
class Meal extends Model
{
    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasOne
     */
    public function breakfast()
    {
        return $this->hasOne('App\Models\Recipe', 'breakfast_id');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasOne
     */
    public function lunch()
    {
        return $this->hasOne('App\Models\Recipe', 'lubch_id');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasOne
     */
    public function dinner()
    {
        return $this->hasOne('App\Models\Recipe', 'dinner_id');
    }

    public function setIngredientsAttribute($ingredients)
    {
        $this->attributes = serialize($ingredients);
    }

    public function getIngredientsAttribute($ingredients)
    {
        $raw = unserialize($ingredients);

        $data = [];
        foreach ($raw as $item)
        {
            $ingredient = Ingredient::find($item['id']);
            $temp = [
                'name' => $ingredient->name,
                'amount' => $item['amount']
            ];
            $data[] = $temp;
        }

        return $data;
    }
}
