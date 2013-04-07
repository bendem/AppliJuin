<?php

/**
 * Génère un input de type text | number | password | date | file
 * @param array $options Options à ajouter au champs (label, id, state, class...)
 *
 * @return string Code du tag généré
 */
function form_input($name, array $options = array()) {
	// attributs non applicables sur le tag input
	$exceptions = array(
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
		}
	}
	$options = array_diff($options, $specOptions);

	ob_start();
	require TEMPLATES_DIR . DS . 'input.php';
	$html = ob_get_clean();

	return $html;
}


?>