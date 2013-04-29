<?php

/**
 * Actions correspondant à la page d'accueil
 */

function index() {
	mysql_auto_connect();

	$q = array(
		'commands' => 'SELECT commande.num, commande.dateCommande, unite_fabrication.nom as nom_unite, depot.nom as nom_depot
			FROM commande
			INNER JOIN unite_fabrication ON(commande.numUnite = unite_fabrication.num)
			INNER JOIN depot ON (commande.numDepot = depot.num)
			ORDER BY dateCommande DESC LIMIT 0,3',
		'products' => 'SELECT num, nom FROM produit ORDER BY num DESC LIMIT 0,3',
		'depots' => 'SELECT num, nom, ville FROM depot ORDER BY num DESC LIMIT 0,3',
		'units' => 'SELECT num, nom, ville FROM unite_fabrication ORDER BY num DESC LIMIT 0,3'
	);

	foreach ($q as $k => $v) {
		$r[$k] = mysql_fetch_all(mysql_query($v));
	}

	//var_dump($r);

	return $r;
}
