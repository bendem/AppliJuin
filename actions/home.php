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
		'unit add'          => 100,
		'unit view'         => 100,
		'unit edit'         => 100,
		'unit delete'       => 1,
		'depot add'         => 100,
		'depot view'        => 100,
		'depot edit'        => 100,
		'depot delete'      => 1,
		'product add'       => 0,
		'product view'      => 0,
		'product edit'      => 0,
		'product delete'    => 0,
		'command'			=> 0,
		'users'      		=> 100,
		'errors'           	=> 15
	);

	return array('progress' => $progress, 'glob' => array_sum($progress) / count($progress));
}
