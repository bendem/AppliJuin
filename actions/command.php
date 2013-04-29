<?php

function index() {
	mysql_auto_connect();

	$q = 'SELECT commande.*, unite_fabrication.nom as nom_unite, depot.nom as nom_depot
		FROM commande
		INNER JOIN unite_fabrication ON(commande.numUnite = unite_fabrication.num)
		INNER JOIN depot ON (commande.numDepot = depot.num)
		ORDER BY dateCommande DESC';
	$r = mysql_query($q);
	$data = mysql_fetch_all($r);

	return array(
		'data' => $data,
		'del_confirm' => htmlentities('Êtes-vous sûr ? <a href="' . url(array(
			'action' => 'command',
			'view' => 'del',
			'params' => array('%s', '%s')
		)) . '" class="del btn btn-warning">Oui</a>')
	);
}

function add(array $params = null) {
	mysql_auto_connect();

	$numUnite = false;
	$numDepot = false;
	$numeric = array(0, 2, 3, 5);
	$size = array(0, 3, 6);
	if(!in_array(sizeof($params), $size)) {
		var_dump(sizeof($params));
		die("Erreur d'adresse (mauvais nombre de paramètres)");
	} else {
		foreach ($numeric as $v) {
			if(isset($params[$v]) && !is_numeric($params[$v])) {
				die("Erreur d'adresse (paramètres numériques demandé)");
			}
		}
	}

	if($params) {
		if($params[0] == 1) {
			$numUnite = $params[2];
			if(sizeof($params) == 6) {
				$numDepot = $params[5];
			}
		} else {
			$numDepot = $params[2];
			if(sizeof($params) == 6) {
				$numDepot = $params[5];
			}
		}
	}

	$r = mysql_query(sql_select('num, nom, cp', 'unite_fabrication'));
	$units = array();
	while ($d = mysql_fetch_assoc($r)) {
		$units[$d['num']] = $d['nom'] . ' - ' . $d['cp'];
	}
	$r = mysql_query(sql_select('num, nom, cp', 'depot'));
	$depots = array();
	while ($d = mysql_fetch_assoc($r)) {
		$depots[$d['num']] = $d['nom'] . ' - ' . $d['cp'];
	}

	$champs = array(
		'numUnite' => array(
			'label' => 'Unité de fabrication',
			'type' => 'select',
			'values' => $units,
			'value' => (int) $numUnite
		),
		'numDepot' => array(
			'label' => 'Dépôt',
			'type' => 'select',
			'values' => $depots,
			'value' => (int) $numDepot
		)
	);

	return array(
		'champs' => $champs
	);
}
