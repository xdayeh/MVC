<?php

namespace AbuDayeh\Core;

abstract class Controller
{
    public string $layout = 'main';

    public function setLayout($layout = 'auth')
    {
        $this->layout = $layout;
    }

    public function render($view, $params = [])
    {
        return Application::$app->view->renderView($view, $params);
    }
}