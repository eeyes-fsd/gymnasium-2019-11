<?php

namespace App\Http\Controllers\Api;

use App\Transformers\RecipeTransformer;
use Illuminate\Http\Request;
use App\Models\Recipe;

class RecipesController extends Controller
{
    /**
     * @param Recipe $recipe
     * @return mixed
     */
    public function show(Recipe $recipe)
    {
        return $this->response->item($recipe, new RecipeTransformer('item'));
    }

    /**
     * @return mixed
     */
    public function index()
    {
        $recipes = Recipe::all();
        return $this->response->collection($recipes, new RecipeTransformer('collection'));
    }
}
