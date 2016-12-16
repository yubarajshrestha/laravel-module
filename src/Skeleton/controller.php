<?php

namespace YModules\Test\Controllers;

use Illuminate\Routing\Controller;

use YModules\Test\Models\Test;

class TestController extends Controller {

	public function index() {
		return view('test::index');
	}

}
