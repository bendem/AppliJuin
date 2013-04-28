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
 * Génère le code html de la topbar
 * @return string Code de la topbar
 */
function nav_top() {
	$brand = array(url() => 'Appli Juin');

	global $req;

	$add = array(
		'unit',
		'depot',
		'product'
	);

	$nav = array();

	// Contient partie principale de la navigation
	if(in_array($req['action'], $add) && is_connected()) {
		$nav = array(
			url(array(
				'action' => $req['action'],
				'view'	 => 'add'
			)) => 'ajouter'
		);
	}

	// Contient le menu de droite
	if(is_connected()) {
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
	} else {
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
	}

	ob_start();
	require TEMPLATES_DIR . DS . 'nav_top.php';
	$html = ob_get_clean();
	return $html;
}

/**
 * Génère le code html de la sidebar
 * @return string Code html de la sidebar
 */
function nav_sidebar() {
	// Contient partie principale de la navigation
	$nav = array(
		url() => 'Accueil',
		url(array(
			'action' => 'unit'
		)) => 'unités de fabrication',
		url(array(
			'action' => 'depot'
		)) => 'dépôts',
		url(array(
			'action' => 'product'
		)) => 'produits',
		url(array(
			'action' => 'command'
		)) => 'commandes'
	);

	if(is_connected()) {
		$navAccount = array(
			url(array(
				'action' => 'user',
			)) => 'profil',
			url(array(
				'action' => 'user',
				'view' => 'disconnect'
			)) => 'déconnexion'
		);
	} else {
		$navAccount = array(
			url(array(
				'action' => 'user',
				'view' => 'login'
			)) => 'connexion',
			url(array(
				'action' => 'user',
				'view' => 'register'
			)) => 'inscription'
		);
	}

	ob_start();
	require TEMPLATES_DIR . DS . 'nav_sidebar.php';
	$html = ob_get_clean();
	return $html;
}
