<?php

namespace App\Providers;

use App\Models\User;
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
        //REGISTER USER MODEL SINGLETON
        $this->app->singleton(User::class, function(){
            if(session('id')){
                return User::where("id",session('id'))->first();
            }else{
                return User();
            }
        });
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        //
    }
}
