<?php

function index($fla = null) {
	mysql_auto_connect();
	if($fla) {
		$condSeparator = 'like';
		$sql = sql_select(
			'*',
			'unite_fabrication',
			'nom like "' . mysql_real_escape_string($fla[0]) . '%"',
			'like'
		);

	} else {
		$sql = sql_select('*', 'unite_fabrication');
	}
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

	$alph = array();
	for ($i=0; $i < 26; $i++) {
		$alph[] = chr($i + ord('A'));
	}

	return array(
		'alph' => $alph,
		'active' => ($fla) ? strtoupper($fla[0]) : null,
		'enabled' => $enabled,
		'data' => $data
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
				/*
					TO DO : Ajouter en bdd
				 */
				mysql_auto_connect();
				$tmp = $_POST;
				unset($tmp['capaciteMax']);
				unset($tmp['nom']);
				$r = mysql_query(sql_select('*', 'unite_fabrication', $tmp));
				if(mysql_fetch_assoc_all($r)) {
					session_set_flash('Il y a déjà une unité de fabrication à cette adresse...', 'warning');
				} else {
					$sql = sql_insert($_POST, 'unite_fabrication');
					var_dump($sql); die();
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
