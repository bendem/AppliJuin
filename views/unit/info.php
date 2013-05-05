<?php $title_for_layout = 'Information sur ' . $d['nom'] ?>

<?php if(is_connected()): ?>
	<div class="row-fluid">
		<div class="span12">
			<a href="<?= url(array(
				'action' => 'command',
				'view' => 'add',
				'params' => array(
					1, $d['num'] // le 1 sert à préciser que c'est une unité de fabrication
				))) ?>" class="btn btn-block btn-large btn-info">
				<span class="icon-shopping-cart"></span>
				Effectuer une commande depuis cette unité
			</a>
		</div>
	</div>
<?php endif ?>

<div class="row-fluid">
	<table class="table table-striped table-hover">
		<thead>
			<tr>
				<th>Champ</th>
				<th>Valeur</th>
			</tr>
		</thead>
		<tbody>
			<tr>
				<td>Numéro</td>
				<td><?= $d['num'] ?></td>
			</tr>
			<tr>
				<td>Nom</td>
				<td><?= $d['nom'] ?></td>
			</tr>
			<tr>
				<td>Capacité Maximale</td>
				<td><?= $d['capaciteMax'] ?></td>
			</tr>
			<tr>
				<td>Adresse</td>
				<td><?= $d['adresse'] ?></td>
			</tr>
			<tr>
				<td>Ville</td>
				<td><?= $d['ville'] ?></td>
			</tr>
			<tr>
				<td>Code Postal</td>
				<td><?= $d['cp'] ?></td>
			</tr>
		</tbody>
	</table>
</div>
