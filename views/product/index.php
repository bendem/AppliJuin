<?php $title_for_layout = 'Produits' ?>

<?php if(is_connected()): ?>
	<div class="row-fluid">
		<div class="span12">
			<a href="<?= url(array('action' => $req['action'], 'view' => 'add')) ?>" class="btn btn-block btn-large btn-info">
				Ajouter un produit
			</a>
		</div>
	</div>
<?php endif; ?>

<div class="row-fluid">
	<div class="span12">
		<table class="table table-striped table-hover">
			<thead>
				<tr>
					<th>#</th>
					<th>Nom</th>
					<th>Unité de mesure</th>
					<th>
						<a href="<?= url($tri) ?>" data-toggle="tooltip" data-title="Tri ascendant">
							Prix
						</a>
					</th>
					<th>Type</th>
					<th>Matière dangereuse</th>
					<th>Actions</th>
				</tr>
			</thead>
			<tbody>
				<?php if(empty($data)): ?>
					<tr>
						<td colspan="7" style="text-align: center;">
							<div class="alert alert-error">Pas de données</div>
						</td>
					</tr>
				<?php endif; ?>
				<?php foreach($data as $v): ?>
					<tr>
						<td><?= $v['num'] ?></td>
						<td><?= $v['nom'] ?></td>
						<td><?= $v['uniteMesure'] ?></td>
						<td><?= $v['prix'] ?></td>
						<td><?= $v['type'] ?></td>
						<td>
							<?= ($v['categorie']) ? 'oui' : 'non' ?>
						</td>
						<td>
							<a href="<?= url(array(
								'action' => 'command',
								'view' => 'add',
								'params' => array(
									3, $v['num'] // le 3 sert à préciser que c'est un produit
								))) ?>" class="btn <?= ($v['quantite']) ? '' : 'disabled' ?>" data-toggle="tooltip" data-title="Effectuer une commande">
								<span class="icon-shopping-cart"></span>
							</a>
							<?= actions($req['action'], array($v['num']), $del_confirm) ?>
						</td>
					</tr>
				<?php endforeach; ?>
			</tbody>
		</table>
	</div>
</div>
