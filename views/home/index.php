<?php $title_for_layout = 'Accueil <small>Voici une appli php !</small>' ?>

<div class="row-fluid">
	<div class="span6">
		<h3>Dernières commandes</h3>
		<table class="table table-striped table-hover">
			<thead>
				<tr>
					<th>Date</th>
					<th>De</th>
					<th>A</th>
					<th>Action</th>
				</tr>
			</thead>
			<tbody>
				<?php foreach($commands as $v): ?>
					<tr>
						<td><?= date('d-m-Y', strtotime($v['dateCommande'])) ?></td>
						<td><?= $v['nom_unite'] ?></td>
						<td><?= $v['nom_depot'] ?></td>
						<td>
							<a href="<?= url(array(
								'action' => 'command',
								'view' => 'info',
								'params' => array($v['num'])
							)) ?>" class="btn btn-success" data-toggle="tooltip" data-title="Informations">
								<span class="icon-list"></span>
							</a>
						</td>
					</tr>
				<?php endforeach; ?>
			</tbody>
		</table>
	</div>
	<div class="span6">
		<h3>Derniers produits</h3>
		<table class="table table-striped table-hover">
			<thead>
				<tr>
					<th>#</th>
					<th>Nom</th>
					<th>Action</th>
				</tr>
			</thead>
			<tbody>
				<?php foreach($products as $v): ?>
					<tr>
						<td><?= $v['num'] ?></td>
						<td><?= $v['nom'] ?></td>
						<td>
							<a href="<?= url(array(
								'action' => 'product',
								'view' => 'info',
								'params' => array($v['num'])
							)) ?>" class="btn btn-success" data-toggle="tooltip" data-title="Informations">
								<span class="icon-list"></span>
							</a>
						</td>
					</tr>
				<?php endforeach; ?>
			</tbody>
		</table>
	</div>
</div>

<div class="row-fluid">
	<div class="span6">
		<h3>Derniers dépôts</h3>
		<table class="table table-striped table-hover">
			<thead>
				<tr>
					<th>Nom</th>
					<th>Ville</th>
					<th>Action</th>
				</tr>
			</thead>
			<tbody>
				<?php foreach($depots as $v): ?>
					<tr>
						<td><?= $v['nom'] ?></td>
						<td><?= $v['ville'] ?></td>
						<td>
							<a href="<?= url(array(
								'action' => 'depot',
								'view' => 'info',
								'params' => array($v['num'])
							)) ?>" class="btn btn-success" data-toggle="tooltip" data-title="Informations">
								<span class="icon-list"></span>
							</a>
						</td>
					</tr>
				<?php endforeach; ?>
			</tbody>
		</table>
	</div>
	<div class="span6">
		<h3>Dernières unités</h3>
		<table class="table table-striped table-hover">
			<thead>
				<tr>
					<th>Nom</th>
					<th>Ville</th>
					<th>Action</th>
				</tr>
			</thead>
			<tbody>
				<?php foreach($units as $v): ?>
					<tr>
						<td><?= $v['nom'] ?></td>
						<td><?= $v['ville'] ?></td>
						<td>
							<a href="<?= url(array(
								'action' => 'unit',
								'view' => 'info',
								'params' => array($v['num'])
							)) ?>" class="btn btn-success" data-toggle="tooltip" data-title="Informations">
								<span class="icon-list"></span>
							</a>
						</td>
					</tr>
				<?php endforeach; ?>
			</tbody>
		</table>
	</div>
</div>
