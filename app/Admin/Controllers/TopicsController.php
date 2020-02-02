<?php

namespace App\Admin\Controllers;

use App\Models\Topic;
use App\Models\User;
use Encore\Admin\Controllers\AdminController;
use Encore\Admin\Form;
use Encore\Admin\Grid;
use Encore\Admin\Show;

class TopicsController extends AdminController
{
    /**
     * Title for current resource.
     *
     * @var string
     */
    protected $title = '话题管理';

    /**
     * Make a grid builder.
     *
     * @return Grid
     */
    protected function grid()
    {
        $grid = new Grid(new Topic);

        $grid->model()->orderBy('updated_at', 'desc');

        $grid->column('id', __('Id'));
        $grid->column('user_id', '用户')->display(function ($user_id) {
            $user = User::find($user_id);
            return '<link rel="' . route('admin.users.show', $user->id) . '">' . $user->name . '</link>';
        });
        $grid->column('title', __('标题'));
        $grid->column('status', '状态')->using([
            0 => '未审核',
            1 => '正常',
            2 => '举报',
            3 => '违规',
        ]);
        $grid->column('short', __('简介'));
        $grid->column('body', __('内容'));
        $grid->column('created_at', __('Created at'));
        $grid->column('updated_at', __('Updated at'));

        $grid->disableCreateButton();

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
        $show = new Show(Topic::findOrFail($id));

        $show->field('id', __('Id'));
        $show->field('status')->as(function ($status) {
            return [
                0 => '未审核',
                1 => '正常',
                2 => '举报',
                3 => '违规',
            ][$status];
        });
        $show->field('user_id', __('用户'))->as(function ($user_id) {
            $user = User::find($user_id);
            return '<link rel="' . route('admin.users.show', $user->id) . '">' . $user->name . '</link>';
        });
        $show->field('title', '标题');
        $show->field('short', '简介');
        $show->field('body', '内容');
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
        $form = new Form(new Topic);

        $form->radio('status', '状态')->options([
            0 => '未审核',
            1 => '正常',
            3 => '违规',
        ]);

        return $form;
    }
}
