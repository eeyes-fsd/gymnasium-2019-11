<?php

namespace App\Transformers;

use App\Models\Recipe;
use Illuminate\Support\Facades\DB;
use League\Fractal\TransformerAbstract;

class RecipeTransformer extends TransformerAbstract
{
    private $type;

    public function __construct($type=null)
    {
        $this->type = $type;
    }

    public function transform(Recipe $recipe)
    {
        switch ($this->type){
            case 'collection':
                $ingredients = [];
                foreach ($recipe->breakfast as $ingredient) {
                    $ingredients[] = $ingredient['id'];
                }
                foreach ($recipe->lunch as $ingredient) {
                    $ingredients[] = $ingredient['id'];
                }
                foreach ($recipe->dinner as $ingredient) {
                    $ingredients[] = $ingredient['id'];
                }

                $ingredients = collect($ingredients)->unique();

                $ingredients = $ingredients->map(function ($id) {
                   return DB::table('ingredients')->find($id)->name;
                });

                return [
                    'id' => $recipe->id,
                    'name' => $recipe->name,
                    'cover' => url(str_replace('public', 'storage', $recipe->cover)),
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
                        'nutrient' => $recipe->breakfast['nutrient'],
                        'ingredients' => $recipe->breakfast,
                        'photo' => url(str_replace('public', 'storage', $recipe->breakfast_cover)),
                        'step' => $recipe->breakfast_step,
                    ],
                    'lunch' => [
                        'nutrient' => $recipe->lunch['nutrient'],
                        'ingredients' => $recipe->lunch,
                        'photo' => url(str_replace('public', 'storage', $recipe->lunch_cover)),
                        'step' => $recipe->lunch_step,
                    ],
                    'dinner' => [
                        'nutrient' => $recipe->dinner['nutrient'],
                        'ingredients' => $recipe->dinner,
                        'photo' => url(str_replace('public', 'storage', $recipe->dinner_cover)),
                        'step' => $recipe->dinner_step,
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
