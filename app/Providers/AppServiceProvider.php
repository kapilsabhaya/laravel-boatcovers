<?php

namespace App\Providers;

use App\Models\Make;
use App\Models\Option;
use App\Models\Product;
use App\Models\Category;
use App\Models\OptionValue;
use App\Repositories\HomeRepository;
use App\Repositories\OptionRepository;
use App\Repositories\ProductRepository;
use Illuminate\Support\ServiceProvider;
use App\Repositories\CategoryRepository;
use App\Repositories\OptionValueRepository;
use App\Repositories\DisplayProductRepository;
use App\Repositories\MasterCategoryRepository;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        $this->app->bind(HomeService::class, function ($app) {
            return new HomeService(new HomeRepository(new Category()));
        });

        $this->app->bind(DisplayProductService::class, function ($app) {
            return new DisplayProductService(new DisplayProductRepository(new Make()));
        });

        $this->app->bind(CategoryService::class, function ($app) {
            return new CategoryService(new CategoryRepository(new Category()));
        });
        $this->app->bind(MasterCategoryService::class, function ($app) {
            return new MasterCategoryService(new MasterCategoryRepository(new Category()));
        });
        $this->app->bind(OptionService::class, function ($app) {
            return new OptionService(new OptionRepository(new Option()));
        });
        $this->app->bind(OptionalueService::class, function ($app) {
            return new OptionValueService(new OptionValueRepository(new OptionValue()));
        });
        $this->app->bind(ProductService::class, function ($app) {
            return new ProductService(new ProductRepository(new Product()));
        });
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        //
    }
}
