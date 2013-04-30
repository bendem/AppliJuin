<?php $title_for_layout = 'Gestion des stocks' ?>

<div class="row-fluid">
	<div class="span12">
		<a href="<?= url(array('action' => $req['action'], 'view' => 'add')) ?>" class="btn btn-block btn-large btn-info">Ajouter un produit en stock</a>
	</div>
</div>

<div class="row-fluid">
	<div class="span12">
		<table class="table table-striped table-hover">
			<thead>
				<tr>
					<th>Produit</th>
					<th>Dépôt</th>
					<th>Quantité</th>
					<th>Actions</th>
				</tr>
			</thead>
			<tbody>
				<?php foreach($data as $v): ?>
					<tr>
						<td>jflezl</td>
						<td>lrzn</td>
						<td>td znflhizg</td>
						<td>
							<?= actions($req['action'], array($v['num']), $del_confirm) ?>
						</td>
					</tr>
				<?php endforeach; ?>
			</tbody>
		</table>
	</div>
</div>
