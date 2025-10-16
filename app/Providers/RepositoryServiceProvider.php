<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use App\Repositories\BaseRepositoryInterface;
use App\Repositories\CategoryRepository;
use App\Repositories\BrandRepository;
use App\Repositories\ProductRepository;
use App\Repositories\UserRepository;
use App\Services\CategoryService;
use App\Services\BrandService;
use App\Services\ProductService;
use App\Services\UserService;

class RepositoryServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     */
    public function register(): void
    {
        $this->app->bind(BaseRepositoryInterface::class, BrandRepository::class);

        $this->app->when(CategoryService::class)
            ->needs(BaseRepositoryInterface::class)
            ->give(CategoryRepository::class);

        $this->app->when(BrandService::class)
            ->needs(BaseRepositoryInterface::class)
            ->give(BrandRepository::class);

        $this->app->when(ProductService::class)
            ->needs(BaseRepositoryInterface::class)
            ->give(ProductRepository::class);
    }

    /**
     * Bootstrap services.
     */
    public function boot(): void
    {
        //
    }
}
