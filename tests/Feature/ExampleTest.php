<?php

namespace Tests\Feature;

// use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Http\Request;
use Tests\TestCase;

class ExampleTest extends TestCase
{
    /**
     * A basic test example.
     */
    public function test_the_root_route_points_to_the_admin_dashboard(): void
    {
        $route = app('router')->getRoutes()->match(Request::create('/', 'GET'));

        $this->assertSame('admin.index', $route->getName());
    }
}
