<?php

namespace AbuDayeh\Core;

use Exception;

class Application
{
    public static string $ROOT_DIR;
    public static Application $app;
    public string $layout = 'main';
    public string $userClass;
    public Request $request;
    public Response $response;
    public Sessions $sessions;
    public Router $router;
    public ?Controller $controller = null;
    public Database $db;
    public ?Model $user;
    public View $view;

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
        $this->userClass    = $config['userClass'];
        $primaryValue       = $this->sessions->get('user');
        if ($primaryValue) {
            $primaryKey = $this->userClass::primaryKey();
            $this->user = $this->userClass::findOne([$primaryKey => $primaryValue]);
        }else{
            $this->user = null;
        }
    }

    public function run()
    {
        try {
            echo $this->router->resolve();
        }catch (Exception $e){
            $this->response->setStatusCode($e->getCode());
            echo $this->view->renderView('_error', [
                'exception' => $e
            ]);
        }
    }

    public static function isGuest(): bool
    {
        return !self::$app->user;
    }

    public function login(Model $user): bool
    {
        $this->user = $user;
        $primaryKey = $user->primaryKey();
        $primaryValue = $user->{$primaryKey};
        $this->sessions->set('user', $primaryValue);
        return true;
    }

    public function logout()
    {
        $this->user = null;
        $this->sessions->remove('user');
    }
}