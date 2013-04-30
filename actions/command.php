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
			'params' => array('%s')
		)) . '" class="del btn btn-warning">Oui</a>')
	);
}

function add(array $params = null) {
	kick();
	mysql_auto_connect();

	// Paramètres de présélection d'unité/dépôt
	$numUnite = false;
	$numDepot = false;
	$numProduit = false;
	// Les paramètres vont par deux :
	// Les premiers pour dire ce que l'on défini,
	// le deuxième pour la valeur
	// Par exemple : Si $param[0] vaut 1, $param[1] est l'id d'une unité
	if(sizeof($params) % 2 != 0) {
		var_dump(sizeof($params));
		die("Erreur d'adresse (mauvais nombre de paramètres)");
	} else {
		for ($i=0; $i < sizeof($params); $i += 2) {
			if($params[$i] == 1) {
				$numUnite = $params[$i+1];
			} elseif($params[$i] == 2) {
				$numDepot = $params[$i+1];
			} elseif($params[$i] == 3) {
				$numProduit = $params[$i+1];
			}
		}
	}

	// On récupère les unités / dépôts / produits
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
	$q = 'SELECT *
		FROM produit
		INNER JOIN stock ON (stock.numProduit = produit.num)
		WHERE stock.quantite > 0';
	$r = mysql_query($q);
	while ($d = mysql_fetch_assoc($r)) {
		$products[$d['num']] = $d['nom'];
	}

	// Création du formulaire
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
		),
		'numProduit' => array(
			'label' => 'Produit',
			'type' => 'select',
			'values' => $products,
			'value' => (int) $numProduit
		)
	);

	// Traitement du post
	if(!empty($_POST)) {
		if(array_keys($_POST) == array_keys($champs)) {
			var_dump($_POST);
		}
	}

	return array(
		'champs' => $champs,
		'products' => !empty($products)
	);
}
