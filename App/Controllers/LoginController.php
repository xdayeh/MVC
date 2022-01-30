<?php

namespace AbuDayeh\Controllers;

use AbuDayeh\Core\Application;
use AbuDayeh\Core\Controller;
use AbuDayeh\Core\Request;
use AbuDayeh\Core\Response;
use AbuDayeh\Models\LoginModel;

class LoginController extends Controller
{
    public function login(Request $request, Response $response)
    {
        if (!Application::isGuest()){
            $response->redirect();
            return 0;
        }
        $this->setLayout('auth');
        $user = new LoginModel();
        if ($request->isPost()){
            $user->loadData($request->body());
            if ($user->validate() && $user->login() ){
                $response->redirect();
            }
        }
        return $this->render('login', [
            'model' => $user
        ]);
    }

    public function logout(Request $request, Response $response)
    {
        Application::$app->logout();
        $response->redirect();
    }
}