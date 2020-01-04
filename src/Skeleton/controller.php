<?php

namespace Modules\Test\Controllers;

use Illuminate\Routing\Controller;

class controller extends Controller
{
    public function index()
    {
        return view('test::index');
    }
}
