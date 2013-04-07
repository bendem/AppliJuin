<div class="page-header">
	<h1>Accueil. <small>Voici une appli Php !</small></h1>
</div>
<div class="row">
	<div class="span3">
		Progression globale :
	</div>
	<div class="span9">
		<div class="progress">
			<div class="bar" style="width: <?= $glob ?>%;"></div>
		</div>
	</div>
</div>
<?php foreach($progress as $k => $v): ?>
	<div class="row">
		<div class="span2 offset1">
			<?= ucfirst($k) ?>
		</div>
		<div class="span9">
			<div class="progress">
				<div class="bar" style="width: <?= $v ?>%;"></div>
			</div>
		</div>
	</div>
<?php endforeach; ?>
