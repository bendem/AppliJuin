<?php

function index() {
	//try {
	//	$c = mysqli_connect('localhost', 'root', '', 'demartbe');
	//	var_dump($c);
	//	mysqli_set_opt($c, /* Cette constante doit changer */MYSQL_ATTR_INIT_COMMAND, 'SET NAMES utf8');
	//} catch(Exception $e) {
	//	die($e->getMessage());
	//}

	db_connect();
	$sql = sql_select('*', 'unite_fabrication');
	var_dump($sql);
	//$r = mysqli_query($c, $sql);
	$r = mysql_query($sql);
	//var_dump($r);
	// pas mysql_fetch_assoc !

	return array('data' => mysql_fetch_assoc($r));
	//return array('data' => mysqli_fetch_assoc($r));
}
