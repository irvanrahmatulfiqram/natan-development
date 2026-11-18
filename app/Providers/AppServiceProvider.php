<?php

namespace App\Providers;

use App\Models\Setting;
use Illuminate\Support\Facades\View;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    public function register(): void
    {
        //
    }

    public function boot(): void
    {
        View::composer([
            'public.home',
            'layouts.public',
            'layouts.admin',
        ], function ($view) {
            $view->with('siteSetting', Setting::current());
        });
    }
}
