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
                    'breakfast' => $recipe->breakfast,
                    'lunch' => $recipe->lunch,
                    'dinner' => $recipe->dinner,
                    'cover' => $recipe->cover,
                    'step' => $recipe->step,
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
