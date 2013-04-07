<?php

/**
 * Affiche le contenu de la variable préformatée
 * @param mixed $var Variable à afficher
 */
function debug($var) {
	if(!DEBUG) {
		return false;
	}
	echo '<pre class="well container debug">';
	ob_start();
	print_r($var);
	echo htmlentities(ob_get_clean(), ENT_QUOTES, 'utf-8');
	echo '</pre>';
}

/**
 * Génère une url à partir d'un tableau de requête
 * @param array $req Tableau
 *
 * @return string Url générée
 */
function url(array $req = array()) {
	if($req == array()) {
		return URL_ROOT . '/';
	}

	/* Rejette les requêtes avec paramètre mais sans action */
	if(!isset($req['action'])) {
		$req['action'] = INDEX_ACTION;
	}
	if(!isset($req['view'])) {
		$req['view'] = 'index';
	}

	$tmp = array();

	/* formatage des paramètres */
	if(isset($req['params'])) {
		if(!is_array($req['params'])) {
			return false;
		}
		$tmp[] = 'params=' . implode(PARAMS_DELIMITER, $req['params']);
	}
	unset($req['params']);

	if($req['action'] == INDEX_ACTION) {
		unset($req['action']);
	}
	if($req['view'] == 'index') {
		unset($req['view']);
	}

	foreach ($req as $k => $v) {
		$tmp[] = $k . '=' . $v;
	}

	$url = /*'index.php' . */((empty($tmp)) ? '' : '?' . implode('&', $tmp));
	return URL_ROOT . '/' . $url;
}

/**
 * Renvoie l'adresse d'un fichier de la racine web
 * @param string $url Fichier
 *
 * @return string Url du fichier
 */
function webroot($url) {
	return WEBROOT_DIR . '/' . trim($url, '/');
}

/**
 * Vérifie si le lien conduit vers la page actuelle
 * @param string $url Url à vérifier
 *
 * @return boolean
 */
function is_active($url) {
	global $req;

	return (trim(str_replace('index.php', '', url($req)), '/') == trim(str_replace('index.php', '', $url), '/'));
}

/**
 *
 */
function db_connect(array $config = array()) {
	$default_config = array(
		'host' => 'eve',
		'user' => 'demartbe',
		'pwd'  => 'demartbe',
		'db_name' => 'demartbe'
	);

	if(LOCAL || !empty($config)) {
		$config = array(
			'host' => 'localhost',
			'user' => 'root',
			'pwd'  => ''
		);
	}

	$config = array_merge($default_config, $config);

	$link = mysql_connect($config['host'], $config['user'], $config['pwd'])
		or die("Impossible de se connecter : " . mysql_error());
	mysql_select_db($config['db_name'], $link)
		or die('Base de donnée dans les ténèbres !');
	mysql_set_charset('utf8')
		or die('Utf-8 non supporté : F*** OFF !!!!!!!!');
	return $link;
}

/**
 * Redirige vers la page en paramètre
 * @param string $url Url de redirection
 * @param int $code Code http de redirection
 */
function redirect($url, $code = null) {
	switch ($code) {
		case 301:
			header('HTTP/1.0 301 Moved Permanently');
			break;
		case 403:
			header('HTTP/1.0 403 Forbidden');
			break;
		case 404:
			header('HTTP/1.0 404 Not Found');
			break;
	}
	header('Location: ' . $url);
	exit();
}

/**
 * Rejette les utilisateurs de la page courante
 * @param boolean $connected Si vrai, renvoie vers la page d'accueil,
 *							 Si faux, renvoie vers la page de connexion
 */
function kick($connected = false) {
	if(session_read('user') == $connected) {
		if($connected) {
			$text = "Vous êtes déjà connecté !";
			$url = url();
		} else {
			$text = "Connectez-vous d'abord !";
			$url = url(array(
				'view' => 'login',
				'action' => 'user'
			));
		}
		session_set_flash($text, 'error');
		redirect($url);
	}
}
