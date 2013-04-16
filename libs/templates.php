<?php

/**
 * Affiche la breadcrumb du site
 * @param array $req Tableau de requête de la page actuelle
 *
 * @return string Code html de la breadcrumb
 */
function breadcrumb(array $req) {
	$html = '';
	ob_start();
	require TEMPLATES_DIR . DS . 'breadcrumb.php';
	$html = ob_get_clean();
	return $html;
}

/**
 * Retourne la partie navigation du site
 *
 * @return string Code de la navigation
 */
function nav_top() {
	$brand = array(url() => 'Appli Juin');

	global $req;

	$add = array(
		'unit',
		'depot'
	);

	$nav = array();

	// Contient partie principale de la navigation
	if(in_array($req['action'], $add)) {
		$nav = array(
			url(array(
				'action' => $req['action'],
				'view'	 => 'add'
			)) => 'ajouter'
		);

	}

	// Contient le menu de droite
	if(!session_read('user')) {
		$right_text = 'compte';
		$right = array(
			url(array(
				'view'   => 'register',
				'action' => 'user'
			)) => 'inscription',
			url(array(
				'view'   => 'login',
				'action' => 'user'
			)) => 'connexion'
		);
	} else {
		$right_text = session_read('user')['login'];
		$right = array(
			url(array(
				'action' => 'user'
			)) => 'profil',
			'' => 'divider',
			url(array(
				'view'   => 'disconnect',
				'action' => 'user'
			)) => 'déconnexion'
		);
	}

	ob_start();
	require TEMPLATES_DIR . DS . 'nav_top.php';
	$html = ob_get_clean();
	return $html;
}


function nav_sidebar() {
	// Contient partie principale de la navigation
	$nav = array(
		url() => 'Accueil',
		url(array(
			'action' => 'unit'
		)) => 'unités de fabrication',
		url(array(
			'action' => 'depot'
		)) => 'dépôts'
	);

	ob_start();
	require TEMPLATES_DIR . DS . 'nav_sidebar.php';
	$html = ob_get_clean();
	return $html;
}
