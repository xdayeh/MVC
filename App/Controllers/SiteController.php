<?php

namespace AbuDayeh\Controllers;

use AbuDayeh\Core\Controller;

class SiteController extends Controller
{
    public function home()
    {
        return $this->render('home');
    }
}