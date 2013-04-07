<div class="navbar navbar-fixed-top">
	<div class="navbar-inner">
		<div class="container">
			<a class="brand" href="<?= key($brand) ?>"><?= end($brand) ?></a>
			<ul class="nav">
				<?php foreach($nav as $url => $text): ?>
					<li<?= (is_active($url)) ? ' class="active"' : '' ?>>
						<a href="<?= $url ?>"><?= ucfirst($text) ?></a>
					</li>
				<?php endforeach; ?>
			</ul>
			<ul class="nav pull-right">
				<li class="dropdown">
					<a href="#" class="dropdown-toggle" data-toggle="dropdown">
						<?= ucfirst($right_text) ?> <span class="caret"></span>
					</a>
					<ul class="dropdown-menu">
						<?php foreach($right as $url => $text): ?>
							<?php if($text == "divider"): ?>
								<li class="divider"></li>
							<?php else: ?>
								<li><a href="<?= $url ?>"><?= ucfirst($text) ?></a></li>
							<?php endif; ?>
						<?php endforeach; ?>
					</ul>
				</li>
			</ul>
		</div>
	</div>
</div>