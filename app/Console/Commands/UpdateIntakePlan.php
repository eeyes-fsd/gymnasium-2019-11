<?php

namespace App\Console\Commands;

use App\Models\User;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Cache;

class UpdateIntakePlan extends Command
{

    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'intake:update';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = '更新用户的饮食控制数据';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        $users = User::all();

        $users->each(function (User $user) {
            if (Cache::has('user:' . $user->id . ':intake_lt')) {
                $live_time = Cache::get('user:' . $user->id . ':intake_lt');
                Cache::set('user:' . $user->id . ':intake_lt', $live_time + 1);
            }
        });

        return 0;
    }
}
