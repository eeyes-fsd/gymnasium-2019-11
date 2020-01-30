<?php

use App\Models\Variable;
use Illuminate\Database\Seeder;

class VariablesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        if (Variable::where('name', 'recipe_discount')->exists()) return;

        $data = [
            'free' => false,
            '3' => 0.8,
            'all' => 0.6
        ];

        Variable::create([
            'name' => 'recipe_discount',
            'setter' => 'serialize',
            'getter' => 'unserialize',
            'content' => $data,
        ]);
    }
}
