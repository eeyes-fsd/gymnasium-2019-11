<?php

namespace App\Transformers;

use App\Models\Recipe;
use League\Fractal\TransformerAbstract;

class DietTransformer extends TransformerAbstract
{
    /** @var string 转换类型 */
    protected $type;

    public function __construct(string $type)
    {
        $this->type = $type;
    }

    public function transform(Recipe $recipe)
    {
        switch ($this->type) {
            case 'item':
                return [
                    'id' => $recipe->id,
                    'name' => $recipe->name,
                    'cover' => url(str_replace('public', 'storage', $recipe->cover)),
                    'low_price' => $recipe->ingredients_price,
                    'up_price' => $recipe->diet_price,
                    'price' => $recipe->price,
                    'weight' => $recipe->weight,
                    'description' => $recipe->description,
                ];
                break;

            case 'collection':
                return [
                    'id' => $recipe->id,
                    'name' => $recipe->name,
                    'cover' => url(str_replace('public', 'storage', $recipe->cover)),
                    'low_price' => $recipe->ingredients_price,
                    'up_price' => $recipe->diet_price,
                    'price' => $recipe->price,
                    'description' => $recipe->description,
                ];
                break;
        }
    }
}
