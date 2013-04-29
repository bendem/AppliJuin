<?php $title_for_layout = 'Information sur ' . $nom ?>

<div class="row-fluid">
	<div class="span12">
		<?php foreach($data as $k => $v): ?>
			<dl>
				<dt><?= $k ?></dt>
				<dd><?= $v ?></dd>
			</dl>
		<?php endforeach; ?>
	</div>
</div>
