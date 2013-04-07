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
function nav() {
	$brand = array(url() => 'Appli Juin');

	// Contient partie principale de la navigation
	$nav = array(
		//url() => 'home',
		//url(array(
		//	'view' => 'test'
		//)) => 'test',
		url(array(
			'action' => 'unit'
		)) => 'unités de fabrication',
		url(array(
			'action' => 'depot'
		)) => 'dépôts'
	);

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
	require TEMPLATES_DIR . DS . 'nav.php';
	$html = ob_get_clean();
	return $html;
}
