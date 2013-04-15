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
		'Design'            => 100,
		'MVC'               => 100,
		'MRD'               => 100,
		'BDD'               => 100,
		'unit view'         => 40,
		'unit edit'         => 0,
		'unit delete'       => 0,
		'depot view'        => 40,
		'depot edit'        => 0,
		'depot delete'      => 0,
		'product view'      => 0,
		'product edit'      => 0,
		'product delete'    => 0,
		'command'			=> 0,
		'users'      		=> 100,
		'errors'           	=> 3
	);

	return array('progress' => $progress, 'glob' => array_sum($progress) / count($progress));
}
