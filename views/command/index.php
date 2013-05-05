<?php $title_for_layout = 'Commandes' ?>

<?php if(is_connected()): ?>
	<div class="row-fluid">
		<div class="span12">
			<a href="<?= url(array('action' => $req['action'], 'view' => 'add')) ?>" class="btn btn-block btn-large btn-info">Nouvelle commande</a>
		</div>
	</div>
<?php endif; ?>

<div class="row-fluid">
	<div class="span12">
		<table class="table table-striped table-hover">
			<thead>
				<tr>
					<th>#</th>
					<th>Date</th>
					<th>Numéro de l'unité</th>
					<th>Nom de l'unité</th>
					<th>Numéro de dépôt</th>
					<th>Nom du dépôt</th>
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
						<td><?= date('d-m-Y', strtotime($v['dateCommande'])) ?></td>
						<td><?= $v['numUnite'] ?></td>
						<td><?= $v['nom_unite'] ?></td>
						<td><?= $v['numDepot'] ?></td>
						<td><?= $v['nom_depot'] ?></td>
						<td><?= actions($req['action'], array($v['num']), $del_confirm) ?></td>
					</tr>
				<?php endforeach; ?>
			</tbody>
		</table>
	</div>
</div>
