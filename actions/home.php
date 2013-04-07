<?php

/**
 * Actions correspondant à la page d'accueil
 */

/**
 * Vue de l'avancement du travail
 *
 * @return array Tableau de progression + avancement global
 */
function index() {
	$progress = array(
		'Design'       => 97,
		'MVC'          => 100,
		'BDD'          => 60,
		'Formulaires'  => 20,
		'Utilisateurs' => 2,
		'Erreurs'      => 0.5
	);

	$glob = 0;
	foreach ($progress as $v) {
		$glob += $v;
	}

	return array('progress' => $progress, 'glob' => array_sum($progress) / count($progress));
}
