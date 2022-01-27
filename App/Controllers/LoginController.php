<?php

namespace AbuDayeh\Controllers;

use AbuDayeh\Core\Request;
use AbuDayeh\Core\Response;
use AbuDayeh\Core\Application;
use AbuDayeh\Models\LoginModel;

class LoginController extends Controller
{
    public function login(Request $request, Response $response)
    {
        $user = new LoginModel();
        if ($request->isPost()){
            $user->loadData($request->body());
            if ($user->validate() && $user->login() ){
                $response->redirect();
                return true;
            }
        }

        $this->setLayout('auth');

        return $this->render('login', [
            'model' => $user
        ]);
    }
}