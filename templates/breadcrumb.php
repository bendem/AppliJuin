<div class="row">
	<div class="span12">
		<ul class="breadcrumb">
			<?php if($req['view'] == 'index'): ?>
				<li class="active"><a href="<?= url($req) ?>" class="muted"><?= ucfirst($req['action']) ?></a></li>
			<?php else: ?>
				<li class="muted">
					<a href="<?= url(array('action' => $req['action'])) ?>"><?= ucfirst($req['action']) ?></a>
					<span class="divider">/</span>
				</li>
				<li class="active"><a href="<?= url($req) ?>" class="muted"><?= ucfirst($req['view']) ?></a></li>
			<?php endif; ?>
			<?php if(!empty($req['params'])): ?>
				<?php foreach($req['params'] as $v): ?>
					<li class="muted">
						<span class="divider">/</span>
						<a href="<?= url($req) ?>" class="muted"><?= $v ?></a>
					</li>
				<?php endforeach; ?>
			<?php endif; ?>
		</ul>
	</div>
</div>
