<?php $title_for_layout = 'Produits' ?>

<div class="row-fluid">
	<div class="span12">
		<div class="btn-group">
			<?php foreach ($alph as $v): ?>
				<a href="<?= url(array_merge($req, array('params' => array(strtolower($v))))) ?>" class="btn <?= (!in_array($v, $enabled)) ? 'disabled ' : '' ?><?= ($v == $active) ? 'active' : '' ?>"><?= $v ?></a>
			<?php endforeach; ?>
		</div>
	</div>
</div>
<div class="row-fluid">
	<div class="span12">
		<table class="table table-striped table-hover">
			<thead>
				<tr>
					<th>#</th>
					<th>Nom</th>
					<th>Unité de mesure</th>
					<th>Prix</th>
					<th>Type</th>
					<th>Matière dangereuse</th>
					<?php if(is_connected()): ?>
						<th>Actions</th>
					<?php endif; ?>
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
						<?php if(is_connected()): ?>
							<td>
								<a href="<?= url(array('action' => 'product', 'view' => 'edit', 'params' => array($v['nom'], $v['num']))) ?>" class="btn primary">
									<span class="icon-edit"></span>
								</a>
								<a href="#" class="btn btn-danger" data-content="<?php printf($del_confirm, $v['nom'], $v['num']) ?>" data-html="true" data-placement="bottom" data-text="Vraiment sur ?" data-trigger="click" data-toggle="popover" data-title="Confirmation">
									<span class="icon-remove"></span>
								</a>
							</td>
						<?php endif; ?>
					</tr>
				<?php endforeach; ?>
			</tbody>
		</table>
	</div>
</div>