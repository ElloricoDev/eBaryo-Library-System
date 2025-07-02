<?php

namespace App\Http\Controllers\UserControllers;

use App\Http\Controllers\Controller;

class HomeController extends Controller
{
    public function index()
    {
        return inertia('User/Home');
    }
}
