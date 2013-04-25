<?php

function index($fla = null) {
	mysql_auto_connect();

	// On récupère les premières lettres de chaque unités
	$sql = sql_select('DISTINCT LEFT(nom, 1)', 'unite_fabrication');
	$r = mysql_query($sql);
	$data = mysql_fetch_all($r, MYSQL_NUM);

	$enabled = array();
	foreach ($data as $v) {
		$enabled[] = strtoupper($v[0]);
	}

	// On établit une condition pour sélectionner les unités nécessaires
	$cond = false;
	if($fla) {
		$cond = 'nom like "' . mysql_real_escape_string($fla[0]) . '%"';
	}

	$r = mysql_query(sql_select(
		'*',
		'unite_fabrication',
		$cond
	));
	$data = mysql_fetch_all($r);


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
			'action' => 'unit',
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
		'capaciteMax' => array(
			'label' => 'Capacité Maximale'
		),
		'adresse' => array(
			'label' => 'Adresse'
		),
		'ville' => array(
			'label' => 'Ville'
		),
		'cp' => array(
			'label' => 'Code Postal'
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
			if(!is_numeric($_POST['capaciteMax'])) {
				$errors['capaciteMax'] = 'La capacité maximale doit être une valeur entière';
			}
			if(!preg_match('/[1-9][0-9]{3}/', $_POST['cp'])) {
				$errors['cp'] = 'Le code postal doit être un nombre à 4 chiffres';
			}

			if(empty($errors)) {
				mysql_auto_connect();
				$tmp = $_POST;
				unset($tmp['capaciteMax']);
				unset($tmp['nom']);
				$r = mysql_query(sql_select('*', 'unite_fabrication', $tmp));
				if(mysql_fetch_all($r)) {
					session_set_flash('Il y a déjà une unité de fabrication à cette adresse...', 'warning');
				} else {
					$sql = sql_insert($_POST, 'unite_fabrication');
					if(mysql_query($sql)) {
						session_set_flash('Unité de fabrication ajoutée...');
					} else {
						session_set_flash("Erreur interne lors de l'ajout !", 'error');
					}

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
	/**
	 * Penser à supprimer les produits correspondants !!!
	 */
	kick();
	if(is_string($params[0]) && is_numeric($params[1])) {
		$nom = $params[0];
		$id = (int) $params[1];
	} else {
		session_set_flash('Problème de paramètres pour la suppression', 'error');
		redirect(url(array(
			'action' => 'unit'
		)));
	}


	mysql_auto_connect();
	$q = 'DELETE FROM unite_fabrication WHERE num=' . $id;
	if(mysql_query($q)) {
		session_set_flash('Unité supprimée avec succès', 'success');
	} else {
		session_set_flash('Erreur interne', 'error');
	}
	redirect(url(array(
		'action' => 'unit'
	)));
}

function edit($params) {
	kick();

	$champs = array(
		'num', 'nom',
		'capaciteMax',
		'adresse', 'ville',
		'cp'
	);

	mysql_auto_connect();

	/* Traitement du post */
	$errors = array();
	if(!empty($_POST)) {
		if(array_keys($_POST) == $champs) {

			if(strlen($_POST['nom']) > 255 || strlen($_POST['nom']) < 3) {
				$errors['nom'] = 'Le nom doit comporter 3 à 255 caractères';
			}
			if(strlen($_POST['adresse']) > 255 || strlen($_POST['adresse']) < 3) {
				$errors['adresse'] = 'L\'adresse doit comporter 3 à 255 caractères';
			}
			if(strlen($_POST['ville']) > 255 || strlen($_POST['ville']) < 2) {
				$errors['ville'] = 'La ville doit comporter 2 à 255 caractères';
			}
			if(!is_numeric($_POST['capaciteMax'])) {
				$errors['capaciteMax'] = 'La capacité maximale doit être une valeur entière';
			}
			if(!preg_match('/[1-9][0-9]{3}/', $_POST['cp'])) {
				$errors['cp'] = 'Le code postal doit être un nombre à 4 chiffres';
			}

			if(empty($errors)) {
				$sql = sql_update($_POST, 'unite_fabrication', array('num' => $_POST['num']));
				$r = mysql_query($sql);
				if($r) {
					session_set_flash('Unité bien modifiée...');
				} else {
					session_set_flash('Erreur interne !', 'error');
				}
			}

		} else {
			session_set_flash('Mauvais formulaire', 'error');
		}
	}

	/* Récupération des infos de l'unité */
	$sql = sql_select('*', 'unite_fabrication', array(
		'num' => $params[1]
	));
	$r = mysql_query($sql);
	if(!$data = mysql_fetch_assoc($r)) {
		session_set_flash("Cette unité n'existe pas...", 'error');
		redirect(url(array(
			'action' => 'unit'
		)));
	}

	$post = array();
	foreach ($data as $k => $v) {
		$post[$k]['value'] = $v;
		$post[$k]['label'] = ucfirst($k);
		if($k == 'num') {
			$post[$k]['readonly'] = 'true';
			$post[$k]['class'] = 'disabled';
		} elseif($k == 'capaciteMax') {
			$post[$k]['label'] = 'Capacité Maximale';
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
