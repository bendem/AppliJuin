<?php

function index() {
	mysql_auto_connect();

	$r = mysql_query(sql_select('*', 'produit'));
	$data = mysql_fetch_all($r);

	return array(
		'data' => $data,
		'del_confirm' => htmlentities('Êtes-vous sûr ? <a href="' . url(array(
			'action' => 'product',
			'view' => 'del',
			'params' => array('%s', '%s')
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
		'num' => $params[1]
	));
	$r = mysql_query($sql);
	if(!$data = mysql_fetch_assoc($r)) {
		session_set_flash("Ce produit n'existe pas...", 'error');
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
	if(is_numeric($params[1])) {
		$id = $params[1];
		mysql_auto_connect();
		$data = mysql_fetch_assoc(mysql_query(sql_select('*', 'produit', array('num' => $id))));
	}
	return array(
		'nom' => ucfirst($params[0]),
		'data' => $data
	);
}

function del($params) {
	/**
	 * Penser à supprimer les stocks correspondants !!!
	 */
	kick();
	if(is_string($params[0]) && is_numeric($params[1])) {
		$nom = $params[0];
		$id = (int) $params[1];

		mysql_auto_connect();
		$q = 'DELETE FROM produit WHERE num=' . $id;
		if(mysql_query($q)) {
			session_set_flash('Produit supprimé avec succès', 'success');
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
