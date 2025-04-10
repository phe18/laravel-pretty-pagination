<?php

namespace Nid\LaravelPrettyPagination\Providers;

use Nid\LaravelPrettyPagination\Routing\Route;
use Illuminate\Routing\Route as BaseRoute;
use Illuminate\Support\ServiceProvider;

class PrettyPaginationProvider extends ServiceProvider
{
    /**
     * Register services.
     *
     * @return void
     */
    public function register()
    {
        BaseRoute::mixin(new Route());
    }
}
