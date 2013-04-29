<?php $title_for_layout = 'Commandes' ?>

<div class="row-fluid">
	<div class="span12">
		<a href="<?= url(array('action' => $req['action'], 'view' => 'add')) ?>" class="btn btn-block btn-large btn-info">Nouvelle commande</a>
	</div>
</div>

<div class="row-fluid">
	<div class="span12">
		<table class="table">
			<thead>
				<tr>
					<th>#</th>
					<th>Date</th>
					<th>Unité</th>
					<th>Dépôt</th>
					<th>Actions</th>
				</tr>
			</thead>
			<tbody>
				<tr>
					<td>lol</td>
					<td>lol</td>
					<td>lol</td>
					<td>lol</td>
					<td>
						<?= actions($req['action'], array('', ''), $del_confirm) ?>
					</td>
				</tr>
			</tbody>
		</table>
	</div>
</div>
