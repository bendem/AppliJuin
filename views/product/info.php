<?php $title_for_layout = 'Information sur ' . $d['nom'] ?>

<?php if(is_connected()): ?>
	<div class="row-fluid">
		<div class="span12">
			<a href="<?= url(array(
				'action' => 'command',
				'view' => 'add',
				'params' => array(
					3, $d['num']
				))) ?>" class="btn btn-block btn-large btn-info <?= $d['quantite'] ? '' : 'disabled' ?>">
				<span class="icon-shopping-cart"></span>
				Commander ce produit
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
					<td>Unité de mesure</td>
					<td><?= $d['uniteMesure'] ?></td>
				</tr>
				<tr>
					<td>Prix</td>
					<td><?= $d['prix'] . SYMBOLE_PRIX ?></td>
				</tr>
				<tr>
					<td>Type</td>
					<td><?= $d['type'] ?></td>
				</tr>
				<tr>
					<td>Matières dangereuse</td>
					<td><?= $d['categorie'] ? "oui" : "non" ?></td>
				</tr>
			</tbody>
		</table>
	</div>
</div>
