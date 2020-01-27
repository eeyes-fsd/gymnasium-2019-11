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
                    'cover' => $recipe->cover,
                    'price' => $recipe->price,
                    'description' => $recipe->description,
                    'details' => $recipe->breakfast_step,
                ];
                break;

            case 'collection':
                return [
                    'id' => $recipe->id,
                    'cover' => $recipe->cover,
                    'price' => $recipe->price,
                    'description' => $recipe->description,
                ];
                break;
        }
    }
}
