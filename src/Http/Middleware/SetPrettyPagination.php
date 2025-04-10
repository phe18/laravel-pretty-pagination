<?php

namespace Nid\LaravelPrettyPagination\Http\Middleware;

use Closure;
use Nid\LaravelPrettyPagination\Pagination\LengthAwarePaginator;
use Nid\LaravelPrettyPagination\Pagination\Paginator;
use Illuminate\Container\Container;
use Illuminate\Http\Request;
use Illuminate\Pagination\LengthAwarePaginator as BaseLengthAwarePaginator;
use Illuminate\Pagination\Paginator as BasePaginator;

class SetPrettyPagination
{
    /**
     * Handle an incoming request.
     *
     * @param Request $request
     * @param Closure $next
     * @return mixed
     */
    public function handle(Request $request, Closure $next)
    {
        $container = Container::getInstance();

        $container->bind(BaseLengthAwarePaginator::class, LengthAwarePaginator::class);
        $container->bind(BasePaginator::class, Paginator::class);

        Paginator::currentPathResolver(function () use ($request) {
            return preg_replace('/\.page$/', '', $request->route()->getName());
        });

        Paginator::currentParametersResolver(function () use ($request) {
            return collect($request->route()->originalParameters())->forget('page')->all();
        });

        Paginator::currentPageResolver(function () use ($request) {
            return max((int)$request->route('page'), 1);
        });

        return $next($request);
    }
}
