<?php
include 'vendor/autoload.php';

class Template {
	private $_scriptPath="templates/";
	public $properties;

	public function setScriptPath($scriptPath) {
		$this->_scriptPath=$scriptPath;
	}

	public function __construct() {
		$this->properties = array();
	}

	public function render($filename) {
		ob_start();
		if(file_exists($this->_scriptPath.$filename))
			include($this->_scriptPath.$filename);
		return ob_get_clean();
	}

	public function __set($k, $v) {
		$this->properties[$k] = $v;
	}

	public function __get($k) {
		return $this->properties[$k];
	}
}

function expandDirectories($base_dir) {
      $directories = array();
      foreach(scandir($base_dir) as $file) {
            if($file == '.' || $file == '..') continue;
            $dir = $base_dir.DIRECTORY_SEPARATOR.$file;
            if(is_dir($dir)) {
                $directories []= $dir;
                $directories = array_merge($directories, expandDirectories($dir));
            }
      }
      return $directories;
}

function getPath($name, $param, $filetypes, $datadir) {
	$Parsedown = new Parsedown();
	$emptyParam = ltrim($param, "/");
	$emptyParam = str_replace($name."/", "", $emptyParam);
	if($param == "/".$name) $emptyParam = "";
	$path = $datadir.'/'.$emptyParam;
	$answer['body'] = null;
	if(file_exists($path.'/index.md')) $answer['body'] = $Parsedown->text(file_get_contents($path.'/index.md'));
	$dirs = array_filter(glob($path.'/*'), 'is_dir');
	$dirs = str_replace($path.'/', '', $dirs);
	$files = glob($path.'/*.{'.$filetypes.'}', GLOB_BRACE);
	$files = str_replace($path.'/', '', $files);
	$files = str_replace('jpg', 'pict', $files);
	$files = str_replace('png', 'pict', $files);
	$answer['dirs']	= $dirs;
	$answer['files'] = $files;
	$answer['directory'] = $emptyParam;
	if($answer['directory'] != "") $answer['directory'] = '/'.$emptyParam;
	$answer['back'] = dirname('/'.$name.$answer['directory']);
	$userPath = trim("furiku/".$emptyParam, "/");
	$answer['current_name'] = basename($userPath);
	$backline = "";
	$answer['backline'] = null;
	foreach(explode('/', $userPath) as $key =>$elem) {
		$backline .= "/".$elem;
		$answer['backline'][$key][0] = $elem;
		$answer['backline'][$key][1] = $backline;	
	}
	array_pop($answer['backline']);
	$answer['title'] = $emptyParam;

	return $answer;
}

function showPhoto($name, $path) {
	$Parsedown = new Parsedown();
	$raw_name = basename($path, '.pict');
	$path = str_replace('.pict', '.jpg', $path);
	$path = str_replace('/'.$name.'/', '', $path);
	$path = str_replace('//', '/', $path);
	if(!file_exists($path)) $path = str_replace('.jpg', '.png', $path);
	$photo = exif_read_data($path, 0, true);
	$answer['description'] = utf8_encode($photo['IFD0']['ImageDescription']);
	if(empty($answer['description'])) $answer['description'] = $photo['COMPUTED']['UserComment'];
	$answer['date'] = $photo['EXIF']['DateTimeOriginal'];
	if(empty($answer['date'])) $answer['date'] = "ＮＯ　ＤＡＴＡ";
	$answer['name'] = basename($path);
	$path = str_replace('/'.$answer['name'], '', $path);
	if(file_exists($path.'/'.$raw_name.'.md')) $answer['description'] = $Parsedown->text(file_get_contents($path.'/'.$raw_name.'.md'));
	$files = glob($path.'/*.{jpg,png}', GLOB_BRACE);
	$filename = $path.'/'.$answer['name'];
	$number = array_search($filename, $files);
	$answer['next'] = basename($files[$number+1]);
	if($number == count($files)-1) $answer['next'] = basename($files[0]);
	$answer['previous'] = basename($files[$number-1]);
	if($number == 0) $answer['previous'] = basename($files[count($files)-1]);
	$answer['filecount'] = count($files);
	$answer['next'] = str_replace('.jpg', '.pict', $answer['next']);
	$answer['previous'] = str_replace('.jpg', '.pict', $answer['previous']);
	$answer['next'] = str_replace('.png', '.pict', $answer['next']);
	$answer['previous'] = str_replace('.png', '.pict', $answer['previous']);
	$answer['number'] = $number;
	$answer['files'] = count($files);
	$answer['path'] = $path; 

	return $answer;
}

$params = $_SERVER["REQUEST_URI"];

if(strpos($params, 'furiku')) {
	if(strpos($params, '.pict')) {
		$photo = showPhoto('furiku','content/photos/'.$params);
		$view = new Template();
		$view->photo = $photo;
		$view->percentage = ($photo['number']+1)/$photo['files'] * 100;
		$view->directory = str_replace('content/photos/', '', $photo['path']);
		echo $view->render('photo.html');
	} else {
		$path = getPath('furiku',$params,'jpg,png','content/photos');
		$view = new Template();
		$view->body = $path['body'];
		$view->back = $path['back'];
		$view->dirs = $path['dirs'];
		$view->files = $path['files'];
		$view->directory = $path['directory'];
		$view->backline = $path['backline'];
		$view->current_name = $path['current_name'];
		echo $view->render('furiku.html');
	}
} else {
	if(strpos($params, '.pict')) {
		$photo = showPhoto('blank','content/other/'.$params);
		$view = new Template();
		$view->photo = $photo;
		$view->directory = str_replace('content/other/', '', $photo['path']);
		echo $view->render('picture.html');
	} else {
		$path = getPath('',$params,'jpg,png','content/other');
		$view = new Template();
		$view->body = $path['body'];
		$view->back = $path['back'];
		$view->dirs = $path['dirs'];
		$view->files = $path['files'];
		$view->directory = $path['directory'];
		$view->backline = $path['backline'];
		$view->current_name = $path['current_name'];
		$view->title = $path['title'];
		echo $view->render('other.html');
	}
}
