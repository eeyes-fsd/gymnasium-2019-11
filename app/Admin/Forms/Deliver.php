<?php

namespace App\Admin\Forms;

use Encore\Admin\Widgets\Form;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class Deliver extends Form
{
    /**
     * The form title.
     *
     * @var string
     */
    public $title = '距离定价';

    /**
     * @var string
     */
    protected $table = 'deliver_fee';

    /**
     * Handle the form request.
     *
     * @param Request $request
     *
     * @return \Illuminate\Http\RedirectResponse
     */
    public function handle(Request $request)
    {
        DB::table($this->table)->truncate();

        foreach ($request->post('content') as $item) {
            DB::table($this->table)->insert([
                'lb' => $item['lb'],
                'ub' => $item['ub'],
                'fee' => (float)$item['fee'],
            ]);
        }

        admin_success('Processed successfully.');

        return back();
    }

    /**
     * Build a form here.
     */
    public function form()
    {
        $last = DB::table($this->table)->orderByDesc('ub')->first();
        if (!$last) { $last = new \stdClass(); $last->ub = 0;}

        $this->table('content', '', function ($form) use ($last) {
            $form->number('lb', '下界限')->min($last->ub);
            $form->number('ub', '上界限')->min($last->ub);
            $form->text('fee', '收费 分/km');
        });
    }

    /**
     * The data of the form.
     *
     * @return array $data
     */
    public function data()
    {
        $data = DB::table($this->table)->get();

        $data = $data->map(function ($data) {
            $temp = [];
            foreach ($data as $key => $datum) {
                $temp[$key] = $datum;
            }
            return $temp;
        });

        if (!$data->first()) {
            $data = ['content' => [
                'lb' => 0,
                'ub' => 0,
                'fee' => 0,
            ]];
        }

        return [
            'content' => $data,
        ];
    }
}
