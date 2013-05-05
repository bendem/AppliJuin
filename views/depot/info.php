<?php $title_for_layout = 'Information sur ' . $d['nom'] ?>

<?php if(is_connected()): ?>
	<div class="row-fluid">
		<div class="span12">
			<a href="<?= url(array(
				'action' => 'command',
				'view' => 'add',
				'params' => array(
					2, $d['num']
				))) ?>" class="btn btn-block btn-large btn-info">
				<span class="icon-shopping-cart"></span>
				Effectuer un commande pour ce dépôt
			</a>
		</div>
	</div>
<?php endif ?>

<div class="row-fluid">
	<div class="span12">
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
				<tr>
					<td>Capacité de stockage</td>
					<td><?= $d['capaciteStockage'] ?></td>
				</tr>
				<tr>
					<td>Responsable</td>
					<td><?= empty($resp[$d['responsable']]) ? "Aucun" : $resp[$d['responsable']] ?></td>
				</tr>
				<tr>
					<td>Peut contenir des matières dangereuses</td>
					<td><?= $d['matiereDangereuse'] ? "oui" : "non" ?></td>
				</tr>
			</tbody>
		</table>
	</div>
</div>
