<?php

namespace App\Http\Controllers;

use App\Transformers\RecipeTransformer;
use Illuminate\Http\Request;
use App\Models\Recipe;

class RecipesController extends Controller
{

    public function show(Recipe $recipe)
    {
        return $this->response->item($recipe, new RecipeTransformer('item'));
    }
    public function  index()
    {
        $recipes = Recipe::all();
        return $this->response->collection($recipes, new RecipeTransformer('collection'));
    }
}
