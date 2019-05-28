<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use App\Util\CustomValidator;

class ValidateServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     *
     * @return void
     */
    public function register()
    {
        $this->app->bind(CustomValidator::class,function($app){
            return new CustomValidator;
        })
    }

    /**
     * Bootstrap services.
     *
     * @return void
     */
    public function boot()
    {
        //
    }
}
