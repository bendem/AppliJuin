<?php

function index($fla = null) {
	mysql_auto_connect();

	$sql = sql_select('*', 'depot');
	$r = mysql_query($sql);
	$data = mysql_fetch_assoc_all($r);

	// Premières lettres définies
	$enabled = array();
	foreach ($data as $v) {
		$fl = strtoupper(substr($v['nom'], 0, 1));
		if(!in_array($fl, $enabled)) {
			$enabled[] = $fl;
		}
	}

	if($fla) {
		$condSeparator = 'like';
		$sql = sql_select(
			'*',
			'depot',
			'nom like "' . mysql_real_escape_string($fla[0]) . '%"',
			'like'
		);

		$r = mysql_query($sql);
		$data = mysql_fetch_assoc_all($r);
	}


	$alph = array();
	for ($i=0; $i < 26; $i++) {
		$alph[] = chr($i + ord('A'));
	}

	return array(
		'alph' => $alph,
		'active' => ($fla) ? strtoupper($fla[0]) : null,
		'enabled' => $enabled,
		'data' => $data,
		'del_confirm' => htmlentities('Êtes-vous sûr ? <a href="' . url(array(
			'action' => 'depot',
			'view' => 'del',
			'params' => array('%s', '%s')
		)) . '" class="del btn btn-warning">Oui</a>')
	);
}

function add() {
	/* Définition du formulaire */
	$post = array(
		'nom' => array(
			'label' => 'Nom'
		),
		'adresse' => array(
			'label' => 'Adresse'
		),
		'ville' => array(
			'label' => 'Ville'
		),
		'cp' => array(
			'label' => 'Code Postal'
		),
		'capaciteStockage' => array(
			'label' => 'Capacité de stockage'
		),
		'responsable' => array(
			'type' => 'select',
			'label' => 'Responsable',
			'values' => array(
				'XA', 'GT', 'LP', 'RS', 'TT'
			)
		),
		'matiereDangereurse' => array(
			'label' => 'Matière dangereuse',
			'type' => 'radio'
		)
	);

	$errors = array();

	if(!empty($_POST)) {
		if(array_keys($_POST) == array_keys($post)) {
			/*
				Gestion des erreurs
			 */
			if(strlen($_POST['nom']) > 255 || strlen($_POST['nom']) < 3) {
				$errors['nom'] = 'Le nom doit comporter 3 à 255 caractères';
			}
			if(strlen($_POST['adresse']) > 255 || strlen($_POST['adresse']) < 3) {
				$errors['adresse'] = 'L\'adresse doit comporter 3 à 255 caractères';
			}
			if(strlen($_POST['ville']) > 255 || strlen($_POST['ville']) < 2) {
				$errors['ville'] = 'La ville doit comporter 2 à 255 caractères';
			}
			if(!preg_match('/[1-9][0-9]{3}/', $_POST['cp'])) {
				$errors['cp'] = 'Le code postal doit être un nombre à 4 chiffres';
			}

			var_dump($_POST);
			var_dump($errors);
			die();

			if(empty($errors)) {
				mysql_auto_connect();
				$tmp = $_POST;
				$r = mysql_query(sql_select('*', 'depot', $tmp));
				$sql = sql_insert($_POST, 'depot');
				if(mysql_query($sql)) {
					session_set_flash('Dépôt ajouté...');
				} else {
					session_set_flash("Erreur interne lors de l'ajout !", 'error');
				}
			} else {
				session_set_flash('Il y a des erreurs dans le formulaire...', 'warning');
				foreach ($post as $k => $v) {
					if(isset($errors[$k])) {
						$post[$k]['help'] = $errors[$k];
						$post[$k]['state'] = 'warning';
					} else {
						$post[$k]['state'] = 'success';
					}
					$post[$k]['value'] = $_POST[$k];
				}
			}
		} else {
			session_set_flash('Formulaire incorect...', 'error');
		}
	}

	return array(
		'post' => $post,
		'errors' => $errors
	);
}

function del($params) {
	kick();
	var_dump($params);
}

function edit($params) {
	kick();

	$champs = array();

	mysql_auto_connect();

	/* Traitement du post */
	$errors = array();
	if(!empty($_POST)) {
		if(array_keys($_POST) == $champs) {

			if(empty($errors)) {
				$sql = sql_update($_POST, 'depot', array('num' => $_POST['num']));
				$r = mysql_query($sql);
				if($r) {
					session_set_flash('Dépôt bien modifié...');
				} else {
					session_set_flash('Erreur interne !', 'error');
				}
			}

		} else {
			session_set_flash('Mauvais formulaire', 'error');
		}
	}

	/* Récupération des infos de l'unité */
	$sql = sql_select('*', 'depot', array(
		'num' => $params[1]
	));
	$r = mysql_query($sql);
	if(!$data = mysql_fetch_assoc($r)) {
		session_set_flash("Ce dépôt n'existe pas...", 'error');
		redirect(url(array(
			'action' => 'depot'
		)));
	}

	$post = array();
	foreach ($data as $k => $v) {
		$post[$k]['value'] = $v;
		$post[$k]['label'] = ucfirst($k);
		if($k == 'num') {
			$post[$k]['readonly'] = 'true';
			$post[$k]['class'] = 'disabled';
		}
		if(isset($errors[$k])) {
			$post[$k]['help'] = $errors[$k];
			$post[$k]['state'] = 'warning';
		}
	}

	return array(
		'data' => $post
	);
}
