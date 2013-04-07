<!DOCTYPE html>
<html>
	<head>
		<meta charset="UTF-8">
		<script src="<?= webroot('js/jquery.js') ?>"></script>
		<script src="<?= webroot('js/bootstrap.min.js') ?>"></script>
		<script src="<?= webroot('js/holder.js') ?>"></script>
		<script src="<?= webroot('js/main.js') ?>"></script>
		<link rel="stylesheet" href="<?= webroot('css/bootstrap.min.css') ?>">
		<link rel="stylesheet" href="<?= webroot('css/style.css') ?>">
		<title><?= (isset($title_for_layout)) ? $title_for_layout : 'AppliJuin' ?></title>
	</head>
	<body>

		<?= nav() ?>

		<div class="container">

			<?= breadcrumb($req); ?>

			<?= session_flash(); ?>

			<div class="row">
				<div class="span12">
					<?= $content_for_layout ?>
				</div>
			</div>
			<footer>
				<div class="pull-right muted">
					Travail de fin d'année 2012-2013 ++ [PHP] <span class="icon-road" style="font-size: 14px;"></span>
				</div>
				<div class="pull-left">
					<span class="muted">&copy;</span> <a href="http://wtlink.be">bendem</a>
				</div>
			</footer>
		</div>
	</body>
</html>