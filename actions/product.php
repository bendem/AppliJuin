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
				'',
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



	return array(
		'champs' => $champs
	);
}

function del($params) {
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
