<div class="page-header">
	<h1>Login</h1>
</div>
<form action="<?= url($req) ?>" method="post" class="form-horizontal">

	<?php foreach($champs as $k => $v): ?>
		<?= form_input($k, $v) ?>
	<?php endforeach; ?>

	<div class="form-actions">
		<input type="submit" class="btn">
	</div>
</form>
