<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

class HomeController extends Controller
{
    public function index()
    {
        $routes = Route::getRoutes();
        $apisData = [];
        $id = 1;

        foreach ($routes as $route) {
            // Filter to include only API routes (checking 'api' middleware or prefix)
            if (in_array('api', $route->middleware()) || str_starts_with($route->uri(), 'api')) {
                $method = $route->methods()[0];
                // Ignore HEAD requests, pick the actual method
                if ($method === 'HEAD' && isset($route->methods()[1])) {
                    $method = $route->methods()[1];
                }

                // Provide default empty object for requests that typically need a body
                $defaultBody = in_array($method, ['POST', 'PUT', 'PATCH']) ? new \stdClass() : null;

                $apisData[] = [
                    'id' => $id++,
                    'name' => '/' . $route->uri(),
                    'method' => $method,
                    'endpoint' => url($route->uri()),
                    'status' => 'active',
                    'auth' => in_array('auth:api', $route->middleware()) ? 'Bearer Token (auth:api)' : 'None',
                    'description' => 'Dynamic API endpoint mapped from api.php for ' . $route->uri(),
                    'headers' => ['Accept' => 'application/json'],
                    'requestBody' => $defaultBody,
                    'responseExample' => null,
                    'queryParams' => null,
                ];
            }
        }

        // Pass the array to your home.blade.php
        return view('home', compact('apisData'));
    }
}
