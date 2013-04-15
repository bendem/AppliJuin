<?php $title_for_layout = 'Unités de fabrication' ?>

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
					<th>Adresse</th>
					<th>CP</th>
					<th>Ville</th>
					<th>Capacité maximale</th>
					<?php if(is_connected()): ?>
						<th>Actions</th>
					<?php endif; ?>
				</tr>
			</thead>
			<tbody>
				<?php foreach($data as $v): ?>
					<tr>
						<td><?= $v['num'] ?></td>
						<td><?= $v['nom'] ?></td>
						<td><?= $v['adresse'] ?></td>
						<td><?= $v['ville'] ?></td>
						<td><?= $v['cp'] ?></td>
						<td><?= $v['capaciteMax'] ?></td>
						<?php if(is_connected()): ?>
							<td>
								<a href="<?= url(array('action' => 'unit', 'view' => 'edit', 'params' => array('nom', 0))) ?>" class="btn primary">
									<span class="icon-edit"></span>
								</a>
								<a href="#" class="btn btn-danger confirm" data-content="Êtes-vous sur de vous ?" data-placement="bottom" data-text="Vraiment sur ?" data-trigger="hover" data-toggle="popover" data-title="Confirmation">
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
