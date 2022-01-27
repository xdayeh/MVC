<?php

namespace AbuDayeh\Core;

class AutoLoader
{
    public static function AutoLoad($className)
    {
        $className = str_replace('AbuDayeh', '', $className);
        $className = str_replace('\\', DS, $className);
        $className = strtolower($className . '.php');
        if (file_exists(APP_PATH . $className)){
            require APP_PATH . $className;
        }
    }
}
spl_autoload_register(__NAMESPACE__ . '\AutoLoader::AutoLoad');