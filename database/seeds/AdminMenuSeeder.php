<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class AdminMenuSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        if (DB::table('admin_menu')->where('title', '食材管理')->first()) {
            return;
        }

        $data = [
            ['title' => '食材管理', 'icon' => 'fa-envira', 'uri' => 'ingredients'],
            ['title' => '食谱管理', 'icon' => 'fa-book', 'uri' => 'recipes'],
            ['title' => '变量管理', 'icon' => 'fa-shopping-bag', 'uri' => 'variables'],
            ['title' => '站点管理', 'icon' => 'fa-calculator', 'uri' => 'services'],
            ['title' => '故事管理', 'icon' => 'fa-newspaper-o', 'uri' => 'topics'],
            ['title' => '配送管理', 'icon' => 'fa-motorcycle', 'uri' => 'deliver'],
        ];

        foreach ($data as $datum) {
            DB::table('admin_menu')->insert($datum);
        }
    }
}
