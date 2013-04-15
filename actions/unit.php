<?php

function index($fla = null) {
	mysql_auto_connect();
	$sql = sql_select('*', 'unite_fabrication');
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
