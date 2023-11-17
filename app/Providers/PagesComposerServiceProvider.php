<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use App\Models\Page;

class PagesComposerServiceProvider extends ServiceProvider
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
        view()->composer('*', function ($view) {
            $navPages = Page::orderBy('order')->get();
            $view->with('navPages', $navPages);
        });
    }
}
