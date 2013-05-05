<?php

/**
 * Ce fichier contient les règles de validations des formulaires
 */

function validate_depot($post, $champs) {
	$errors = array();

	if(strlen($post['nom']) > 255 || strlen($post['nom']) < 3) {
		$errors['nom'] = 'Le nom doit comporter 3 à 255 caractères';
	}
	if(strlen($post['adresse']) > 255 || strlen($post['adresse']) < 3) {
		$errors['adresse'] = 'L\'adresse doit comporter 3 à 255 caractères';
	}
	if(strlen($post['ville']) > 255 || strlen($post['ville']) < 2) {
		$errors['ville'] = 'La ville doit comporter 2 à 255 caractères';
	}
	if(!preg_match('/^[1-9][0-9]{3}$/', $post['cp'])) {
		$errors['cp'] = 'Le code postal doit être un nombre à 4 chiffres (>=1000)';
	}
	if(!is_numeric($post['capaciteStockage']) || $post['capaciteStockage'] < 1) {
		$errors['capaciteStockage'] = 'La capacité de stockage doit être un nombre entier positif';
	}
	if(!in_array($post['responsable'], array_keys($champs['responsable']['values']))) {
		$errors['responsable'] = 'Le responsable doit faire partie de la liste';
	}
	if(!in_array($post['matiereDangereuse'], array('on', 'off'))) {
		$errors['matiereDangereuse'] = 'Vous ne pouvez pas choisir votre valeur';
	}

	return $errors;
}

function validate_unit($post) {
	$errors = array();

	if(strlen($_POST['nom']) > 255 || strlen($_POST['nom']) < 3) {
		$errors['nom'] = 'Le nom doit comporter 3 à 255 caractères';
	}
	if(strlen($_POST['adresse']) > 255 || strlen($_POST['adresse']) < 3) {
		$errors['adresse'] = 'L\'adresse doit comporter 3 à 255 caractères';
	}
	if(strlen($_POST['ville']) > 255 || strlen($_POST['ville']) < 2) {
		$errors['ville'] = 'La ville doit comporter 2 à 255 caractères';
	}
	if(!is_numeric($_POST['capaciteMax']) || $post['capaciteMax'] < 1) {
		$errors['capaciteMax'] = 'La capacité maximale doit être une valeur entière non nul, positive';
	}
	if(!preg_match('/^[1-9][0-9]{3}$/', $_POST['cp'])) {
		$errors['cp'] = 'Le code postal doit être un nombre à 4 chiffres (>=1000)';
	}

	return $errors;
}

function validate_product($post, $champs) {
	$errors = array();

	if(strlen($post['nom']) > 100 || strlen($post['nom']) < 3) {
		$errors['nom'] = 'Le nom doit comporter 3 à 100 caractères';
	}
	if(strlen($post['uniteMesure']) > 10 || strlen($post['uniteMesure']) < 1) {
		$errors['uniteMesure'] = 'L\'unité de mesure doit comporter 1 à 100 caractères';
	}
	if(!is_numeric($post['prix']) || $post['prix'] < 1) {
		$errors['prix'] = 'Le prix doit être une valeur numérique';
	}
	if(!in_array($post['type'], array_keys($champs['type']['values']))) {
		$errors['type'] = 'Le type doit faire partie de la liste';
	}
	if(!in_array($post['categorie'], array('on', 'off'))) {
		$errors['categorie'] = 'Vous ne pouvez pas choisir votre valeur';
	}
	$r = mysql_query("SELECT * FROM produit WHERE nom='" . mysql_real_escape_string($post['nom']) . "'");
	if($r) {
		if(mysql_num_rows($r) > 0 && !isset($post['num'])) {
			$errors['nom'] = 'Ce produit existe déjà';
		}
	}

	return $errors;
}

function validate_stock($post, $champs) {
	$errors = array();
	if(!is_numeric($post['numDepot'])) {
		$errors['numDepot'] = "Vous ne pouvez pas choisir";
	}
	if(!is_numeric($post['numProduit'])) {
		$errors['numProduit'] = "Vous ne pouvez pas choisir";
	}
	if(!is_numeric($post['quantite']) || $post['quantite'] < 1) {
		$errors['quantite'] = "La quantité doit être un nombre positif";
	}

	if(empty($errors)) {
		// On ne peut pas dépasser la capacité du dépot
		$r = mysql_query('SELECT * FROM depot WHERE num=' . $post['numDepot']);
		$rows = mysql_num_rows($r);
		if($rows < 1) {
			$errors['numDepot'] = "Le dépôt n'existe pas";
		}
		$depot = mysql_fetch_assoc($r);
		$q = 'SELECT SUM(quantite) FROM stock WHERE numDepot=' . $post['numDepot'];
		if(isset($post['edit'])) {
			$q .= ' AND numProduit<>' . $post['numProduit'];
		}
		$r = mysql_query($q);
		$quantity = mysql_fetch_array($r, MYSQL_NUM)[0];
		if($quantity + $post['quantite'] > $depot['capaciteStockage']) {
			$errors['quantite'] = "Le dépôt ne peut pas contenir plus de " . $depot['capaciteStockage'] . " unités";
		}
		$r = mysql_query('SELECT * FROM produit WHERE num=' . $post['numProduit']);
		if(mysql_num_rows($r) < 1) {
			$errors['numDepot'] = "Le produit n'existe pas";
		} else {
			$prod = mysql_fetch_assoc($r);
			if($prod['categorie'] && !$depot['matiereDangereuse']) {
				$errors['numDepot'] = 'Le dépôt ne peut pas contenir de matières dangereuses';
			}
		}
	}

	return $errors;
}

function validate_command($post, $champs) {
	$errors = array();
	if(!in_array($post['numUnite'], array_keys($champs['numUnite']['values']))) {
		$errors['numUnite'] = "Vous ne pouvez pas choisir vous même les valeurs...";
	}
	if(!in_array($post['numProduit'], array_keys($champs['numProduit']['values']))) {
		$errors['numProduit'] = "Vous ne pouvez pas choisir vous même les valeurs...";
	}
	if(!in_array($post['numDepot'], array_keys($champs['numDepot']['values']))) {
		$errors['numDepot'] = "Vous ne pouvez pas choisir vous même les valeurs...";
	}
	if(!is_numeric($post['quantite']) || $post['quantite'] <= 0) {
		$errors['quantite'] = "La quantité doit être un nombre positif...";
	}
	if(empty($errors)) {
		$q = 'SELECT quantite FROM stock WHERE numProduit=' . $post['numProduit'] . ' AND numDepot=' . $post['numDepot'];
		$r = mysql_query($q);
		if($r) {
			$d = mysql_fetch_assoc($r);
			if($post['quantite'] > $d['quantite']) {
				$errors['quantite'] = "Il n'y a pas assez de ce produit en stock";
			}
		}

	}

	return $errors;
}
