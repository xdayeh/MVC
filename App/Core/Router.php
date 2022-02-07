<?php

namespace AbuDayeh\Core;

class Router
{
    public Request $request;
    public Response $response;
    protected array $routes = [];

    public function __construct(Request $request, Response $response)
    {
        $this->request = $request;
        $this->response = $response;
    }

    public function resolve()
    {
        $path       = $this->request->path();
        $method     = $this->request->method();
        $callback   = $this->routes[$method][$path] ?? false;

        if (!$callback){
            throw new \Exception("Page Not Found", 404);
        }
        /**
        if (is_string($callback)){
            return Application::$app->controller->renderView($callback);
        }
        **/
        if (is_array($callback)){
            $controller = new $callback[0]();
            Application::$app->controller = $controller;
            $controller->action = $callback[1];
            $callback[0] = $controller;
            /**
            foreach ($controller->getMiddlewares() as $middleware){
                $middleware->execute();
            }
             */
        }

        return call_user_func($callback, $this->request, $this->response);
    }

    public function get($path, $callback)
    {
        $this->routes['get'][$path] = $callback;
    }

    public function post($path, $callback)
    {
        $this->routes['post'][$path] = $callback;
    }
}