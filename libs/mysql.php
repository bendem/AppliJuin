<?php

/**
 * Récupère tous les enregistrements du résultat d'un requête sql
 * @param  ressource $r Résultat de la requête
 * @param  int $result_type Type de retour souhaité (MYSQL_ASSOC|MYSQL_NUM|MYSQL_BOTH)
 * @return array Tous les résultats dans un tableau
 */
function mysql_fetch_all($r, $result_type = MYSQL_ASSOC) {
	$tmp = array();
	while($data = mysql_fetch_array($r, $result_type)) {
		$tmp[] = $data;
	}

	return $tmp;
}

/**
 * Auto connexion à la base de données
 * @param  array  $config Configuration différente
 * @return ressource Connexion à la bdd
 */
function mysql_auto_connect(array $config = array()) {
	$default_config = array(
		'host' => 'eve',
		'user' => 'demartbe',
		'pwd'  => 'demartbe',
		'db_name' => 'demartbe'
	);

	if(LOCAL || !empty($config)) {
		$config = array(
			'host' => 'localhost',
			'user' => 'root',
			'pwd'  => ''
		);
	}

	$config = array_merge($default_config, $config);

	$link = mysql_connect($config['host'], $config['user'], $config['pwd'])
		or die("Impossible de se connecter : " . mysql_error());
	mysql_select_db($config['db_name'], $link)
		or die('Base de donnée dans les ténèbres !');
	mysql_set_charset('utf8')
		or die('Utf-8 non supporté : F*** OFF !!!!!!!!');
	return $link;
}
