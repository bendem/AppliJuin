<?php

function index() {
	mysql_auto_connect();

	$sql = 'SELECT stock.*, stock.quantite, produit.nom as nom_produit, depot.nom as nom_depot
		FROM stock
		INNER JOIN produit ON(produit.num=stock.numProduit)
		INNER JOIN depot ON(depot.num=stock.numDepot)';
	$r = mysql_query($sql);

	return array(
		'data' => mysql_fetch_all($r),
		'del_confirm' => htmlentities('Êtes-vous sûr ? <a href="' . url(array(
			'action' => 'stock',
			'view' => 'del',
			'params' => array('%s', '%s')
		)) . '" class="del btn btn-warning">Oui</a>')
	);
}

function add() {
	kick();
	mysql_auto_connect();
	$q = array(
		'depots' => 'SELECT num, nom FROM depot',
		'products' => 'SELECT num, nom FROM produit'
	);
	foreach ($q as $k => $v) {
		$r = mysql_query($v);
		while($d = mysql_fetch_assoc($r)) {
			$data[$k][$d['num']] = $d['nom'];
		}
	}
	extract($data);

	$champs = array(
		'numDepot' => array(
			'label' => 'Dépôt',
			'type' => 'select',
			'values' => $depots
		),
		'numProduit' => array(
			'label' => 'Produit',
			'type' => 'select',
			'values' => $products
		),
		'quantite' => array(
			'label' => 'Quantité',
			'value' => 0
		)
	);

	$errors = array();
	if(!empty($_POST)) {
		if(array_keys($_POST) == array_keys($champs)) {

			$errors = validate_stock($_POST, $champs);

			if(empty($errors)) {
				$sql = sql_insert($_POST, 'stock');
				$sql .= ' ON DUPLICATE KEY UPDATE quantite=quantite+' . $_POST['quantite'];
				if(mysql_query($sql)) {
					session_set_flash('Stock mis à jour...');
				} else {
					session_set_flash("Erreur interne ($sql)", 'error');
				}
			} else {
				session_set_flash('Il y a des erreurs dans le formulaire...', 'warning');
				inject_errors($champs, $errors);
			}
		} else {
			session_set_flash('Formulaire incorrect...', 'error');
		}
	}

	return array(
		'champs' => $champs
	);
}

function edit($params) {
	kick();
	mysql_auto_connect();
	if(sizeof($params) != 2 || !is_numeric($params[0]) || !is_numeric($params[1])) {
		session_set_flash("Stock incorrect", 'error');
		redirect(url(array(
			'action' => 'stock'
		)));
	}

	$r = mysql_query('SELECT * FROM stock WHERE numDepot=' . $params[0] . ' AND numProduit=' . $params[1]);
	$data = mysql_fetch_assoc($r);

	$champs = array(
		'edit' => array(
			'type' => 'hidden'
		),
		'numDepot' => array(
			'label' => 'Dépôt',
			'value' => $params[0],
			'readonly' => 'true'
		),
		'numProduit' => array(
			'label' => 'Produit',
			'value' => $params[1],
			'readonly' => 'true'
		),
		'quantite' => array(
			'label' => 'Quantité',
			'value' => $data['quantite']
		)
	);

	if(!empty($_POST)) {
		if(array_keys($_POST) == array_keys($champs)) {

			$errors = validate_stock($_POST, $champs);

			if(empty($errors)) {
				$sql = sql_insert($_POST, 'stock');
				$sql .= ' ON DUPLICATE KEY UPDATE quantite=' . $_POST['quantite'];
				if(mysql_query($sql)) {
					session_set_flash('Stock mis à jour...');
					$champs['quantite']['value'] = $_POST['quantite'];
				} else {
					session_set_flash("Erreur interne ($sql)", 'error');
				}
			} else {
				session_set_flash('Il y a des erreurs dans le formulaire...', 'warning');
				inject_errors($champs, $errors);
			}
		} else {
			session_set_flash('Formulaire incorrect...', 'error');
		}
	}

	return array(
		'champs' => $champs
	);
}

function del($params) {
	kick();

	mysql_auto_connect();
	if(mysql_query('DELETE FROM stock WHERE numProduit=' . $params[1] . ' AND numDepot=' . $params[0])) {
		session_set_flash('Le produit a été supprimé du stock');
	} else {
		session_set_flash('Erreur interne ?', 'error');
	}
	redirect(url(array(
		'action' => 'stock'
	)));
}

function info($params) {
	if(is_numeric($params[0])) {
		mysql_auto_connect();
		$q = 'SELECT
				stock.*,
				produit.nom as nomProduit,
				produit.prix as prixProduit,
				produit.type as typeProduit,
				produit.categorie as categorieProduit,
				produit.uniteMesure as uniteProduit,
				depot.nom as nomDepot,
				depot.adresse as adresseDepot,
				depot.ville as villeDepot,
				depot.cp as cpDepot,
				depot.capaciteStockage as capaciteDepot,
				depot.responsable as responsableDepot
			FROM stock
			INNER JOIN produit ON (stock.numProduit=produit.num)
			INNER JOIN depot ON (stock.numDepot=depot.num)
			WHERE stock.numDepot=' . $params[0] . ' AND stock.numProduit=' . $params[1];
		$data = mysql_fetch_assoc(mysql_query($q));
	}
	return array(
		'd' => $data
	);
}
