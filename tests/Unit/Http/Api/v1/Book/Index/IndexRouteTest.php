<?php

namespace Tests\Unit\Http\Api\v1\Book\Index;

use Illuminate\Support\Arr;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Str;
use Tests\CreatesApplication;
use Tests\TestCase;

class IndexRouteTest extends TestCase
{
    use CreatesApplication;

    protected $routeName = 'api.v1.books.index';
    protected $routeController = 'App\Http\Controllers\Api\V1\Books\IndexController';
    protected $routeMethod = '__invoke';

    public function test_route_name_exist()
    {
        $this->assertTrue(Route::has($this->routeName));
    }

    public function test_route_resolves_to_expected_url()
    {
        $slug = Str::random();

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
