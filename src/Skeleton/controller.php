<?php

namespace Modules\Test\Controllers;

use Illuminate\Routing\Controller;

use Modules\Test\Models\Test;

class TestController extends Controller {

	public function index() {
		return view('test::index');
	}

}
