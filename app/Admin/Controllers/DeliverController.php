<?php

namespace App\Admin\Controllers;

use App\Admin\Forms\Deliver;
use App\Admin\Forms\Time;
use App\Admin\Forms\Weight;
use Encore\Admin\Controllers\AdminController;
use Encore\Admin\Widgets\Tab;
use Encore\Admin\Layout\Content;

class DeliverController extends AdminController
{
    public function index(Content $content)
    {
        $forms = [
            '距离' => Deliver::class,
            '重量' => Weight::class,
            '时间' => Time::class,
        ];

        $content->title('配送设置')
            ->body(Tab::forms($forms));

        return $content;
    }
}
