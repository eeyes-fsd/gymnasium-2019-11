<?php
/**
 * Created by PhpStorm.
 * User: Bright
 * Date: 2019/11/19
 * Time: 21:06
 */

namespace App\Transformers;


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
                    'picture' => $recipe->picture,
                    'description' => $recipe->description,
                ];

            case 'item':
                return [
                    'id' => $recipe->id,
                    'name' => $recipe->name,
                    'cover' => $recipe->cover,
                    'breakfast' => [
                        'ingredients' => $recipe->breakfast->ingredients,
                        'nutrient'=>[
                            $recipe->breakfast->fat,
                            $recipe->breakfast->protein,
                            $recipe->breakfast->carbohydrate,
                        ],
                        'step'=>$recipe->step,
                    ],
                    'lunch' => [
                        'ingredients' => $recipe->lunch->ingredients,
                        'nutrient'=>[
                            $recipe->lunch->fat,
                            $recipe->lunch->protein,
                            $recipe->lunch->carbohydrate,
                        ],
                        'step'=>$recipe->step,
                    ],
                    'dinner' => [
                        'ingredients' => $recipe->dinner->ingredients,
                        'nutrient'=>[
                            $recipe->dinner->fat,
                            $recipe->dinner->protein,
                            $recipe->dinner->carbohydrate,
                        ],
                        'step'=>$recipe->step,
                    ],

                ];
            case 'recommend':
                return[
                    'id' => $recipe->id,
                    'name' => $recipe->name,
                    'picture' => $recipe->picture,
                ];
            case '':
        }
    }
}
