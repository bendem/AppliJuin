<?php

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
	if(!preg_match('/[1-9][0-9]{3}/', $post['cp'])) {
		$errors['cp'] = 'Le code postal doit être un nombre à 4 chiffres (>=1000)';
	}
	if(!is_numeric($post['capaciteStockage']) || $post['capaciteStockage'] < 1) {
		$errors['capaciteStockage'] = 'La capacité de stockage doit être un nombre';
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
		$errors['capaciteMax'] = 'La capacité maximale doit être une valeur entière';
	}
	if(!preg_match('/[1-9][0-9]{3}/', $_POST['cp'])) {
		$errors['cp'] = 'Le code postal doit être un nombre à 4 chiffres (>=1000)';
	}

	return $errors;
}

function validate_product($post, $champs) {
	$errors = array();

	if(strlen($_POST['nom']) > 100 || strlen($_POST['nom']) < 3) {
		$errors['nom'] = 'Le nom doit comporter 3 à 100 caractères';
	}
	if(strlen($_POST['uniteMesure']) > 10 || strlen($_POST['uniteMesure']) < 1) {
		$errors['uniteMesure'] = 'L\'unité de mesure doit comporter 1 à 100 caractères';
	}
	if(!is_numeric($_POST['prix']) || $post['prix'] < 1) {
		$errors['prix'] = 'Le prix doit être une valeur numérique';
	}
	if(!in_array($post['type'], array_keys($champs['type']['values']))) {
		$errors['type'] = 'Le type doit faire partie de la liste';
	}
	if(!in_array($post['categorie'], array('on', 'off'))) {
		$errors['categorie'] = 'Vous ne pouvez pas choisir votre valeur';
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
		if(mysql_num_rows(mysql_query('SELECT * FROM depot WHERE num=' . $post['numDepot'])) < 1) {
			$errors['numDepot'] = "Le dépôt n'existe pas";
		}
		if(mysql_num_rows(mysql_query('SELECT * FROM produit WHERE num=' . $post['numProduit'])) < 1) {
			$errors['numDepot'] = "Le produit n'existe pas";
		}
	}

	return $errors;
}
