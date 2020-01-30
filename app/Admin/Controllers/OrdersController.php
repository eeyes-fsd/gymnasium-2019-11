<?php

namespace App\Admin\Controllers;

use App\Models\Order;
use App\Models\Service;
use App\Models\User;
use Encore\Admin\Controllers\AdminController;
use Encore\Admin\Form;
use Encore\Admin\Grid;
use Encore\Admin\Show;

class OrdersController extends AdminController
{
    /**
     * Title for current resource.
     *
     * @var string
     */
    protected $title = '订单管理';

    /**
     * Make a grid builder.
     *
     * @return Grid
     */
    protected function grid()
    {
        $grid = new Grid(new Order);

        $grid->column('id', __('订单号'));
        $grid->column('user_id', __('用户ID'));
        $grid->column('service_id', __('服务点'))->display(function ($id) {
            $service = Service::find($id);
            return $id . '-' . $service->name;
        });
        $grid->column('fee', __('订单价格'));
        $grid->column('address_id', __('配送地址ID'))->sortable();
        $grid->column('deliver_at', __('配送时间'))->sortable();
        $grid->column('details', __('订单内容'));
        $grid->column('refund_no', __('退款订单号'));
        $grid->column('status', __('订单状态'))->display(function ($status) {
            return [
                -1 => '已取消',
                0 => '未支付',
                1 => '已支付',
                2 => '配送中',
                3 => '已完成'
            ][$status];
        });
        $grid->column('created_at', __('Created at'))->sortable();
        $grid->column('updated_at', __('Updated at'))->sortable();

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
        $show = new Show(Order::findOrFail($id));

        $show->field('id', __('Id'));
        $show->field('user_id', __('User id'));
        $show->field('service_id', __('Service id'));
        $show->field('fee', __('Fee'));
        $show->field('address_id', __('Address id'));
        $show->field('deliver_at', __('Deliver at'));
        $show->field('details', __('Details'));
        $show->field('refund_no', __('Refund no'));
        $show->field('status', __('Status'));
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
        $form = new Form(new Order);

        $form->number('user_id', __('User id'));
        $form->number('service_id', __('Service id'));
        $form->number('fee', __('Fee'));
        $form->number('address_id', __('Address id'));
        $form->datetime('deliver_at', __('Deliver at'))->default(date('Y-m-d H:i:s'));
        $form->textarea('details', __('Details'));
        $form->text('refund_no', __('Refund no'));
        $form->number('status', __('Status'));

        return $form;
    }
}
