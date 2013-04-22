<div class="well well-nav">
	<ul class="nav nav-list">
		<li class="nav-header">Navigation</li>
		<?php foreach($nav as $url => $text): ?>
			<li<?= (is_active($url)) ? ' class="active"' : '' ?>>
				<a href="<?= $url ?>"><?= ucfirst($text) ?></a>
			</li>
		<?php endforeach; ?>
		<li class="nav-header">Compte</li>
		<?php foreach($navAccount as $url => $text): ?>
			<li<?= (is_active($url, true)) ? ' class="active"' : '' ?>>
				<a href="<?= $url ?>"><?= ucfirst($text) ?></a>
			</li>
		<?php endforeach; ?>
	</ul>
</div>
