<?php

namespace App\Http\Controllers\Api;

use App\Models\Recipe;
use App\Models\Ingredient;
use Illuminate\Http\Request;
use App\Handlers\AlgorithmHandler;
use Illuminate\Support\Facades\Auth;
use App\Transformers\DietTransformer;

class DietsController extends Controller
{
    /**
     * @param Request $request
     * @return \Dingo\Api\Http\Response
     */
    public function index(Request $request)
    {
        $diets = Recipe::all();

        $diets->forPage($request->page ?? 1, $request->per_page ?? 20);

        foreach ($diets as $diet) {
            $price = 0;

            foreach (['breakfast', 'lunch', 'dinner'] as $item) {
                foreach ($diet->$item as $ingredient) {
                    $price += $ingredient['min'] * Ingredient::find($ingredient['id'])->price;
                }
            }

            $diet->ingredients_price = $price;
            $diet->diet_price = $price + $diet->cook_cost;
        }

        return $this->response->collection($diets, new DietTransformer('collection'));
    }

    /**
     * @param Recipe $recipe
     * @return \Dingo\Api\Http\Response
     */
    public function show(Recipe $recipe)
    {
        $handler = new AlgorithmHandler();
        $health = Auth::guard('api')->user()->health;
        $diet = $handler->calculate_dist($health, $recipe);

        $price = 0; $weight = 0;

        foreach (['breakfast', 'lunch', 'dinner'] as $item) {
            foreach ($diet->$item as $ingredient) {
                $price += $ingredient['amount'] * Ingredient::find($ingredient['id'])->price;
                $weight += $ingredient['amount'];
            }
        }

        $recipe->ingredients_price = $price;
        $recipe->diet_price = $price + $diet->cook_cost;
        $recipe->weight = $weight;

        return $this->response->item($recipe, new DietTransformer('item'));
    }
}
