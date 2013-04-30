<?php $title_for_layout = 'Nouvelle commande' ?>

<div class="row-fluid">
	<div class="span12">
		<?php if($products): ?>
			<form action="<?= url($req) ?>" method="post" class="form-horizontal">
				<?= form($champs) ?>
			</form>
		<?php else: ?>
			<div class="alert">
				Pas de produits disponible pour une commande...
			</div>
		<?php endif; ?>
	</div>
</div>
