<?php

namespace App\Http\Controllers\Api;

use App\Transformers\RecipeTransformer;
use Illuminate\Http\Request;
use App\Models\Recipe;
use Illuminate\Support\Facades\Auth;

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
    public function index(Request $request)
    {
        switch ($request->class)
        {
            case 'bought':
                if (!Auth::guard('api')->check()) return $this->response->errorUnauthorized("未登录，无法查看");
                $recipes = Auth::guard('api')->user()->recipes;
                break;

            case 'all':
                $recipes = Recipe::all();
                break;
        }

        return $this->response->collection($recipes, new RecipeTransformer('collection'));
    }
}
