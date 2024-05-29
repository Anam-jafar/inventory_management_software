<?php

namespace App\Providers;

use Illuminate\Support\Facades\Schema;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        config(['status' => [
            'active' => 1,
            'inactive' => 0
        ]]);
        config(['deleted' => 1]);
        config(['payment_status' => [
            'paid' => 2,
            'partially_paid' => 1,
            'not_paid' => 0,
            '0' => 'not paid',
            '1' => 'partially paid',
            '2' => 'paid'
        ]]);

        config(['expense_type' => [
            'raw_material' => 1,
            'factory_rent' => 2,
            'food' => 3,
            'electricity' => 4,
            'repair_machine' => 5 ,
            'new_machine' => 6,
            'others' => 0,
        ]]);

        config(['salary' => [
            'paid' => 1,
            'partially_paid' =>2
        ]]);
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        Schema::defaultStringLength(191);

    }
}
