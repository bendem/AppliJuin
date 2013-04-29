<a data-toggle="tooltip" data-title="Informations" href="<?= url(array(
	'action' => $action,
	'view' => 'info',
	'params' => $params
)) ?>" class="btn btn-success">
	<span class="icon-list"></span>
</a>
<?php if(is_connected()): ?>
	<a data-toggle="tooltip" data-title="Édition" href="<?= url(array(
		'action' => $action,
		'view' => 'edit',
		'params' => $params
	)) ?>" class="btn btn-warning">
		<span class="icon-edit"></span>
	</a>
	<a href="#" class="btn btn-danger" data-content="<?php printf($del_confirm_text, $params[0], $params[1]) ?>" data-html="true" data-text="Vraiment sur ?" data-toggle="popover" data-title="Suppression">
		<span class="icon-remove"></span>
	</a>
<?php endif; ?>
