<?php

namespace App\Providers;

use App\View\Composers\AdminComposer;
use App\View\Composers\WebComposer;
use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\View;

class ViewServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     *
     * @return void
     */
    public function register()
    {
        //
    }

    /**
     * Bootstrap services.
     *
     * @return void
     */
    public function boot()
    {
        View::composer('admin.dashboard.*', AdminComposer::class);
        View::composer('web.*', WebComposer::class);
    }
}
