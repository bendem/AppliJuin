<?php $title_for_layout = "Édition d'unité de fabrication" ?>

<div class="row">
	<div class="span12">
		<form action="<?= url($req) ?>" method="post" class="form-horizontal">

			<?php foreach($data as $k => $v): ?>
				<?= form_input($k, $v) ?>
			<?php endforeach; ?>

			<div class="form-actions">
				<input type="submit" class="btn">
				<input type="reset" class="btn btn-danger">
			</div>
		</form>
	</div>
</div>
