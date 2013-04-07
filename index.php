<?php

$time_start = microtime(true);

/**
 * Const definitions
 */
define('DS', DIRECTORY_SEPARATOR);
define('ROOT', substr(dirname(__FILE__), 0, strpos(__FILE__, 'index.php')));
define('URL_ROOT', str_replace('/index.php', '', $_SERVER['SCRIPT_NAME']));
define('LIBS_DIR', ROOT . DS . 'libs');
define('ACTIONS_DIR', ROOT . DS . 'actions');
define('VIEWS_DIR', ROOT . DS . 'views');
define('LAYOUTS_DIR', ROOT . DS . 'layouts');
define('TEMPLATES_DIR', ROOT . DS . 'templates');
define('WEBROOT_DIR', URL_ROOT . '/webroot');
define('PARAMS_DELIMITER', '-');
define('INDEX_ACTION', 'home');
define('DEBUG', true);
define('LOCAL', (DS == '\\'));

/* Récupération de la vue à charger, de l'action a effectuer et des paramètres */
$req['view'] = (isset($_GET['view'])) ? $_GET['view'] : 'index';
$req['action'] = (isset($_GET['action'])) ? $_GET['action'] : INDEX_ACTION;
$req['params'] = array();
if(isset($_GET['params'])) {
	foreach (explode(PARAMS_DELIMITER, $_GET['params']) as $v) {
		$req['params'][] = $v;
	}
}

if(!$req['action'] && !empty($req['params'])) {
	die("Pas de paramètres si pas d'action !");
}

/* inclusions des librairies */
require LIBS_DIR . DS . 'includes.php';

session_init();

/* Possibilité de changer le layout utilisé en redéfinissant le layout depuis une action */
$chosen_layout = 'default';

/* Lancement de l'action */
if($req['action']) {
	if(is_file(ACTIONS_DIR . DS . $req['action'] . '.php')) {
		require ACTIONS_DIR . DS . $req['action'] . '.php';
		if(function_exists($req['view'])) {
			/* Les variables renvoyées sous forme de tableau par une action seront disponible pour la vue */
			$var_for_layout = call_user_func($req['view'], $req['params']);
		}
	} else {
		die('Action inconnue !');
	}
	if(isset($var_for_layout)) {
		extract($var_for_layout);
	}
}

/* Gestion de la vue */
ob_start();
if(is_file(VIEWS_DIR . DS . $req['action'] . DS . $req['view'] . '.php')) {
	require VIEWS_DIR . DS . $req['action'] . DS . $req['view'] . '.php';
} else {
	header('HTTP/1.1 404 Not Found');
	require VIEWS_DIR . DS . 'errors' . DS . '404.php';
}
$content_for_layout = ob_get_clean();

/* Chargement du layout */
require LAYOUTS_DIR . DS . $chosen_layout . '.php';

$req_time = (LOCAL) ? $_SERVER['REQUEST_TIME_FLOAT'] : $_SERVER['REQUEST_TIME'];
$time_end = microtime(true);
$time_total = $time_end - $req_time;
$time_exec = $time_end - $time_start;
$time_request = $time_total - $time_exec;

if(LOCAL) {
	$time = round($time_request, 6) . "s de latence serveur\n";
} else {
	$time = '';
}
$time .= round($time_exec, 6) . "s d'exécution du script\n";
if(LOCAL) {
	$time .= round($time_total, 6) . "s de chargement total\n";
}
debug($time);
