<?php

namespace AbuDayeh\Controllers;

use AbuDayeh\Core\Controller;

class DashController extends Controller
{
    public function dashboard()
    {
        return $this->render('dashboard');
    }

    public function profile()
    {
        return $this->render('profile');
    }
}