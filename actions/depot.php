<?php

function index($fla = null) {
	mysql_auto_connect();

	// On récupère les premières lettres de chaque dépôt
	$sql = sql_select('DISTINCT LEFT(nom, 1)', 'depot');
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
		'depot',
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
			'action' => 'depot',
			'view' => 'del',
			'params' => array('%s')
		)) . '" class="del btn btn-warning">Oui</a>')
	);
}

function add() {
	kick();
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
				'',
				'XA' => 'XA',
				'GT' => 'GT',
				'LP' => 'LP',
				'RS' => 'RS',
				'TT' => 'TT'
			)
		),
		'matiereDangereuse' => array(
			'label' => 'Matière dangereuse',
			'type' => 'checkbox'
		)
	);

	$errors = array();

	if(!empty($_POST)) {
		if(array_keys($_POST) == array_keys($post)) {

			$errors = validate_depot($_POST, $post);

			mysql_auto_connect();
			if(mysql_num_rows(mysql_query(sql_select('*', 'depot', array('nom' => $_POST['nom']))))) {
				$errors['nom'] = "Nom déjà utilisé";
			}

			if(empty($errors)) {
				$_POST['matiereDangereuse'] = ($_POST['matiereDangereuse'] == 'on');

				$sql = sql_insert($_POST, 'depot');
				if(mysql_query($sql)) {
					session_set_flash('Dépôt ajouté...');
				} else {
					session_set_flash("Erreur interne ($sql)", 'error');
				}
			} else {
				session_set_flash('Il y a des erreurs dans le formulaire...', 'warning');
				inject_errors($post, $errors);
			}
		} else {
			session_set_flash('Formulaire incorrect...', 'error');
		}
	}

	return array(
		'post' => $post,
		'errors' => $errors
	);
}

function del($params) {
	/**
	 * Penser à supprimer les produits et les commandes correspondants !!!
	 */
	kick();

	if(is_numeric($params[0])) {
		$id = (int) $params[0];
		mysql_auto_connect();

		$q = 'DELETE FROM depot WHERE num=' . $id;
		if(mysql_query($q)) {
			$d = mysql_fetch_all(mysql_query('SELECT num FROM commande WHERE numDepot=' . $id));
			$nums = array();
			foreach ($d as $v) {
				$nums['commande'][] = 'num=' . $v['num'];
				$nums['ligne_commande'][] = 'numCommande=' . $v['num'];
			}
			if(!empty($nums)) {
				mysql_query('DELETE FROM commande WHERE ' . implode(' OR ', $nums['commande']));
				mysql_query('DELETE FROM ligne_commande WHERE ' . implode(' OR ', $nums['ligne_commande']));
			}
			session_set_flash('Dépôt supprimé avec succès', 'success');
		} else {
			session_set_flash('Erreur interne (' . $q . ')', 'error');
		}
	} else {
		session_set_flash('Problème de paramètres pour la suppression', 'error');
	}

	redirect(url(array(
		'action' => 'depot'
	)));
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
				'',
				'XA' => 'XA',
				'GT' => 'GT',
				'LP' => 'LP',
				'RS' => 'RS',
				'TT' => 'TT'
			)
		),
		'matiereDangereuse' => array(
			'label' => 'Matière dangereuse',
			'type' => 'checkbox'
		)
	);

	mysql_auto_connect();

	/* Traitement du post */
	$errors = array();
	if(!empty($_POST)) {
		if(array_keys($_POST) == array_keys($champs)) {

			$errors = validate_depot($_POST, $champs);

			if(empty($errors)) {
				$_POST['matiereDangereuse'] = ($_POST['matiereDangereuse'] == 'on');

				$sql = sql_update($_POST, 'depot', array('num' => $_POST['num']));
				$r = mysql_query($sql);
				if($r) {
					session_set_flash('Dépôt bien modifié...');
				} else {
					session_set_flash('Erreur interne  (' . $sql . ') !', 'error');
				}
			}

		} else {
			session_set_flash('Mauvais formulaire', 'error');
		}
	}

	/* Récupération des infos de l'unité */
	$sql = sql_select('*', 'depot', array(
		'num' => $params[0]
	));
	$r = mysql_query($sql);
	if(!$data = mysql_fetch_assoc($r)) {
		session_set_flash("Ce dépôt n'existe pas", 'error');
		redirect(url(array(
			'action' => 'depot'
		)));
	}

	foreach ($data as $k => $v) {
		$champs[$k]['value'] = $v;
		$champs[$k]['label'] = ucfirst($k);
		if($k == 'num') {
			$champs[$k]['readonly'] = 'true';
			$champs[$k]['class'] = 'disabled';
		} elseif ($k == 'responsable') {
			$champs[$k]['type'] = 'select';
		} elseif ($k == 'matiereDangereuse') {
			$champs[$k]['type'] = 'checkbox';
			if($v) {
				$champs[$k]['checked'] = true;
			}
		}
	}
	if(!empty($_POST)) {
		inject_errors($champs, $errors);
	}

	return array(
		'data' => $champs
	);
}

function info($params) {
	if(is_numeric($params[0])) {
		$id = $params[0];
		mysql_auto_connect();
		$data = mysql_fetch_assoc(mysql_query(sql_select('*', 'depot', array('num' => $id))));
	}
	return array(
		'resp' => array(
			'',
			'XA' => 'XA',
			'GT' => 'GT',
			'LP' => 'LP',
			'RS' => 'RS',
			'TT' => 'TT'
		),
		'd' => $data
	);
}
