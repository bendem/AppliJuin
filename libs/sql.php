<?php

/**
 * Génère une requête de type select
 * @param array/string $keys Attributs à sélectionner
 * @param string $table Table où chercher
 * @param array $cond Tableau associatif des conditions (AND utilisé par défaut)
 * @param string $cond Conditions à effectuer sur le select
 * @param string $condSeparator Séparateur de conditions (OR | AND)
 *								Uniquement pour un tableau de conditions !
 * @param boolean $force_quotes Force les quotes autours des valeurs numérique
 *
 * @return string La requête sql
 */
function sql_select($keys, $table, $cond = false, $condSeparator = 'and', $force_quotes = false) {
	$q = 'SELECT ';
	if(is_array($keys)) {
		$q .= implode(', ', $keys);
	} else {
		$q.= $keys;
	}
	$q .= ' FROM ' . $table;
	if($cond) {
		$q .= ' WHERE ';
		if(is_array($cond)) {
			$c = array();
			foreach ($cond as $k => $v) {
				if(is_numeric($v) && !$force_quotes) {
					$c[] = $k . "=" . $v;
				} else {
					$c[] = $k . "='" . mysql_real_escape_string($v) . "'";
				}
			}
			$q .= implode(' ' . strtoupper($condSeparator) . ' ', $c);
		} else {
			$q .= $cond;
		}
	}

	return $q;
}

/**
 * Génère une requête sql de type insert
 * @param array $data Tableau associatifs des données à insérer
 * @param string $table Table affectée par l'insertion
 * @param boolean $force_quotes Force les quotes autours des valeurs numérique
 *
 */
function sql_insert(array $data, $table, $force_quotes = false) {
	$q = 'INSERT INTO ' . $table . '(';
	$keys = array();
	$values = array();
	foreach ($data as $k => $v) {
		$keys[] = $k;
		if(is_numeric($v) && !$force_quotes) {
			$values[] = $v;
		} else {
			$values[] = "'" . mysql_real_escape_string($v) . "'";
		}
	}
	$q .= implode(', ', $keys) . ') VALUES (' . implode(', ', $values) . ')';

	return $q;
}

function sql_update(array $data, $table, $cond, $force_quotes = false) {
	$q = 'UPDATE ' . $table . ' SET ';
	$d = array();
	foreach ($data as $k => $v) {
		if(is_numeric($v) && !$force_quotes) {
			$d[] = $k . '=' . $v;
		} else {
			$d[] = $k . "='" . mysql_real_escape_string($v) . "'";
		}
	}

	$q .= implode(', ', $d) . ' WHERE ';

	if(is_array($cond)) {
		$q .= current(array_keys($cond)) . '=';
		if(is_numeric(current(array_values($cond))) && !$force_quotes) {
			$q .= current(array_values($cond));
		} else {
			$q .= "'" . mysql_real_escape_string(current(array_values($cond))) . "'";
		}
	} else {
		$q .= $cond;
	}

	return $q;

}
