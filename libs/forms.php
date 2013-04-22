<?php

/**
 * Génère un input de type text | number | password | date | file
 * @param array $options Options à ajouter au champs (label, id, state, class, help...)
 *
 * @return string Code du tag généré
 */
function form_input($name, array $options = array()) {
	// attributs non applicables sur le tag input
	$exceptions = array(
		'help',
		'state',
		'type',
		'id',
		'label'
	);

	// on enlève les attributs spéciaux du tableau d'options
	$specOptions = array();
	foreach ($exceptions as $v) {
		if(isset($options[$v])) {
			$specOptions[$v] = $options[$v];
			unset($options[$v]);
		}
	}
	//$options = array_diff($options, $specOptions);

	ob_start();
	require TEMPLATES_DIR . DS . 'input.php';

	return ob_get_clean();
}

/**
 * Génère le code d'un select
 * @param  string $name    Nom du select
 * @param  array $options  Options du select
 * @return string Code html du select
 */
function form_select($name, array $options = array()) {
	// attributs non applicables sur le tag input
	$exceptions = array(
		'help',
		'state',
		'id',
		'label',
		'values'
	);

	// on enlève les attributs spéciaux du tableau d'options
	$specOptions = array();
	foreach ($exceptions as $v) {
		if(isset($options[$v])) {
			$specOptions[$v] = $options[$v];
			unset($options[$v]);
		}
	}
	//$options = array_diff_assoc($options, $specOptions);

	ob_start();
	require TEMPLATES_DIR . DS . 'select.php';

	return ob_get_clean();
}

function form_radio($name, array $options = array()) {
	// attributs non applicables sur le tag input
	$exceptions = array(
		'help',
		'state',
		'id',
		'label',
		'values'
	);

	// on enlève les attributs spéciaux du tableau d'options
	$specOptions = array();
	foreach ($exceptions as $v) {
		if(isset($options[$v])) {
			$specOptions[$v] = $options[$v];
			unset($options[$v]);
		}
	}
	//$options = array_diff_assoc($options, $specOptions);

	ob_start();
	require TEMPLATES_DIR . DS . 'radio.php';

	return ob_get_clean();
}

function form_checkbox($name, array $options = array()) {
	// attributs non applicables sur le tag input
	$exceptions = array(
		'help',
		'state',
		'id',
		'label',
		'checked',
		'value'
	);

	// on enlève les attributs spéciaux du tableau d'options
	$specOptions = array();
	foreach ($exceptions as $v) {
		if(isset($options[$v])) {
			$specOptions[$v] = $options[$v];
			unset($options[$v]);
		}
	}
	//$options = array_diff_assoc($options, $specOptions);

	ob_start();
	require TEMPLATES_DIR . DS . 'checkbox.php';

	return ob_get_clean();
}
