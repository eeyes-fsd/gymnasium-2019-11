<?php

namespace App\Transformers;

use App\Models\Recipe;
use League\Fractal\TransformerAbstract;

class RecipeTransformer extends TransformerAbstract
{
    private $type;

    public function __construct($type)
    {
        $this->type = $type;
    }

    public function transform(Recipe $recipe)
    {
        switch ($this->type){
            case 'collection':
                return [
                    'id' => $recipe->id,
                    'name' => $recipe->name,
                    'cover' => $recipe->cover,
                    'description' => $recipe->description,
                ];

            case 'item':
                return [
                    'id' => $recipe->id,
                    'name' => $recipe->name,
                    'cover' => $recipe->cover,
                    'breakfast' => [
                        'ingredients' => $recipe->breakfast->ingredients,
                        'nutrient' =>[
                            'fat' => $recipe->breakfast->fat,
                            'protein' => $recipe->breakfast->protein,
                            'carbohydrate' => $recipe->breakfast->carbohydrate,
                        ],
                        'step' => $recipe->breakfast->step,
                    ],
                    'lunch' => [
                        'ingredients' => $recipe->lunch->ingredients,
                        'nutrient' =>[
                            'fat' => $recipe->breakfast->fat,
                            'protein' => $recipe->breakfast->protein,
                            'carbohydrate' => $recipe->breakfast->carbohydrate,
                        ],
                        'step' => $recipe->lunch->step,
                    ],
                    'dinner' => [
                        'ingredients' => $recipe->dinner->ingredients,
                        'nutrient' =>[
                            'fat' => $recipe->breakfast->fat,
                            'protein' => $recipe->breakfast->protein,
                            'carbohydrate' => $recipe->breakfast->carbohydrate,
                        ],
                        'step' => $recipe->dinner->step,
                    ],
                ];

            default:
                return [
                    'id' => $recipe->id,
                    'name' => $recipe->name,
                    'cover' => $recipe->cover,
                ];
        }
    }
}
