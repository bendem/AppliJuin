<?php $title_for_layout = 'Profil' ?>

<div class="row-fluid">
	<div class="span12">
		<form action="<?= url($req) ?>" method="post" class="form-horizontal">

			<?php foreach($champs as $k => $v): ?>
				<?= form_input($k, $v) ?>
			<?php endforeach; ?>

			<div class="form-actions">
				<input type="submit" class="btn">
			</div>
		</form>
	</div>
</div>
