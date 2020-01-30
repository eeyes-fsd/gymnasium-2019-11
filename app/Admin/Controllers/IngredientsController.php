<?php

namespace App\Admin\Controllers;

use App\Models\Ingredient;
use Encore\Admin\Controllers\AdminController;
use Encore\Admin\Form;
use Encore\Admin\Grid;
use Encore\Admin\Show;

class IngredientsController extends AdminController
{
    /**
     * Title for current resource.
     *
     * @var string
     */
    protected $title = 'App\Models\Ingredient';

    /**
     * Make a grid builder.
     *
     * @return Grid
     */
    protected function grid()
    {
        $grid = new Grid(new Ingredient);

        $grid->column('id', __('Id'))->sortable();
        $grid->column('name', __('名称'));
        $grid->column('price', __('食材价格（分/g）'))->sortable();
        $grid->column('carbohydrate', __('碳水化合物能量含量 kCal/g'))->sortable();
        $grid->column('protein', __('蛋白质能量含量 kCal/g'))->sortable();
        $grid->column('fat', __('脂肪能量含量 kCal/g'))->sortable();

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
        $show = new Show(Ingredient::findOrFail($id));

        $show->field('id', __('Id'));
        $show->field('name', __('名称'));
        $show->field('price', __('食材价格（分/g）'));
        $show->field('carbohydrate', __('碳水化合物能量含量 kCal/g'));
        $show->field('protein', __('蛋白质能量含量 kCal/g'));
        $show->field('fat', __('脂肪能量含量 kCal/g'));

        return $show;
    }

    /**
     * Make a form builder.
     *
     * @return Form
     */
    protected function form()
    {
        $form = new Form(new Ingredient);

        $form->text('name', __('名称'));
        $form->number('price', __('食材价格（分/g）'));
        $form->decimal('carbohydrate', __('碳水化合物能量含量 kCal/g'));
        $form->decimal('protein', __('蛋白质能量含量 kCal/g'));
        $form->decimal('fat', __('脂肪能量含量 kCal/g'));

        $form->ignore(['created_at', 'updated_at']);

        return $form;
    }
}
