<?php

namespace App\Console\Commands;

use App\Models\User;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Cache;

class UpdateDailyRecommend extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'recommend:update';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = '更新所有用户的每日推荐';

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        $users = User::all()->load('recipes');

        $users = $users->filter(function ($user) {
            return $user->recipes->isNotEmpty();
        });

        $users->each(function (User $user) {
            if (!Cache::has('user:' . $user->id . ':today')) {
                Cache::forever('user:' . $user->id . ':today', $user->recipes->first()->id);
            } else {
                $recipes = $user->recipes->pluck('id');
                $current_recipe = Cache::get('user:' . $user->id . ':today');
                $current_index = $recipes->search($current_recipe);
                $next_index = $current_index + 2 > $recipes->count() ? 0 : $current_index + 1;
                Cache::put('user:' . $user->id . ':today', $recipes[$next_index]);
            }
        });
        return 0;
    }
}
