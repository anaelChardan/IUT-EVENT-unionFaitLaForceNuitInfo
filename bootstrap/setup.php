<?php

session_start();

require_once APP_ROOT.'/libs/twig/lib/Twig/Autoloader.php';
Twig_Autoloader::register(true);

$loader = new Twig_Loader_Filesystem(APP_ROOT.'/App/Views');
$twig = new Twig_Environment($loader, array(
    'cache' => false,
));

$twig->addFunction(new Twig_SimpleFunction('asset', function ($path) {
    return 'public/'.$path;
}));

$twig->addFunction(new Twig_SimpleFunction('path', function ($ctl, $action, $params=[]) {
    $path = "?".CONTROLLER_ACCESSOR.'='.$ctl.'&'.ACTION_ACCESSOR.'='.$action;
	foreach ($params as $key => $val)
		$path .= '&'.$key.'='.$val;
	return $path;
}));

$twig->addFunction(new Twig_SimpleFunction('app', function () {
   	global $app;
	return $app;
}));

$twig->addFilter(new Twig_SimpleFilter('dump', function ($var) {
    return var_dump($var);
}));
