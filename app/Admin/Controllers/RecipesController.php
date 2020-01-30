<?php

namespace App\Admin\Controllers;

use App\Models\Ingredient;
use App\Models\Recipe;
use Encore\Admin\Controllers\AdminController;
use Encore\Admin\Form;
use Encore\Admin\Grid;
use Encore\Admin\Show;

class RecipesController extends AdminController
{
    /**
     * Title for current resource.
     *
     * @var string
     */
    protected $title = '食谱管理';

    /**
     * Make a grid builder.
     *
     * @return Grid
     */
    protected function grid()
    {
        $grid = new Grid(new Recipe);

        $grid->column('id', 'Id');
        $grid->column('price', 'Price');
        $grid->column('name', 'Name');
        $grid->column('cover', 'Cover');
        $grid->column('description', 'Description');
        $grid->column('breakfast', 'Breakfast')->display(function ($ingredients) {
            return view('recipe', compact('ingredients'));
        });
        $grid->column('lunch', 'Lunch')->display(function ($ingredients) {
            return view('recipe', compact('ingredients'));
        });
        $grid->column('dinner', 'Dinner')->display(function ($ingredients) {
            return view('recipe', compact('ingredients'));
        });
        $grid->column('cook_cost', 'Cook cost');
        $grid->column('created_at', 'Created at');
        $grid->column('updated_at', 'Updated at');

        return $grid;
    }

    /**
     * Make a show builder.
     *
     * @param mixed $id
     * @return Show
     */
    protected function detail($id)
    {
        $show = new Show(Recipe::findOrFail($id));

        $show->field('id', 'Id');
        $show->field('price', '食谱价格');
        $show->field('name', '食谱名称');
        $show->field('cover', '食谱封面');
        $show->field('description', '食谱描述');
        $show->field('breakfast_cover', '早餐封面图');
        $show->field('breakfast', '早餐内容')->as(function ($ingredients) {
            return view('recipe', compact('ingredients'));
        });
        $show->field('breakfast_step', '早餐制作步骤');
        $show->field('lunch_cover', '午餐封面图');
        $show->field('lunch', '午餐内容')->as(function ($ingredients) {
            return view('recipe', compact('ingredients'));
        });
        $show->field('lunch_step', '午餐制作步骤');
        $show->field('dinner_cover', '晚餐封面图');
        $show->field('dinner', '晚餐内容')->as(function ($ingredients) {
            return view('recipe', compact('ingredients'));
        });
        $show->field('dinner_step', '晚餐制作步骤');
        $show->field('cook_cost', '烹饪加工费用（分）');
        $show->field('created_at', 'Created at');
        $show->field('updated_at', 'Updated at');

        return $show;
    }

    /**
     * Make a form builder.
     *
     * @return Form
     */
    protected function form()
    {
        $form = new Form(new Recipe);

        $load_ingredients = function () {
            $ingredients = Ingredient::all();
            $result = [];
            foreach ($ingredients as $ingredient) {
                $result[$ingredient->id] = $ingredient->name;
            }
            return $result;
        };

        $form->number('price', '食谱价格');
        $form->text('name', '食谱名称');
        $form->image('cover', '食谱封面')->move('public/recipes');
        $form->text('description', '食谱描述');
        $form->image('breakfast_cover')->move('public/meals');
        $form->table('breakfast', '早餐', function (Form\NestedForm $table) use ($load_ingredients) {
            $table->select('ingredients', '食材')->options($load_ingredients);
            $table->number('最少用量 g');
        });
        $form->simditor('breakfast_step', '早餐制作步骤');
        $form->image('lunch_cover')->move('public/meals');
        $form->table('lunch', '午餐', function (Form\NestedForm $table) use ($load_ingredients) {
            $table->select('ingredients', '食材')->options($load_ingredients);
            $table->number('最少用量 g');
        });
        $form->simditor('lunch_step', '午餐制作步骤');
        $form->image('dinner_cover')->move('public/meals');
        $form->table('dinner', '晚餐', function (Form\NestedForm $table) use ($load_ingredients) {
            $table->select('ingredients', '食材')->options($load_ingredients);
            $table->number('最少用量 g');
        });
        $form->simditor('dinner_step', '晚餐制作步骤');
        $form->number('cook_cost', '烹饪价格');

        return $form;
    }
}
