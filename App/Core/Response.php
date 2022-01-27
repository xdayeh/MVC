<?php

namespace AbuDayeh\Core;

class Response
{
    public function setStatusCode(int $code)
    {
        http_response_code($code);
    }

    public function redirect($url = DS)
    {
        header('Location: '.$url);
    }
}