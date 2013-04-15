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
		<title><?= (isset($title_for_layout)) ? preg_replace('#<.*>.*</.*>#i', '', $title_for_layout) . ' - ' : '' ?>AppliJuin</title>
	</head>
	<body>

		<?= nav_top() ?>

		<div class="container-fluid">

			<?= breadcrumb($req); ?>
			<?= session_flash(); ?>

			<div class="row-fluid">
				<div class="span12">
					<div class="page-header">
						<h1><?= (isset($title_for_layout)) ? $title_for_layout : 'AppliJuin' ?></h1>
					</div>
				</div>
			</div>

			<div class="row-fluid">
				<div class="span2">

					<?= nav_sidebar() ?>

				</div>
				<div class="span10">

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
