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
		'Design'       => 100,
		'MVC'          => 100,
		'BDD'          => 20,
		'Vues de la bdd' => 5,
		'Formulaires'  => 2,
		'Utilisateurs' => 100,
		'Erreurs'      => 0.5
	);

	arsort($progress);

	$glob = 0;
	foreach ($progress as $v) {
		$glob += $v;
	}

	return array('progress' => $progress, 'glob' => array_sum($progress) / count($progress));
}
