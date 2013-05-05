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
		WHERE stock.quantite > 0
		ORDER BY produit.nom';
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
		),
		'quantite' => array(
			'label' => 'Quantité'
		)
	);

	$errors = array();
	// Traitement du post
	if(!empty($_POST)) {
		if(array_keys($_POST) == array_keys($champs)) {

			$errors = validate_command($_POST, $champs);

			if(empty($errors)) {
				$r = mysql_query(sql_select(
					'num',
					'commande',
					array(
						'numUnite' => $_POST['numUnite'],
						'numDepot' => $_POST['numDepot'],
						'dateCommande' => date("Y-m-d")
					)
				));
				if(mysql_num_rows($r) == 0) {
					// Si la commande n'existe pas encore on la crée
					mysql_query(sql_insert(
						array(
							'numUnite' => $_POST['numUnite'],
							'numDepot' => $_POST['numDepot'],
							'dateCommande' => date("Y-m-d")
						), 'commande'
					));
					$num = mysql_insert_id();
				} else {
					$d = mysql_fetch_assoc($r);
					$num = $d['num'];
				}
				mysql_query(sql_insert(
					array(
						'numCommande' => $num,
						'numProduit' => $_POST['numProduit'],
						'quantite' => $_POST['quantite']
					), 'ligne_commande'
				));
				session_set_flash("Produit ajouté à la commande n° $num");
			} else {
				inject_errors($champs, $errors);
			}
		}
	}


	return array(
		'champs' => $champs,
		'products' => !empty($products)
	);
}

function info($params) {
	if(is_numeric($params[0])) {
		$id = $params[0];
		mysql_auto_connect();

		$q = 'SELECT commande.*,
				depot.nom as nomDepot,
				depot.adresse as adresseDepot,
				depot.ville as villeDepot,
				depot.cp as cpDepot,
				unite_fabrication.nom as nomUnite,
				unite_fabrication.adresse as adresseUnite,
				unite_fabrication.ville as villeUnite,
				unite_fabrication.cp as cpUnite
			FROM commande
			INNER JOIN depot ON (depot.num=commande.numDepot)
			INNER JOIN unite_fabrication ON (unite_fabrication.num=commande.numUnite)
			WHERE commande.num=' . $id;
		$r = mysql_query($q);
		$command = mysql_fetch_assoc($r);

		$q = 'SELECT * FROM ligne_commande
			INNER JOIN produit ON (produit.num=ligne_commande.numProduit)
			WHERE ligne_commande.numCommande=' . $id;
		$data = mysql_fetch_all(mysql_query($q));
	}
	return array(
		'command' => $command,
		'd' => $data
	);
}

function del($params) {
	kick();

	if(is_numeric($params[0])) {
		$id = (int) $params[0];
		mysql_auto_connect();

		$q = 'DELETE FROM commande WHERE num=' . $id;
		$r = mysql_query($q);
		if($r) {
			$r = mysql_query('DELETE FROM ligne_commande WHERE numCommande=' . $id);
			if($r) {
				session_set_flash('Commande supprimée avec succès');
			} else {
				session_set_flash('Erreur interne', 'error');
			}
		} else {
			session_set_flash('Erreur interne', 'error');
		}
	}
	redirect(url(array(
		'action' => 'command'
	)));
}

function edit($params) {
	kick();

	if(!is_numeric($params[0])) {
		session_set_flash("Erreur de paramètres", 'error');
		redirect(url(array(
			'action' => 'command'
		)));
	}

	mysql_auto_connect();

	$id = (int) $params[0];
	// On récupère les unités / dépôts / produits
	// units
	$r = mysql_query(sql_select('num, nom, cp', 'unite_fabrication'));
	$units = array();
	while ($d = mysql_fetch_assoc($r)) {
		$units[$d['num']] = $d['nom'] . ' - ' . $d['cp'];
	}
	// depots
	$r = mysql_query(sql_select('num, nom, cp', 'depot'));
	$depots = array();
	while ($d = mysql_fetch_assoc($r)) {
		$depots[$d['num']] = $d['nom'] . ' - ' . $d['cp'];
	}
	// products
	$q = 'SELECT *
		FROM produit
		INNER JOIN stock ON (stock.numProduit = produit.num)
		WHERE stock.quantite > 0
		ORDER BY produit.nom';
	$r = mysql_query($q);
	while ($d = mysql_fetch_assoc($r)) {
		$products[$d['num']] = $d['nom'];
	}

	// Commandes
	$r = mysql_query('SELECT * FROM commande WHERE num=' . $id);
	$commande = mysql_fetch_assoc($r);

	$champs = array(
		'num' => array(
			'label' => 'Numéro de commande',
			'value' => $id,
			'readonly' => 'true'
		),
		'numUnite' => array(
			'label' => 'Unité de fabrication',
			'value' => $commande['numUnite'],
			'readonly' => 'true'
		),
		'numDepot' => array(
			'label' => 'Dépôt',
			'value' => $commande['numDepot'],
			'readonly' => 'true'
		)
	);

	$r = mysql_query('SELECT * FROM ligne_commande WHERE numCommande=' . $id);
	$lignes = mysql_fetch_all($r);
	foreach ($lignes as $k => $ligne) {
		$tmp['numProduit[' . $k . ']'] = array(
			'label' => 'Produit',
			'type' => 'select',
			'values' => $products,
			'value' => $ligne['numProduit']
		);
		$tmp['quantite[' . $k . ']'] = array(
			'label' => 'Produit',
			'value' => $ligne['quantite']
		);
		$champs = array_merge($champs, $tmp);
	}

	var_dump($champs);

	$errors = array();
	if(!empty($_POST)) {
		if(array_keys($_POST) == array_keys($champs)) {
			var_dump($_POST);
			$errors = validate_command($_POST, $champs);

			if(empty($errors)) {
			} else {
				inject_errors($champs, $errors);
			}
		}
	}

	return array(
		'champs' => $champs
	);
}
