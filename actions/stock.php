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
				/*
					Ajout en bdd !!!
				 */
				$sql = sql_insert($_POST, 'stock');
				$sql .= ' ON DUPLICATE KEY UPDATE quantite=quantite+' . $_POST['quantite'];
				if(mysql_query($sql)) {
					session_set_flash('Stock mis à jour...');
				} else {
					session_set_flash("Erreur interne ($sql)", 'error');
				}
			} else {
				session_set_flash('Il y a des erreurs dans le formulaire...', 'warning');
				foreach ($champs as $k => $v) {
					if(isset($errors[$k])) {
						$champs[$k]['help'] = $errors[$k];
						$champs[$k]['state'] = 'warning';
					} else {
						$champs[$k]['state'] = 'success';
					}
					$champs[$k]['value'] = $_POST[$k];
				}
			}
		} else {
			session_set_flash('Formulaire incorect...', 'error');
		}
	}

	return array(
		'champs' => $champs
	);
}

function edit($params) {
	mysql_auto_connect();
}

function del($params) {
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
