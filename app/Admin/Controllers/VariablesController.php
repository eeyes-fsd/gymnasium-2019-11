<?php

namespace App\Admin\Controllers;

use App\Models\Variable;
use Encore\Admin\Controllers\AdminController;
use Encore\Admin\Form;
use Encore\Admin\Grid;
use Encore\Admin\Show;

class VariablesController extends AdminController
{
    /**
     * Title for current resource.
     *
     * @var string
     */
    protected $title = '产品变量设置';

    /**
     * Make a grid builder.
     *
     * @return Grid
     */
    protected function grid()
    {
        $grid = new Grid(new Variable);

        $grid->column('id', 'ID');
        $grid->column('name', '变量名');
        $grid->column('content', '变量内容');
        $grid->column('created_at', __('Created at'));
        $grid->column('updated_at', __('Updated at'));

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
        $show = new Show(Variable::findOrFail($id));

        $show->field('id', __('Id'));
        $show->field('name', __('变量名'));
        $show->field('content', __('变量内容'))->as(function ($variables) {
            return view('variable', compact('variables'));
        })->unescape();
        $show->field('setter', __('变量存储器'));
        $show->field('getter', __('变量获取器'));
        $show->field('created_at', __('Created at'));
        $show->field('updated_at', __('Updated at'));

        return $show;
    }

    /**
     * Make a form builder.
     *
     * @return Form
     */
    protected function form()
    {
        $form = new Form(new Variable);

        $form->text('name', '变量名');
        $form->keyValue('content', '变量内容');
        $form->text('setter', '变量存储器');
        $form->text('getter', '变量获取器');

        return $form;
    }
}
