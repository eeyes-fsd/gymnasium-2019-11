<?php

namespace App\Http\Controllers\Api;

use App\Transformers\RecipeTransformer;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Http\Request;
use App\Models\Recipe;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Cache;

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
     * @param $class
     * @param Request $request
     * @return mixed
     */
    public function index(Request $request, $class='all')
    {
        switch ($class)
        {
            case 'bought':
                if (!Auth::guard('api')->check()) return $this->response->errorUnauthorized("未登录，无法查看");
                $recipes = Auth::guard('api')->user()->recipes;
                break;

            case 'all':
                $recipes = Recipe::all();
                break;

            case 'new':
                $recipes=Recipe::all()->reverse();
                $recipes->forPage($request->page ?? 1,  $request->count ?? 20);
                break;

            case 'today':
                if (!Auth::guard('api')->check()) return $this->response->errorUnauthorized("未登录，无法查看");
                if (!$recipes = Cache::get('user:' . Auth::guard('api')->user()->id . ':today')) return $this->response->noContent();
                $recipes = Recipe::where('id', $recipes)->get();
                break;

            default:
                $recipes = collect();
        }

        return $this->response->collection($recipes, new RecipeTransformer('collection'));
    }
}
