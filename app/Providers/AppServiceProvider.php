<?php

namespace App\Providers;

use Carbon\Carbon;
use Illuminate\Support\ServiceProvider;
use DB;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        //本地化Carbon
        Carbon::setLocale('zh');



        //打印sql
         /*DB::listen(function($sql) {
             dump($sql);
             // echo $sql->sql;
             // dump($sql->bindings);
         });*/

    }

    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        //
    }
}
