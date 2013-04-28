<?php

function index($fla = null) {
	mysql_auto_connect();

	// On récupère les premières lettres de chaque dépôt
	$sql = sql_select('DISTINCT LEFT(nom, 1)', 'produit');
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
		'produit',
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
			'action' => 'product',
			'view' => 'del',
			'params' => array('%s', '%s')
		)) . '" class="del btn btn-warning">Oui</a>')
	);
}
