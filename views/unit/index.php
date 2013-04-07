<?php
$alph = array(
	'a', 'b', 'c', 'd',
	'e', 'f', 'g', 'h',
	'i', 'j', 'k', 'l',
	'm', 'n', 'o', 'p',
	'q', 'r', 's', 't',
	'u', 'v', 'w', 'x',
	'y', 'z'
);
$dis = array(
	'b', 'e', 'f', 'p'
);
$active = 'v';
?>
<div class="row">
	<div class="span12">
		<h1 class="page-header">Unités de fabrication</h1>
	</div>
</div>
<div class="row">
	<div class="span12">
		<div class="btn-group">
			<?php foreach ($alph as $v): ?>
				<a href="#" class="btn <?= (in_array($v, $dis)) ? 'disabled ' : '' ?><?= ($v == $active) ? 'active' : '' ?>"><?= $v ?></a>
			<?php endforeach; ?>
		</div>
	</div>
</div>
<div class="row">
	<div class="span12">
		<table class="table table-striped table-hover">
			<thead>
				<tr>
					<th>#</th>
					<th>Nom</th>
					<th>Localisation</th>
					<th>Capacité maximale</th>
					<th>Actions</th>
				</tr>
			</thead>
			<tbody>
				<tr>
					<td>0</td>
					<td>bouh</td>
					<td>Liège</td>
					<td>15</td>
					<td>
						<a href="<?= url(array('action' => 'unit', 'view' => 'edit', 'params' => array('nom', 0))) ?>" class="btn primary">
							<span class="icon-edit"></span>
						</a>
						<a href="#" class="btn btn-danger confirm" data-content="Êtes-vous sur de vous ?" data-placement="bottom" data-text="Vraiment sur ?" data-trigger="hover" data-toggle="popover" data-title="Confirmation">
							<span class="icon-remove"></span>
						</a>
					</td>
				</tr>
				<tr>
					<td>0</td>
					<td>bouh</td>
					<td>Liège</td>
					<td>15</td>
					<td>
						<a href="<?= url(array('action' => 'unit', 'view' => 'edit', 'params' => array('nom', 0))) ?>" class="btn primary">
							<span class="icon-edit"></span>
						</a>
						<a href="#" class="btn btn-danger confirm" data-content="Êtes-vous sur de vous ?" data-placement="bottom" data-text="Vraiment sur ?" data-trigger="hover" data-toggle="popover" data-title="Confirmation">
							<span class="icon-remove"></span>
						</a>
					</td>
				</tr>
			</tbody>
		</table>
	</div>
</div>
