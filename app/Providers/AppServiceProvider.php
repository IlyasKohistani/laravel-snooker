<?php

namespace App\Providers;

use App\Http\ViewComposers\GlobalComposer;
use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Auth;
use Illuminate\Contracts\View\Factory as ViewFactory;

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
    public function boot(ViewFactory $view)
    {

        $view->composer(['layouts.app', 'groups.index'], 'App\Http\ViewComposers\GlobalComposer');
    }
}
