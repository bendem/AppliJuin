<?php

function index($params) {
	mysql_auto_connect();

	$valid_params = array(
		'tri', 'fl'
	);

	$tri = 'desc';
	$fl = false;

	foreach ($params as $k => $v) {
		if($v == 'tri') {
			$tri = 'asc';
		} elseif($v == 'fla' && isset($params[$k+1])) {
			$fl = $params[$k+1];
		}
	}

	$r = mysql_query('SELECT * FROM produit
		LEFT JOIN stock ON (stock.numProduit=produit.num)
		ORDER BY prix ' . strtoupper($tri));
	$data = mysql_fetch_all($r);

	$tri_url['action'] = 'product';
	if($tri != 'asc') {
		$tri_url['params'] = array('tri');
	}

	return array(
		'tri' => $tri,
		'tri_url' => $tri_url,
		'data' => $data,
		'del_confirm' => htmlentities('Êtes-vous sûr ? <a href="' . url(array(
			'action' => 'product',
			'view' => 'del',
			'params' => array('%s')
		)) . '" class="del btn btn-warning">Oui</a>')
	);
}

function add($params) {
	kick();
	$champs = array(
		'nom' => array(
			'label' => 'Nom'
		),
		'uniteMesure' => array(
			'label' => 'Unité de mesure'
		),
		'prix' => array(
			'label' => 'Prix'
		),
		'type' => array(
			'label' => 'Type',
			'type' => 'select',
			'values' => array(
				'matière-première' => 'Matière première',
				'semi-fini' => 'Produit semi-fini',
				'fini' => 'Produit fini'
			)
		),
		'categorie' => array(
			'label' => 'Matière dangereuse',
			'type' => 'checkbox'
		)
	);

	$errors = array();

	if(!empty($_POST)) {
		if(array_keys($_POST) == array_keys($champs)) {

			$errors = validate_product($_POST, $champs);

			if(empty($errors)) {
				$_POST['categorie'] = ($_POST['categorie'] == 'on');

				mysql_auto_connect();
				$sql = sql_insert($_POST, 'produit');
				if(mysql_query($sql)) {
					session_set_flash('Produit ajouté...');
				} else {
					session_set_flash("Erreur interne lors de l'ajout !", 'error');
				}
			} else {
				session_set_flash('Il y a des erreurs dans le formulaire...', 'warning');
				inject_errors($champs, $errors);
			}
		} else {
			session_set_flash('Formulaire incorect...', 'error');
		}
	}

	return array(
		'champs' => $champs,
		'errors' => $errors
	);
}

function edit($params) {
	kick();

	$champs = array(
		'num' => array(
			'label' => 'Numéro'
		),
		'nom' => array(
			'label' => 'Nom'
		),
		'uniteMesure' => array(
			'label' => 'Unité de mesure'
		),
		'prix' => array(
			'label' => 'Prix'
		),
		'type' => array(
			'label' => 'Type',
			'type' => 'select',
			'values' => array(
				'matière-première' => 'Matière première',
				'semi-fini' => 'Produit semi-fini',
				'fini' => 'Produit fini'
			)
		),
		'categorie' => array(
			'label' => 'Matière dangereuse',
			'type' => 'checkbox'
		)
	);

	mysql_auto_connect();

	/* Traitement du post */
	$errors = array();
	if(!empty($_POST)) {
		if(array_keys($_POST) == array_keys($champs)) {

			$errors = validate_product($_POST, $champs);

			if(empty($errors)) {
				$_POST['categorie'] = ($_POST['categorie'] == 'on');

				$sql = sql_update($_POST, 'produit', array('num' => $_POST['num']));
				$r = mysql_query($sql);
				if($r) {
					session_set_flash('Produit bien modifié...');
				} else {
					session_set_flash('Erreur interne !', 'error');
				}
			}

		} else {
			session_set_flash('Mauvais formulaire', 'error');
		}
	}

	/* Récupération des infos de l'unité */
	$sql = sql_select('*', 'produit', array(
		'num' => $params[0]
	));
	$r = mysql_query($sql);
	if(!$data = mysql_fetch_assoc($r)) {
		session_set_flash("Ce produit n'existe pas", 'error');
		redirect(url(array(
			'action' => 'produit'
		)));
	}

	foreach ($data as $k => $v) {
		$champs[$k]['value'] = $v;
		$champs[$k]['label'] = ucfirst($k);
		if($k == 'num') {
			$champs[$k]['readonly'] = 'true';
			$champs[$k]['class'] = 'disabled';
		} elseif ($k == 'type') {
			$champs[$k]['type'] = 'select';
		} elseif ($k == 'categorie') {
			$champs[$k]['type'] = 'checkbox';
			if($v) {
				$champs[$k]['checked'] = true;
			}
		}
		if(isset($errors[$k])) {
			$champs[$k]['help'] = $errors[$k];
			$champs[$k]['state'] = 'warning';
		}
	}

	return array(
		'data' => $champs
	);
}

function info($params) {
	if(is_numeric($params[0])) {
		$id = $params[0];
		mysql_auto_connect();
		$data = mysql_fetch_assoc(mysql_query('SELECT * FROM produit
			LEFT JOIN stock ON (stock.numProduit=produit.num)
			WHERE produit.num=' . $id
		));
	}
	return array(
		'd' => $data
	);
}

function del($params) {
	kick();
	if(is_numeric($params[0])) {
		$id = (int) $params[0];
		mysql_auto_connect();
		$msg = 'Produit supprimé avec succès... ';

		// Suppression du produit
		$q = 'DELETE FROM produit WHERE num=' . $id;
		if(mysql_query($q)) {
			// On enlève le produit des stocks
			mysql_query('DELETE FROM stock WHERE numProduit=' . $id);
			$nb = mysql_affected_rows();
			if($nb > 0) {
				$msg .= '(' . $nb . ' ligne' . (($nb > 1) ? 's' : '') . ' de stock supprimée' . (($nb > 1) ? 's' : '') . ')';
			}
			// On supprime les commandes du produit
			mysql_query('DELETE FROM ligne_commande WHERE numProduit=' . $id);
			// On supprime les commandes vides
			$q = 'SELECT num FROM commande WHERE NOT EXISTS(
					SELECT * FROM ligne_commande WHERE numCommande=num
				)';
			$r = mysql_query($q);
			$d = mysql_fetch_all($r);
			$nums = array();
			foreach ($d as $v) {
				$nums[] = 'num=' . $v['num'];
			}
			if(!empty($nums)) {
				mysql_query('DELETE FROM commande WHERE ' . implode(' OR ', $nums));
				$nb = mysql_affected_rows();
				if($nb > 0) {
					$msg .= ' (' . $nb . ' commande' . (($nb > 1) ? 's' : '') . ' supprimée' . (($nb > 1) ? 's' : '') . ')';
				}
			}
			session_set_flash($msg, 'success');
		} else {
			session_set_flash('Erreur interne', 'error');
		}
	} else {
		session_set_flash('Problème de paramètres pour la suppression', 'error');
	}
	redirect(url(array(
		'action' => 'product'
	)));
}
