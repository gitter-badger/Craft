<?php

namespace Craft\App\Layer;

use Craft\Error\NotFound;
use Craft\App\Layer;
use Craft\App\Request;
use Craft\Map\Router;
use Craft\Map\RouterInterface;

class Routing extends Layer
{

    /** @var RouterInterface */
    protected $router;


    /**
     * Init with routes or router
     * @param $routes
     */
    public function __construct($routes)
    {
        $this->router = ($routes instanceof RouterInterface)
            ? $routes
            : new Router($routes);
    }


    /**
     * Handle request
     * @param Request $request
     * @throws \Craft\Error\NotFound
     * @return Request
     */
    public function before(Request $request)
    {
        // route query
        $route = $this->router->find($request->query);

        // 404
        if(!$route) {
            throw new NotFound('Route "' . $request->query . '" not found.');
        }

        // update request
        $request->action = $route->to;
        $request->args = $route->data;
        $request->meta = array_merge($request->meta, $route->meta);
        $request->stamp('routed');

        return $request;
    }

}