<?php

namespace App\Admin\Controllers;

use App\Models\User;
use Encore\Admin\Controllers\AdminController;
use Encore\Admin\Form;
use Encore\Admin\Grid;
use Encore\Admin\Show;

class UsersController extends AdminController
{
    /**
     * Title for current resource.
     *
     * @var string
     */
    protected $title = '用户管理';

    /**
     * Make a grid builder.
     *
     * @return Grid
     */
    protected function grid()
    {
        $grid = new Grid(new User);

        $grid->column('id','ID');
        $grid->column('name','用户名');
        $grid->column('phone','手机号');
        $grid->column('wx_openid','微信 Open ID');
        $grid->column('wx_session_key','微信 会话密钥');
        $grid->column('share_id','分享 ID');
        $grid->column('remember_token','Remember token');
        $grid->column('created_at','Created at');
        $grid->column('updated_at','Updated at');

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
        $show = new Show(User::findOrFail($id));

        $show->field('id', __('ID'));
        $show->field('name', __('用户名'));
        $show->field('phone', __('手机号'));
        $show->field('wx_openid', __('微信 Open ID'));
        $show->field('wx_session_key', __('微信 会话密钥'));
        $show->field('share_id', __('分享 ID'));
        $show->field('remember_token', __('Remember token'));
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
        $form = new Form(new User);

        $form->text('name', __('Name'));
        $form->mobile('phone', __('Phone'));
        $form->text('wx_openid', __('Wx openid'));
        $form->text('wx_session_key', __('Wx session key'));

        return $form;
    }
}
