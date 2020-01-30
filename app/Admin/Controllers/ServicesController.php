<?php

namespace App\Admin\Controllers;

use App\Models\Service;
use Encore\Admin\Controllers\AdminController;
use Encore\Admin\Form;
use Encore\Admin\Grid;
use Encore\Admin\Show;

class ServicesController extends AdminController
{
    /**
     * Title for current resource.
     *
     * @var string
     */
    protected $title = '服务点管理';

    /**
     * Make a grid builder.
     *
     * @return Grid
     */
    protected function grid()
    {
        $grid = new Grid(new Service);

        $grid->column('id', 'ID');
        $grid->column('name', '服务点名称');
        $grid->column('street', '服务点街道');
        $grid->column('detail', '服务点详细地址');
        $grid->column('longitude', '服务点经度');
        $grid->column('latitude', '服务点纬度');
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
        $show = new Show(Service::findOrFail($id));

        $show->field('id', 'ID');
        $show->field('name', '服务点名称');
        $show->field('street', '服务点街道');
        $show->field('detail', '服务点详细地址');
        $show->field('Position')->latlong('latitude', 'longitude', $height = 400, $zoom = 16);
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
        $form = new Form(new Service);

        $form->text('name', __('服务点名称'));
        $form->text('street', __('服务点街道'));
        $form->text('detail', __('服务点详细地址'));
        $form->latlong('latitude', 'longitude', '位置');

        return $form;
    }
}
