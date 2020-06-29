<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Database\Schema\Builder;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        //
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        // This line solves this query exception:
        // SQLSTATE[42000]: Syntax error or access violation: 1071 Specified key was too long;
        // max key length is 767 bytes (SQL: alter table `users` add unique `users_email_unique`(`email`))
        Builder::defaultStringLength(191);
    }
}
