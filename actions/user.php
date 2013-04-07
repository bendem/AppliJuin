<?php

/**
 * Function de connexion au site,
 * Rejette l'utilisateur si déjà connecté
 *
 * @return array Les champs du formulaire à afficher
 */
function login() {
	kick(true);

	$champs = array(
		'nom' => array(
			'label' => 'Nom'
		),
		'pwd' => array(
			'label' => 'Mot de passe',
			'type'  => 'password'
		)
	);

	if(array_keys($champs) == array_keys($_POST)) {
		db_connect();
		$q = sql_select('*', 'users', array(
			'login' => $_POST['nom'],
			'pwd' => sha1($_POST['pwd'])
		));
		$res = mysql_query($q);
		if($data = mysql_fetch_assoc($res)) {
			session_write($data, 'user');
			session_set_flash('Vous êtes bien connecté', 'success');
			redirect(url());
		} else {
			session_set_flash("Vérifiez votre nom d'utilisateur ou votre mdp...", 'error');
		}
	}


	return array('champs' => $champs);
}

/**
 * Fonction d'inscription,
 * Rejette l'utilisateur si déjà connecté
 */
function register() {
	kick(true);

	$champs = array(
		'nom'       => array(
			'label' => 'Nom'
		),
		'pwd' => array(
			'label' => 'Mot de passe',
			'type'  => 'password'
		)
	);

	if(array_keys($champs) == array_keys($_POST)) {
		db_connect();

		$q = sql_select('*', 'users', array(
			'login' => $_POST['nom']
		));
		$res = mysql_query($q);
		if(mysql_fetch_assoc($res)) {
			session_set_flash("Nom d'utilisateur déjà utilisé", 'error');
		} else {
			$q = sql_insert(array(
				'login' => $_POST['nom'],
				'pwd' => sha1($_POST['pwd'])
			), 'users');
			$res = mysql_query($q);

			if($res) {
				session_set_flash("Vous avez bien été enregistré...", 'success');
			} else {
				session_set_flash("Erreur interne...", 'error');
			}
		}
	}

	return array('champs' => $champs);
}

/**
 *
 */
function index() {
	kick();

	$champs = array(
		'pwd1' => array(
			'label' => 'Mot de passe',
			'type'  => 'password'
		),
		'pwd2' => array(
			'label' => 'Recopiez-le',
			'type'  => 'password'
		)
	);

	return array('champs' => $champs);
}

function disconnect() {
	kick();
	session_write(array(), 'user');
	session_set_flash('Vous êtes bien déconnecté...', 'success');
	redirect(url());
}

?>