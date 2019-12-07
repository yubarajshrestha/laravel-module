<?php

namespace YubarajShrestha\YM\Controllers;

use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Illuminate\Support\Str;
use File;
use YubarajShrestha\YM\Http\Modularize;

class YMController extends Controller
{
	private $moduleRoot = "../modules/";
	private $controller = "../Skeleton/controller.php";
	private $model = "../Skeleton/model.php";
	private $view = "../Skeleton/view.php";
	private $modules = [];
	private $module = null;

	public function index(Modularize $module) {
		// if(File::exists(__DIR__.'/'.$this->controller)) {
		// 	dd('yes');
		// } else {
		// 	dd('abc');
		// }
		// File::put($dirPath.'./routes.php', $string);
		$modules = $module::all();
		return view('ym::index', compact('modules'));
	}

	public function make(Request $request) {
		$raw_modules = $request->get('modules');
		$model = $this->getParts($raw_modules);
		foreach($model as $m) {
			$this->insertModule($m, new Modularize);
		}
		if(count($this->modules) > 0):
			foreach($this->modules as $module) {
				$this->makeModule($module);
			}
			$this->resetModule(new Modularize);
		endif;
		return back();
	}

	private final function resetModule($m) {
		$model = File::get(str_replace(basename(__DIR__), 'Skeleton/module.php', __DIR__));
		$local_modules = [];
		$data = $m::get()->pluck('slug');
		foreach($data as $d) {
			array_push($local_modules, $d);
		}
		$count = count($local_modules);
		$string = explode(".", $model);
		$string[0] .= "\n";
		$string[1] = "    " . $string[1];
		for($i = 0; $i < $count; $i++) {
			$item = $local_modules[$i];
			if($i != $count-1) {
				$string[0] .= '        \''. trim($item) . "',\n";
			} else {
				$string[0] .= '        \''. trim($item) . "'\n";
			}
		}
		$string[0] .= $string[1];
		File::put('../config/module.php', $string[0]);
	}

	private function insertModule($m, $module) {
		$break_apart = explode(' ', strtolower(trim($m)));
		$final_module = ucwords(strtolower($m));
		if(count($break_apart) > 1) {
			$final_module = ucfirst($break_apart[0]) . ucfirst($break_apart[1]);
		}
		$singular = $module->whereSlug(Str::singular($final_module))->get();
		$plural = $module->whereSlug(Str::plural($final_module))->get();
		if(count($singular) == count($plural) && count($singular) == 0) {
			array_push($this->modules, $final_module);
			$module->title = ucwords(strtolower($m));
			$module->slug = $final_module;
			$module->save();
		}
		return;
	}

	public function destroy($id) {
		$module = Modularize::findOrFail($id);
		$path = base_path() . '\YModules\\' . ucfirst(Str::singular($module->title));
		if(file_exists($path)) {
			$this->destroyer($path);
			$module->delete();
			$this->resetModule(new Modularize);
		}
		return back();
	}

	private final function getParts($raw_modules) {
		$data = explode(',', $raw_modules);
		return $data;
	}

	private final function fileWriter($path, $str) {
		$string = str_replace("Test", $this->module, $str);
		$string = str_replace("test", strtolower($this->module), $string);
		File::put($path, $string);
		return;
	}

	private final function makeModule($module = null) {
		$success = false;
		$this->module = Str::singular($module);
		$dirPath = $this->moduleRoot . $this->module;
		if(!File::isDirectory($dirPath)) {
			if(File::makeDirectory($dirPath)) {
				File::makeDirectory($dirPath.'/Controllers');
				File::makeDirectory($dirPath.'/Models');
				File::makeDirectory($dirPath.'/Views');
				// $routes = File::get(__DIR__.'../../Skeleton/routes.php');
				$routes = File::get(str_replace(basename(__DIR__), 'Skeleton/routes.php', __DIR__));
				$string = str_replace("Test", $this->module, $routes);
				$string = str_replace("route_name", strtolower(Str::plural($this->module)), $string);
				File::put($dirPath.'/routes.php', $string);
				$success = true;
			}
		} else {
			if(!File::isDirectory($dirPath."/Controllers"))
				File::makeDirectory($dirPath."/Controllers");
			if(!File::isDirectory($dirPath."/Models"))
				File::makeDirectory($dirPath."/Models");
			if(!File::isDirectory($dirPath."/Views"))
				File::makeDirectory($dirPath."/Views");
			// $routes = File::get(__DIR__.'../../Skeleton/routes.php');
			$routes = File::get(str_replace(basename(__DIR__), 'Skeleton/routes.php', __DIR__));
			$string = str_replace("Test", $this->module, $routes);
			$string = str_replace("route_name", strtolower(Str::plural($this->module)), $string);
			File::put($dirPath.'/routes.php', $string);
			$success = true;
		}

		if($success) {
			$this->makeController();
			$this->makeModel();
			$this->makeView();
		} else {
			$str = "Unable to proceed. It seems that model already exists.";
			return view('modularize::error')->with('message', $str);
		}
		return;
	}

	private final function makeController() {
		$path = $this->moduleRoot . $this->module . '/Controllers/' . $this->module . 'Controller.php';
		if(File::exists(__DIR__.'/'.$this->controller)) {
			$string = File::get(str_replace(basename(__DIR__), 'Skeleton/controller.php', __DIR__));
			$this->fileWriter($path, $string);
		}
		return;
	}

	private final function makeModel() {
		$path = $this->moduleRoot . $this->module . '/Models/'. $this->module . '.php';
		if(File::exists(__DIR__.'/'.$this->model)) {
			$string = File::get(str_replace(basename(__DIR__), 'Skeleton/model.php', __DIR__));
			$this->fileWriter($path, $string);
		}
		return;
	}

	private final function makeView() {
		$path = $this->moduleRoot . $this->module . '/Views/index.blade.php';
		if(File::exists(__DIR__.'/'.$this->view)) {
			$string = File::get(str_replace(basename(__DIR__), 'Skeleton/view.php', __DIR__));
			$this->fileWriter($path, $string);
		}
		return;
	}

	private final function destroyer($dir) {
        if (!file_exists($dir)) { return true; }
        if (!is_dir($dir) || is_link($dir)) {
            return unlink($dir);
        }
        foreach (scandir($dir) as $item) {
            if ($item == '.' || $item == '..') { continue; }
            if (!$this->destroyer($dir . "/" . $item, false)) {
                if (!$this->destroyer($dir . "/" . $item, false)) return false;
            };
        }
        return rmdir($dir);
    }
}
