<?php $title_for_layout = 'Édition de la commande n°' . $champs['num']['value'] ?>

<div class="row-fluid">
	<div class="span12">
		<form action="<?= url($req) ?>" class="form-horizontal" method="post">
			<?= form($champs) ?>
		</form>
	</div>
</div>
