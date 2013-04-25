<?php

/**
 * Démarage de la session et initialisation des valeurs nécessaires
 */
function session_init() {
	if(!isset($_SESSION)) {
		session_start();
	}

	if(!isset($_SESSION['user'])) {
		$_SESSION['user'] = array();
	}

	if(!isset($_SESSION['flash'])) {
		$_SESSION['flash'] = array();
	}
}

/**
 * Authentifie l'utilisateur
 * @param array $user Tableau d'information de l'utilisateur
 */
function session_auth($user) {
	session_write($user, 'user');
}

/**
 * Ajoute une valeur à la session
 * @param mixed $var Valeur à stocker
 * @param string $k Clé de la valeur
 */
function session_write($var, $k) {
	$_SESSION[$k] = $var;
}

/**
 * Lis une valeur de la session
 * @param string $k Clé de la valeur
 * @param mixed Valeur de la session ou retourne false si inexistante
 */
function session_read($k) {
	if(isset($_SESSION[$k])) {
		return $_SESSION[$k];
	} else {
		return false;
	}
}

/**
 * Ajoute une notification à la session
 * @param string $msg Contenu du message
 * @param string $type Type de notification ([success] | warning | error | info)
 */
function session_set_flash($msg, $type = 'success') {
	$flash = session_read('flash');
	$flash[] = array('msg' => $msg, 'type' => $type);
	session_write($flash, 'flash');
}

/**
 * Affiche les notifications contenues dans la session
 * @return string Code html
 */
function session_flash() {
	$html = '';
	foreach (session_read('flash') as $v) {
		$html .= '<div class="alert alert-' . $v['type'] . '">' . $v['msg'] . '<a href="#" class="close" data-dismiss="alert">&times;</a></div>';
	}

	session_write(array(), 'flash');

	return $html;
}
