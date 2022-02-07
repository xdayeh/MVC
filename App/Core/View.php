<?php

namespace AbuDayeh\Core;

class View
{
    protected function renderOnlyView($view, $params = [])
    {
        foreach ($params as $key => $value){
            $$key = $value;
        }
        ob_start();
        include_once Application::$ROOT_DIR.'Views'.DS."$view.php";
        return ob_get_clean();
    }

    protected function layoutContent()
    {
        $layout = Application::$app->layout;
        if (Application::$app->controller){
            $layout =  Application::$app->controller->layout;
        }
        ob_start();
        include_once 'Template'.DS.'Header.php';
        include_once Application::$ROOT_DIR.'Views'.DS.'Layouts'.DS."$layout.php";
        include_once 'Template'.DS.'Footer.php';
        return ob_get_clean();
    }

    public function renderView($view, $params = [])
    {
        $viewContent    = $this->renderOnlyView($view, $params);
        $layoutContent  = $this->layoutContent();
        return str_replace('{{content}}', $viewContent, $layoutContent);
    }
}