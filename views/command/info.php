<?php $title_for_layout = 'Information sur la commande n°' . $command['num']; ?>
<?php $total = 0; ?>

<div class="row-fluid">
	<div class="span1">
		<strong>De</strong>
	</div>
	<div class="span2">
		<address>
			<strong><?= $command['nomUnite'] ?></strong><br>
			<?= $command['adresseUnite'] ?><br>
			<?= $command['villeUnite'] ?>, <?= $command['cpUnite'] ?>
		</address>
	</div>
	<div class="offset6 span1">
		<strong>à</strong>
	</div>
	<div class="span2">
		<address>
			<strong><?= $command['nomDepot'] ?></strong><br>
			<?= $command['adresseDepot'] ?><br>
			<?= $command['villeDepot'] ?>, <?= $command['cpDepot'] ?>
		</address>
	</div>
</div>

<div class="row-fluid">
	<div class="span12">
		<h3>Détails de la commande</h3>
		<table class="table table-striped table-hover">
			<thead>
				<th>Numéro de produit</th>
				<th>Nom du produit</th>
				<th>Prix unitaire</th>
				<th>Quantité</th>
				<th>Prix total</th>
			</thead>
			<tbody>
				<?php foreach($d as $v): ?>
					<tr>
						<td><?= $v['numProduit'] ?></td>
						<td><?= $v['nom'] ?></td>
						<td><?= $v['prix'] . SYMBOLE_PRIX ?></td>
						<td><?= $v['quantite'] ?></td>
						<td><?= $v['quantite'] * $v['prix'] . SYMBOLE_PRIX ?></td>
						<?php $total += $v['quantite'] * $v['prix']; ?>
					</tr>
				<?php endforeach; ?>
				<tr>
					<td colspan="3"></td>
					<td>
						<strong>Total à payer</strong>
					</td>
					<td>
						<strong><?= $total . SYMBOLE_PRIX ?></strong>
					</td>
				</tr>
			</tbody>
		</table>
	</div>
</div>
