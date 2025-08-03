<?php

namespace App\Providers;

use App\Models\Category;
use Illuminate\Support\Facades\View; 
use Illuminate\Support\ServiceProvider;

class CategoryServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap services.
     */
    public function boot(): void
    {
        View::composer('layout.layout', function ($view) {
            $view->with('cats', Category::all());
        });
        
    }
}
