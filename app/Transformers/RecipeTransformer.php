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
                foreach ($recipe->breakfast['ingredients'] as $ingredient) {
                    $ingredients[] = $ingredient['id'];
                }
                foreach ($recipe->lunch['ingredients'] as $ingredient) {
                    $ingredients[] = $ingredient['id'];
                }
                foreach ($recipe->dinner['ingredients'] as $ingredient) {
                    $ingredients[] = $ingredient['id'];
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
                        'ingredients' => $recipe->breakfast['ingredients'],
                        'photo' => $recipe->breakfast['cover'],
                        'step' => $recipe->breakfast_step,
                    ],
                    'lunch' => [
                        'ingredients' => $recipe->lunch['ingredients'],
                        'photo' => $recipe->lunch['cover'],
                        'step' => $recipe->lunch_step,
                    ],
                    'dinner' => [
                        'ingredients' => $recipe->dinner['ingredients'],
                        'photo' => $recipe->dinner['cover'],
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
