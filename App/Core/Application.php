<?php

namespace AbuDayeh\Core;

use AbuDayeh\Controllers\Controller;

class Application
{
    public static string $ROOT_DIR;
    public static Application $app;
    public Request $request;
    public Response $response;
    public Sessions $sessions;
    public Router $router;
    public View $view;
    public string $layout = 'main';
    public ?Controller $controller = null;
    public Database $db;

    public function __construct($rootPath, array $config)
    {
        self::$ROOT_DIR     = $rootPath;
        self::$app          = $this;
        $this->request      = new Request();
        $this->response     = new Response();
        $this->sessions     = new Sessions();
        $this->router       = new Router($this->request, $this->response);
        $this->view         = new View();
        $this->db           = new Database($config['db']);
    }

    public function run()
    {
        try {
            echo $this->router->resolve();
        }catch (\Exception $e){
            $this->response->setStatusCode($e->getCode());
            echo $this->view->renderView('_error', [
                'exception' => $e
            ]);
        }
    }
}