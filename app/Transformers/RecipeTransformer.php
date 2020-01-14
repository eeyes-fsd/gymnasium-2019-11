<?php

namespace App\Transformers;

use App\Models\Recipe;
use Illuminate\Support\Facades\DB;
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
                $ingredients = [];
                foreach ($recipe->breakfast as $ingredient) {
                    $ingredients[] = $ingredient;
                }
                foreach ($recipe->lunch as $ingredient) {
                    $ingredients[] = $ingredient;
                }
                foreach ($recipe->dinner as $ingredient) {
                    $ingredients[] = $ingredient;
                }

                $ingredients = collect($ingredients)->unique();

                $ingredients = $ingredients->map(function ($id) {
                   return DB::table('ingredients')->find($id)->name;
                });

                return [
                    'id' => $recipe->id,
                    'name' => $recipe->name,
                    'cover' => $recipe->cover,
                    'price' => $recipe->price,
                    'ingredients' => $ingredients->all(),
                    'description' => $recipe->description,
                ];

            case 'item':
                return [
                    'id' => $recipe->id,
                    'name' => $recipe->name,
                    'cover' => $recipe->cover,
                    'breakfast' => [
                        'ingredients' => $recipe->breakfast->ingredients,
                        'photo' => $recipe->breakfast->photo,
                        'nutrient' =>[
                            'fat' => $recipe->breakfast->fat,
                            'protein' => $recipe->breakfast->protein,
                            'carbohydrate' => $recipe->breakfast->carbohydrate,
                        ],
                        'step' => $recipe->breakfast->step,
                    ],
                    'lunch' => [
                        'ingredients' => $recipe->lunch->ingredients,
                        'photo' => $recipe->lunch->photo,
                        'nutrient' =>[
                            'fat' => $recipe->breakfast->fat,
                            'protein' => $recipe->breakfast->protein,
                            'carbohydrate' => $recipe->breakfast->carbohydrate,
                        ],
                        'step' => $recipe->lunch->step,
                    ],
                    'dinner' => [
                        'ingredients' => $recipe->dinner->ingredients,
                        'photo' => $recipe->dinner->photo,
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
