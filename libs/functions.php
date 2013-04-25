<?php

/**
 * Affiche le contenu de la variable préformatée
 * @param mixed $var Variable à afficher
 */
function debug($var) {
	if(!DEBUG) {
		return false;
	}
	echo '<pre class="well container-fluid debug">';
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
	array_multisort($req);

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
		// uniquement si des paramètres sont définis...
		if(!empty($req['params'])) {
			$tmp[] = 'params=' . implode(PARAMS_DELIMITER, $req['params']);
		}
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

	$url = ((empty($tmp)) ? '' : '?' . implode('&', $tmp));
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
 * Vérifie si le lien conduit vers la page/action actuelle
 * @param string $url Url à vérifier
 * @param bool $strict Prend en compte la vue (pas uniquement l'action)
 *
 * @return boolean
 */
function is_active($url, $strict = false) {
	global $req;

	if(preg_match('/.*?action=' . $req['action'] . '.*/i', $url) && !$strict) {
		return true;
	} else {
		if($url == url($req)) {
			return true;
		}
	}

	return false;
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
 * (en mode debug, génère un warning et empêche la redirection)
 * @param boolean $connected Si vrai, renvoie vers la page d'accueil,
 *							 Si faux, renvoie vers la page de connexion
 */
function kick($connected = false) {
	if(is_connected() == $connected) {
		if(DEBUG) {
			session_set_flash('DEBUG : Redirection empêchée (pb de connexion)', 'warning');
			return;
		}

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

/**
 * Vérifie si l'utilisateur est connecté
 * @return boolean L'utilisateur est connecté ou pas ?
 */
function is_connected() {
	return !empty($_SESSION['user']);
}

/**
 * KKKKKKKAAAAABBBOUUUUMMMMM
 * DANS LES TÉNÈBRES !!!!!!!
 */
function boum() {
	$nyan = array(
		"WWWWWWWWWW@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@              ",
	    "WWWWWWWW@@::::::::::::::::::::::::::::::::::::::::@@            ",
	    "WWWWWW@@::::::++++++++++++++++++++++++++++++++::::::@@          ",
	    "******@@::::++++++++++++++++WW++++++WW++++++++++::::@@          ",
	    "******@@::++WW++++++++++++++++++++++++++++++++++++::@@          ",
	    "````@@@@::++++++++++++++++++++++++++@@@@++++++WW++::@@  @@@@    ",
	    "``@@@@@@::++++++++++++++++++++++++@@####@@++++++++::@@@@####@@  ",
	    "``@@##@@::++++++++++++++++WW++++++@@######@@++++++::@@######@@  ",
	    "@@####@@::++++++WW++++++++++++++++@@########@@@@@@@@########@@  ",
	    "@@####@@@@++++++++++++++++++++++++@@########################@@  ",
	    "@@########@@@@++++++++++++++++WW@@############################@@",
	    "++@@##########@@++++++++++++++++@@######``@@##########``@@####@@",
	    "++++@@@@######@@++++++++++++++++@@######@@@@######@@##@@@@####@@",
	    "WWWWWW@@@@@@@@@@++++++WW++++++++@@##++++##################++++@@",
	    "WWWWWW@@::::WW++++++++++++++++++@@##++++##@@####@@####@@##++++@@",
	    "WW@@@@@@::::::++++++++++++++++++++@@######@@@@@@@@@@@@@@####@@  ",
	    "@@@@@@@@@@::::::::::::::::::::::::::@@####################@@    ",
	    "@@####@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@      ",
	    "@@@@@@  @@####@@                    @@####@@  @@####@@          ",
	    "          @@@@@@                      @@@@@@    @@@@@@          "
	);

	echo '<pre style="background-color: #fdc; color: #44d; font-weight; bolder;">';
	foreach ($nyan as $v) {
		echo '<span>' . $v . "</span>\n";
	}
	echo "</pre>";
	?>
	<script>
	jQuery(function($) {
		function move() {
			$('pre span').each(function(k, v)
				{ $(v).prepend(' '); });
			if($('pre').width() >= $('pre span').width() + 15)
				{ setTimeout(move, 110); }
		}
		move();
	})
	</script>
	<?php
}
