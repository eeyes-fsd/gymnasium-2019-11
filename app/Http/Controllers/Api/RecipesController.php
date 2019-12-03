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

    public function new_recommend($request)
    {
        $recipes=Recipe::all()->reverse();
        $recipes->forPage($request->page ?? 1,  $request->count ?? 20);
        return $this->response->collection($recipes, new RecipeTransformer('recommend'));
    }
    public function today_recipe()
    {

    }
}
