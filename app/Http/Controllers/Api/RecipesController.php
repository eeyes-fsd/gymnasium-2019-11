<?php

namespace App\Http\Controllers\Api;

use App\Handlers\AlgorithmHandler;
use App\Models\Diet;
use App\Models\Ingredient;
use App\Transformers\RecipeTransformer;
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
        if (!Auth::guard('api')->user()->has_recipe($recipe)) abort(404, '您还未购买此食谱');

        if (!$diet = Diet::where('user_id', Auth::guard('api')->id())->where('recipe_id', $recipe->id)->first()) {
            $handler = new AlgorithmHandler();
            $diet = $handler->calculate_dist(Auth::guard('api')->user()->health, $recipe);
            $diet->save();
        }

        foreach (['breakfast', 'lunch', 'dinner'] as $item) {
            $temp = [];
            $temp['cover'] = $recipe->$item['cover'];
            $temp['nutrient'] = ['carbohydrate' => 0,'protein' => 0,'fat' => 0,];
            foreach ($diet->$item as $ingredient) {
                $ingredient_instance = Ingredient::find($ingredient['id']);
                $temp['ingredients'][] = [
                    'name' => $ingredient_instance->name,
                    'amount' => $ingredient['amount']
                ];
                $temp['nutrient']['carbohydrate'] += $ingredient_instance->carbohydrate;
                $temp['nutrient']['protein'] += $ingredient_instance->protein;
                $temp['nutrient']['fat'] += $ingredient_instance->fat;
            }

            $recipe->$item = $temp;
        }

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
