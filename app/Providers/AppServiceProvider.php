<?php

namespace App\Providers;

use App\Models\Category;
use Illuminate\Pagination\Paginator;
use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\View;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {

        View::composer('layouts.website.front',function($view){
            $locale = app()->getLocale();
            $headerCategories = Category::query()
            ->VisibleForLocale($locale)
            ->orderBy('name')
            ->get()
            ->filter(fn(Category $category) => $category->isVisibleForLocale($locale))
            ->values();
            $view->with('headerCategories', $headerCategories);
        });


        Paginator::useBootstrapFour();
        //
        Validator::extend(
            'filter',
            function ($attribute, $value) {
                if ($value === 'bar') {
                    return false;
                }
                if ($value === 'food') {
                    return false;
                }
                return true;
            },
            "the is not allowed"
        );
    }
}
