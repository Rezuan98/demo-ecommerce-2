<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\View;
use App\Models\Category;
use App\Models\Brand;
use Cache;

class CategoryProvider extends ServiceProvider
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
        View::composer('*', function ($view) {
           $categories =  Category::where('status', 1)
            ->with(['subcategories' => function($query) {
                $query->where('status', 1);
            }])
            ->limit(10)
            ->get();
            
            $view->with('categories', $categories);
        });

        View::composer('*', function ($view) {
           $brands =  Brand::where('status', 1)->get();
            
            $view->with('brands', $brands);
        });
    }

   
}
