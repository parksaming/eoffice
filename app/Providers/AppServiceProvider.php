<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use App\Services\FormBuilder;
use Illuminate\Support\Facades\View;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        FormBuilder::boot();
        $combobox = array(
            '1'    =>  'Bình Thường',
            '2'          =>  'Khẩn',
            '3'    =>  'Thượng Khẩn',
            '4'        =>  'Hỏa Tốc'
        );
        $countcombo = count($combobox);
        View::share('combobox',$combobox);
        View::share('countcombo',$countcombo);
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