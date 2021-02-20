<?php

namespace Tests\Feature\Http\Routes\Api\v1\Book;

use Illuminate\Support\Arr;
use Illuminate\Support\Facades\Route;
use Tests\TestCase;

class StoreRouteTest extends TestCase
{
    protected $routeName = 'api.v1.books.store';
    protected $routeUrl = '/api/v1/books';
    protected $routeController = 'App\Http\Controllers\Api\V1\Books\StoreController';
    protected $routeMethod = '__invoke';

    public function test_route_name_exist()
    {
        $this->assertTrue(Route::has($this->routeName));
    }

    public function test_route_resolves_to_expected_url()
    {
        $resolvedUrl = route($this->routeName);
        $this->assertSame(url('/api/v1/books'), $resolvedUrl);
    }

    public function test_route_resolves_to_expected_controller()
    {
        $routes = Route::getRoutes()->getRoutesByName();
        $route = Arr::get($routes, $this->routeName);

        $resolvedController = Arr::get($route->action, 'controller');

        $this->assertSame($this->routeController, $resolvedController);
    }

    public function test_route_resolves_to_expected_controller_method()
    {
        $routes = Route::getRoutes()->getRoutesByName();
        $route = Arr::get($routes, $this->routeName);

        $expectedUses = $this->routeController.'@'.$this->routeMethod;
        $resolvedUses = Arr::get($route->action, 'uses');

        $this->assertSame($expectedUses, $resolvedUses);
    }
}
