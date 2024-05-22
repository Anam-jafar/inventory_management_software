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
